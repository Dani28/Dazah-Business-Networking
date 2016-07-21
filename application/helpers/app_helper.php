<?php

// This function will process all of our API endpoints
function api_endpoint($endpoint, $properties = array(), $page_nav = array())
{
    // TODO: Instead of using global variables, everything OAuth related should really be in its own class
    
    global $ACCESS_TOKEN, $CURL_HANDLER;
    
    $CI =& get_instance();
    
    if ($CURL_HANDLER === null)
    {
        // This is the first time we are using cURL for this request, so initialize a new cURL handler
        $CURL_HANDLER = curl_init("https://www.dazah.com/api/$endpoint?access_token=$ACCESS_TOKEN");
        curl_setopt($CURL_HANDLER, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($CURL_HANDLER, CURLOPT_TIMEOUT, 20);
        curl_setopt($CURL_HANDLER, CURLOPT_ENCODING, '');
        curl_setopt($CURL_HANDLER, CURLOPT_HEADER, false);
    }
    else
    {
        // Let's just change the URL for the existing cURL handler
        curl_setopt($CURL_HANDLER, CURLOPT_URL, "https://www.dazah.com/api/$endpoint?access_token=$ACCESS_TOKEN");
    }
    
    // Set for just this request
    
    if (!empty($properties))
    {
        curl_setopt($CURL_HANDLER, CURLOPT_POST, true);        
    }
    else
    {
        curl_setopt($CURL_HANDLER, CURLOPT_HTTPGET, true);
    }
    
    curl_setopt($CURL_HANDLER, CURLOPT_POSTFIELDS, $properties);

    // Execute the cURL request
    $response = curl_exec($CURL_HANDLER);
    
    // var_dump(curl_getinfo(($CURL_HANDLER)));
                
    // Determine if the response told us the token was invalid
    if (detect_expired_token($response) !== false)
    {
        // Token was expired, so we refreshed it and now we want to rerun this API endpoint
        //  Recursion!
        return api_endpoint($endpoint, $properties, $page_nav);
    }
         
    return process_response($response, $page_nav);
}

// Go through the OAuth flow
function retrieve_access_token()
{
    global $ACCESS_TOKEN;

    $CI =& get_instance();
        
    // First attempt to get/save the access token as a cookie instead of going through OAuth on every single page load
    
    $ACCESS_TOKEN = $CI->input->cookie('access_token');
    
    if ($ACCESS_TOKEN === null)
    {           
        $CI->config->load('dazah');
        
        $oauth_credentials = array(
            'client_id' => $CI->config->item('client_id'),
            'client_secret' => $CI->config->item('client_secret'),
            'scope' => $CI->config->item('scope')
        );
        
        $current_url = site_url(uri_string());
        
        if (!$CI->input->get('code'))
        {
            redirect("https://www.dazah.com/oauth/auth?response_type=code&client_id={$oauth_credentials['client_id']}&scope={$oauth_credentials['scope']}&redirect_uri=".urlencode($current_url));
        }
        
        $ch = curl_init('https://www.dazah.com/oauth/access_token');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_ENCODING, '');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, array(
            'code' => $CI->input->get('code'),
            'redirect_uri' => $current_url,
            'client_id' => $oauth_credentials['client_id'],
            'client_secret' => $oauth_credentials['client_secret'],
            'grant_type' => 'authorization_code',
        ));
         
        $response = json_decode(curl_exec($ch));
        
        curl_close($ch);
        
        // Access token granted
        if (isset($response->access_token))
        {
            // Store the access token somewhere
            $CI->input->set_cookie('access_token', $response->access_token, $response->expires_in);
            
            $ACCESS_TOKEN = $response->access_token;
        }
        else
        {
            redirect(current_url());
        }
    }
}

function detect_expired_token($response)
{
    $CI =& get_instance();

    $response = json_decode($response);

    if (isset($response->status))
    {
        if ($response->status == 'token_expired')
        {
            // Expired access token so let's refresh it
            retrieve_access_token();

            return true;
        }
    }

    return false;
}

function who_am_i()
{
    global $WHO_AM_I;
    
    if ($WHO_AM_I === null)
    {
        // First time we are requesting this, so let's fetch it from the API
        $WHO_AM_I = api_endpoint('users/~');
    }
    
    return $WHO_AM_I;
}

