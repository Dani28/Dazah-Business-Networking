<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Messages extends CI_Controller
{
	public function js_search()
	{
		if ($this->input->is_ajax_request())
		{		    
		    $properties = array(
		        'query' => $this->input->get('term')
		    );
		    
		    $autocomplete = api_endpoint('autocomplete/search', $properties);
		    
		    $results = array();

		    foreach ($autocomplete AS $key => $value)
		    {
		        foreach ($value AS $row)
		        {    		        
    		        $results[] = array(
    		            'id' => $row,
    		            'value' => $row,
    		            'category' => ucfirst($key)
    		        );
		        }
		    }
		    
			$this->output
				->set_content_type('application/json')
				->set_output(json_encode($results));
		}
	}
	
	public function search($query = '', $offset = 0)
	{
		$query_string = $this->input->get('query');
		
		// We check the query string first
		if ($query_string === null)
		{
		    $query_string = $query;
		}
		
		// We check the URI first
		if (empty($offset))
		{
		    $offset = abs(intval($this->input->get('offset')));
		}
		
		// Decode the URL that we encoded in the Message helper fn
		$query_string = urldecode($query_string);		
				
		if (strlen($query_string) >= 2)
		{
		    $properties = array(
		        'offset' => $offset,
		        'limit' => 12,
		        'query' => $query_string
		    );
		    
		    $url = site_url('messages/search/' . urlencode($query_string));
		    
		    $page_nav = generate_page_nav($offset, 12, $url);
		    
		    // Retrieve users
		    $response = api_endpoint('users/search', $properties, false, $page_nav);
		    
		    // Determine our relationship with them
		    $users = user_matches($response);
		    
		    $this->wb_template->assign('users', $users);
		    $this->wb_template->assign('searched_users', $this->load->view('app/users/loop', $this->wb_template->get(), true), true);
		    
		    build_menu();
		    
		    $this->load->view('app/users/search', $this->wb_template->get());	    
		}
		else
		{
			$this->load->library('user_agent');
			
			// We just refresh the page if we can't do anything else
			redirect($this->agent->referrer());			
		}
	}
	
	public function report($offset = 0)
	{
	    $properties = array(
	        'offset' => $offset,
	        'limit' => 60
	    );
	    
	    $page_nav = generate_page_nav($offset, 60, site_url('messages/report'));
	    
	    // Retrieve conversations
	    $conversations = api_endpoint('conversations/report', $properties, false, $page_nav);
	    	    
	    $this->wb_template->assign('conversations', $conversations);
	    
	    build_menu();
	    
	    $this->load->view('app/messages/report', $this->wb_template->get());
	}
	
	public function view($id)
	{	
	    $id = decrypt_id($id);
	    
	    $request = array(
	        'url' => "conversations/$id/poll",
	        'params' => array(
	        'exclude_self' => false,
	        'record_seen' => true,
	        'time_limit' => 0
        )
	    );
	    
	    $messages = page_request($request, true);
	    	    
	    if (!empty($messages))
	    {
	        // Retrieve the conversation
	        $conversation = api_endpoint("conversations/$id");
	        
	        $output = process_messages($messages);
	        	        
	        // Send to the templates
	        $this->wb_template->assign('parsed_messages', $output['parsed_messages'], true);
	        $this->wb_template->assign('latest_message_id', $output['message_id']);
	         
	        $this->wb_template->assign('conversation', $conversation[0]);
	        $this->wb_template->assign('user', extract_user($conversation[0]));
	        	        
	        // Generate their profile
	        $this->wb_template->assign('profile_fragment', $this->load->view('app/profile/fragment', $this->wb_template->get(), true), true);
	        	    	    	        
	        $this->load->view('app/messages/view', $this->wb_template->get());
	    }
	    else
	    {
	        show_404();
	    }
	}
	

	public function js_poll()
	{
	    if ($this->input->is_ajax_request())
	    {
    	    // Retrieve ID #
    	    $conversation_id = intval($this->input->post('conversation_id'));
    	
    	    // The latest message ID that we saw
    	    $message_id = intval($this->input->post('message_id'));
    	
    	    $properties = array(
    	        'message_id' => $message_id,
    	        'exclude_self' => true,
    	        'record_seen' => true,
    	        'time_limit' => 15
    	    );
    	
    	    // Call the API endpoint
    	    $messages = api_endpoint("conversations/$conversation_id/poll", $properties, true);
    	
    	    if (!empty($messages))
    	    {
    	        // Process the messages that exist
    	        $processed_messages = process_messages($messages);
    	        	
    	        $output['message_id'] = $processed_messages['message_id'];
    	        $output['html'] = $processed_messages['parsed_messages'];
    	    }
    	    else
    	    {
    	        // Just spit back out the message ID passed in
    	        //  It's still the latest message ID that we saw
    	        $output['message_id'] = $message_id;
    	    }
    	    
    	    // Now let's retrieve *all* recent messages so we can use the Last Poll info
    	    	    	
    	    $output['last_seen'] = last_seen($conversation_id);
    		
    	    $this->output
        	    ->set_content_type('application/json')
        	    ->set_output(json_encode($output));
	    }
	
	}
	
	public function js_notifications()
	{
	    if ($this->input->is_ajax_request())
	    {
    	    $conversation_ids = $this->input->post('conversation_ids');
    	    $user_ids = $this->input->post('user_ids');
    	    
    	    // If converastions exist to get notified about
    	    if (!empty($conversation_ids) AND !empty($user_ids))
    	    {
        	    $notifications = fetch_notifications($conversation_ids, $user_ids);
        	    
        	    $this->output
            	    ->set_content_type('application/json')
            	    ->set_output(json_encode($notifications));
    	    }
	    }
	}
	
	public function js_post()
	{
	    if ($this->input->is_ajax_request())
	    {
    	    $conversation_id = $this->input->post('conversation_id');
    	    $message = $this->input->post('message');
    	    
            $properties = array(
                'message' => $message
            );
    
            // Submit the new message
            //  Be happy that the api_endpoint() function handles errors
            $new_message = api_endpoint("conversations/$conversation_id/post", $properties, true);
            
            // Set the timestamp to now
            $new_message->{'timestamp'} = date('c', now());
    
            // Fake us as the user here
            $users = array(
                $new_message->author->id => who_am_i()
            );
    
            // Parse the new message
            $this->wb_template->assign('users', $users);
            $this->wb_template->assign('messages', array($new_message));
            $parsed_messages = $this->load->view('app/messages/loop', $this->wb_template->get(), true);
    	
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(array(
                    'html' => $parsed_messages,
                    'message_id' => $new_message->id
                )));
	    }

	}
	
	public function js_archive()
	{
		if ($this->input->is_ajax_request())
		{
			$conversation_id = $this->input->post('id');
				
		    // Archive it
	        api_endpoint("conversations/$conversation_id/archive", array(), true);
		}
	}

}