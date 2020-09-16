<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// This class allows users to sign up or log in
class Users extends CI_Controller
{
	public function js_unblock()
	{	    
		if ($this->input->is_ajax_request())
		{
		    $user_id = $this->input->post('id');
		    
		    api_endpoint("users/$user_id/unmute", array(), true);
		}		
	}

	public function skipped($order_by = 'last_activity', $offset = 0)
	{			
		$page_nav = generate_page_nav($offset, 50, site_url("users/skipped/$order_by"));
		
		$request = array(
		    'url' => 'users/skipped',
		    'params' => array(
    		    'order_by' => $order_by,
    		    'offset' => $offset
		    )
		);
		
		$response = page_request($request, false, $page_nav);
		
		$this->wb_template->assign('skipped_users', $response);
			
		$this->load->view('app/users/skipped', $this->wb_template->get());
	}	
	
	public function blocked($order_by = '', $offset = 0)
	{		
		$page_nav = generate_page_nav($offset, 50, site_url("users/blocked/$order_by"));

		$request = array(
		    'url' => 'users/muted',
		    'params' => array(
		        'order_by' => $order_by,
		        'offset' => $offset
		    )
		);
		
		$response = page_request($request, false, $page_nav);
		
		$this->wb_template->assign('blocked_users', $response);
			
		$this->load->view('app/users/blocked', $this->wb_template->get());
	}
	
	public function nearby($offset = 0)
	{
		$page_nav = generate_page_nav($offset, 12, site_url('users/nearby'));
				
		// Retrieve users
		
		$request = array(
		    'url' => 'users/nearby',
		    'params' => array(
		        'limit' => 12,
		        'offset' => $offset
		    )
		);
				
		$response = page_request($request, false, $page_nav);	
		
		// Determine our relationship with them
		$users = user_matches($response);
				
		$this->wb_template->assign('users', $users);
		$this->wb_template->assign('nearby_users', $this->load->view('app/users/loop', $this->wb_template->get(), true), true);
			    	    
	    $this->load->view('app/users/nearby', $this->wb_template->get());
	}
	
	public function search($offset = 0)
	{
	    $this->wb_template->assign('no_sidebar', true);
	    build_menu();
	     	    
	    // Retrieve all form data
		$query = $this->input->get();
		
		if (!empty($query))
		{    		
    		// We check the URI first
    		if (empty($offset))
    		{
    		    $offset = abs(intval($this->input->get('offset')));
    		}
    			
    	    $properties = array(
    	        'offset' => $offset,
    	        'limit' => 12
    	    );
    	    
    	    // Fields we want to search against
    	    $fields = array(
    	        'first_name',
    	        'last_name',
    	        'headline',
    	        'pitch',
    	        'city',
    	        'region',
    	        'country',
    	        'metadata_tags'
    	    );
    	    
    	    // Loop through each field
    	    foreach ($fields AS $field)
    	    {
    	        // If field exists and has data
    	        if (isset($query[$field]) AND !empty($query[$field]))
    	        {    	        
        	        $properties[$field] = '';
        	        
        	        // If a weight is set and not empty
        	        if (isset($query[$field . '_weight']) AND !empty($query[$field . '_weight']))
        	        {
        	            $properties[$field] = $query[$field . '_weight'] . ':';
        	        }
        	        
        	        $properties[$field] .= $query[$field];
    	        }       
    	    }
    	    	    
    	    $url = site_url('users/search');
    	    
    	    $page_nav = generate_page_nav($offset, 12, $url);
    	    
    	    // Retrieve one page of users
    	    $response = api_endpoint('users/search', $properties, false, $page_nav);
    	    
    	    // Determine our relationship with them
    	    $users = user_matches($response);
		}
		else
		{
		    $users = array();
		}
	    
	    $this->wb_template->assign('users', $users);
	    $this->wb_template->assign('searched_users', $this->load->view('app/users/loop', $this->wb_template->get(), true), true);
	    
	    // Advanced Search Form
	    $this->wb_template->assign('query', $query);
	    $this->wb_template->assign('advanced_search', $this->load->view('app/users/advanced_search', $this->wb_template->get(), true), true);	     
	    
	    $this->load->view('app/users/search', $this->wb_template->get());	 
	}
	
	public function logout()
	{
	    destroy_access_token();
	    
	    $this->config->load('dazah');
	    
	    $oauth_credentials = array(
	        'client_id' => $this->config->item('client_id'),
	        'client_secret' => $this->config->item('client_secret'),
	        'scope' => $this->config->item('scope')
	    );
	    
	    $current_url = site_url('browse/index/' . uniqid());
	    
	    redirect("https://www.daniweb.com/connect/oauth/auth?response_type=code&client_id={$oauth_credentials['client_id']}&scope={$oauth_credentials['scope']}&redirect_uri=".urlencode($current_url));
	}
	
	public function index($order_by = 'id', $offset = 0)
	{
	    $this->wb_template->assign('no_sidebar', true);
		$page_nav = generate_page_nav($offset, 50, site_url("users/index/$order_by"));
		
		$request = array(
		    'url' => 'users/met',
		    'params' => array(
    		    'order_by' => $order_by,
    		    'offset' => $offset,
    		    'include_archived' => true
		    )
		);
		
		$response = page_request($request, false, $page_nav);
		
		$this->wb_template->assign('met_users', $response);
			
		$this->load->view('app/users/report', $this->wb_template->get());   
	}
	
	
}