// Show a friendly error message if the API, and otherwise just return the data portion of the response
function process_response($response, $page_nav = array())
{
    $CI =& get_instance();

    $response = json_decode($response);

    if (isset($response->error))
    {
        if ($CI->input->is_ajax_request())
        {
            // If it's an AJAX request, spit out JSON
            $CI->output
                ->set_content_type('application/json')
                ->set_output(json_encode(array('error' => $response->error)));
            $CI->output->_display();
            exit;
        }
        else 
        {
            // Friendly error message
            show_error($response->error);
        }
    }
    else if (isset($response->errors))
    {
        
        // Build an array of errors (as opposed to the object it currently is)
        $errors = array();

        foreach ($response->errors AS $key => $value)
        {
            $errors[] = $value;
        }
        
        if ($CI->input->is_ajax_request())
        {
            $CI->output
                ->set_content_type('application/json')
                ->set_output(json_encode(array('errors' => $errors)));
            $CI->output->_display();
            exit;
        }
        else 
        {
            show_error(implode("\n", $errors));
        }
    }
    else if (isset($response->data))
    {
        if (isset($response->pagination))
        {            
            $CI->load->library('pagination');
            
            $page_nav = array_merge($page_nav, array(
                'total_rows' => $response->pagination->total_records,
                'per_page' => $response->pagination->limit,
            ));
                                    
            // Initialize page navigation with all of the parameters we have
            $CI->pagination->initialize($page_nav);
            
            // Send the page navigation links to the template
            $CI->wb_template->assign('pagination', $CI->pagination->create_links(), true);
        }

        return $response->data;
    }
}


function deep_clone($array)
{
    if (is_array($array))
    {
        $clone = array();
         
        foreach ($array AS $key => $value)
        {
            if (is_object($value))
            {
                $clone[$key] = clone $value;
            }
            else
            {
                $clone[$key] = $value;
            }
        }
         
        return $clone;
    }
    else if (is_object($array))
    {
        $clone = clone $array;

        return $clone;
    }
    else
    {
        return $array;
    }
}

function encrypt_id($id = 0)
{
    $CI =& get_instance();

    return base_convert($id, 10, 36);
}

function decrypt_id($id = 0)
{
    $CI =& get_instance();

    return intval(base_convert($id, 36, 10));
}

/*************************************************************************************************************************************************************************************************************/
/*************************************************************************************************************************************************************************************************************/

// Fetch the User object that we are interacting with in a conversation
function extract_user($conversation)
{    
    if (isset($conversation->user_a->profile->first_name) AND $conversation->user_a->id != who_am_i()->id)
    {
        $user = $conversation->user_a;
    }
    else
    {
        $user = $conversation->user_b;
    }
    
    if ($user->id == who_am_i()->id)
    {
        return who_am_i();
    }
    
    return $user;
}

function profile_url($user)
{
    return site_url('profile/view/' . encrypt_id($user->id));
}

function conversation_url($conversation_id)
{
    return site_url('messages/view/' . encrypt_id($conversation_id));
}

// Generate the User's location
function get_location($user)
{
    $location = '';
    
    if (isset($user->location->city))
    {
        $location = $user->location->city . ', ';
    }
    if (isset($user->location->region))
    {
        $location .= $user->location->region . ', ';
    }
    if (isset($user->location->country))
    {
        $location .= $user->location->country;
    }
    
    return $location;
}

function is_online($user)
{    
    return isset($user->usage->online_status) ? $user->usage->online_status : false;
}

function payment_link($user)
{
    // Retrieve the URL
    $url = $user->meet->payment->paypal->url;
    
    // Break it down into components
    $components = parse_url($url);
    
    // Split the query string
    parse_str(htmlspecialchars_decode($components['query']), $query_data);
    
    // Overwrite these values
    $query_data['return'] = site_url('payments/process/' . encrypt_id($user->id));
    $query_data['cancel_return'] = site_url('profile/view/' . encrypt_id($user->id));
    
    // Replace the query string
    $components['query'] = http_build_query($query_data);
        
    return $components['scheme'] . '://' . $components['host'] . $components['path'] . '?' . $components['query'];
}

// Relative time based on the API timestamp
function timestamp($timestamp)
{    
    $unix_timestamp = date('U', strtotime($timestamp));
    
    if ($unix_timestamp >= now() - 30)
    {
        return 'Now';
    }
    
    return strtok(timespan(	$unix_timestamp    ,    now()    ), ',') . ' Ago';
}

function user_matches($response)
{
    // For each user we retrieved from an API response, determine our relationship with them
    
    $users = array();
    $user_ids = array();
    
    foreach ($response AS $user)
    {
        $users[] = $user->user;
        $user_ids[] = $user->user->id;
    }
    
    $matches = api_endpoint('users/' . implode(';', $user_ids) . '/match');

    for ($i = 0; $i < count($users); $i++)
    {
        $users[$i] = array_merge_recursive((array)$users[$i], (array)$matches[$i]);
    }
    
    return json_decode(json_encode($users));
}

/*************************************************************************************************************************************************************************************************************/
/*************************************************************************************************************************************************************************************************************/

// Process the polling response
function process_messages($messages)
{
    $CI =& get_instance();

    $last_seen = array();
    
    $user_ids = array();

    // Loop through each message and retrieve the author IDs
    foreach ($messages AS $message)
    {
        $user_ids[] = $message->author->id;
        if (isset($message->last_seen))
        {
            $last_seen[$message->id] = $message->last_seen;
        }
    }
    
    // Retrieve information about the users we found
    
    foreach (api_endpoint('users/' . implode(';', array_unique($user_ids))) AS $user)
    {
        $users[$user->id] = $user;
    }
    
    
    // Parse all the messages
    $CI->wb_template->assign('users', $users);
    $CI->wb_template->assign('messages', $messages);
    $parsed_messages = $CI->load->view('app/messages/loop', $CI->wb_template->get(), true);
    
    // Pop the latest message off the stack to retrieve its ID
    $message_id = array_pop($messages)->id;

    return array(
        'parsed_messages' => $parsed_messages,
        'message_id' => $message_id,
        'last_seen' => $last_seen
    );
}

function fetch_notifications($conversation_ids, $user_ids)
{
    // Status notifications about our conversations
    
    $conversations = api_endpoint("conversations/" . implode(';', $conversation_ids) . "/status");
    $users = api_endpoint("users/" . implode(';', $user_ids));
                
    $results = array();
    
    for ($i = 0; $i < count($conversations); $i++)
    {
        $results[] = array(
            'conversation' => array(
                'id' => $conversations[$i]->conversation->id,
                'new_message_count' => $conversations[$i]->new_message_count > 0 ? $conversations[$i]->new_message_count : ''
            ),
            'user' => array(
                'online_status' => (isset($users[$i]->usage->online_status) AND $users[$i]->usage->online_status) ? true : false,
                'last_activity_timestamp' => isset($users[$i]->usage->last_activity_timestamp) ? timestamp($users[$i]->usage->last_activity_timestamp) : 'Unknown'
            )
        );
    }
    
    return $results;
}

function last_seen($conversation_id)
{
    $properties = array(
        'exclude_self' => false,
        'time_limit' => 0,
        'limit' => 100
    );

    // Call the API endpoint
    $messages = api_endpoint("conversations/$conversation_id/poll", $properties);
        
    foreach ($messages AS $message)
    {
        if (isset($message->last_seen))
        {
            $last_seen[$message->id] = timestamp($message->last_seen->timestamp);
        }
    }
    
    return $last_seen;
}

// Conversation list in sidebar
function build_conversations_sidebar()
{
    $CI =& get_instance();
            
    $properties = array(
        'include_archived' => false,
        'offset' => 0,
        'limit' => 100
    );   

    // Fetch active conversations
    $conversations = api_endpoint('conversations/report', $properties);
        
    $CI->wb_template->assign('conversations', $conversations);   
    
    $sidebar = $CI->load->view('app/sidebar', $CI->wb_template->get(), true);   
    
    $CI->wb_template->assign('sidebar', $sidebar, true);    
}

function generate_page_nav($offset = 0, $per_page = 50, $url = null)
{
    $CI =& get_instance();

    // Offset must be a positive integer (or 0)
    $offset = abs(intval($offset));

    // Per page cannot be less than 0 or greater than 100
    $per_page = max(1, intval($per_page));
    $per_page = min(intval($per_page), 100);

    // Determine the page based on the offset
    $page = ceil($offset + 1 / $per_page);

    $page_nav = array(
        'base_url' => $url,
        'first_url' => $url,
        'per_page' => $per_page,
        'offset' => $offset
    );

    if ($page == 1)
    {
        $page_nav['uri_segment'] = $CI->uri->total_segments() + 1;
    }
    else
    {
        $page_nav['uri_segment'] = $CI->uri->total_segments();
    }

    return $page_nav;
}