<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Browse extends CI_Controller
{	
    private function js_next_profile($offset)
    {
        // Restart at the beginning
        if ($offset >= 99)
        {
            $offset = -1;
        }
                
        // URL for the next profile
        $url = site_url('browse/profile/' . ++$offset);
        
        // Retrieve the entire profile
        ob_start();
        $this->profile($offset);
        $html = ob_get_clean();
        
        // Spit out JSON
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(array(
                'url' => $url,
                'html' => $html
            )));     
    }
    

    public function js_meet_profile()
    {
        if ($this->input->is_ajax_request())
        {
            $user_id = $this->input->post('id');
    
            // Make sure we are allowed to start a conversation with this user
    
            $match = api_endpoint("users/$user_id/match")[0];
                
            // They are free to meet
            if (isset($match->meet->price_usd) AND $match->meet->price_usd == 0)
            {
                $result = api_endpoint("users/$user_id/meet");
                
                if (isset($result->conversation->id))
                {        
                    // Start a new conversation with the user passed in via POST request
                    $conversation_id = $result->conversation->id;
        
                    $this->output
                        ->set_content_type('application/json')
                        ->set_output(json_encode(array('url' => conversation_url($conversation_id))));
                }
            }
        }
    }
    
	public function js_meet()
	{	
	    if ($this->input->is_ajax_request())
	    {
	        // Retrieve the ID
	        $user_id = $this->input->post('id');
	         
	        // Determine our relationship with them
	        $match = api_endpoint("users/$user_id/match")[0];
	         
	        // They are free to meet
	        if (isset($match->meet->price_usd) AND $match->meet->price_usd == 0)
	        {
	            $offset = abs(intval($this->input->post('offset')));
	            
	            // Start a new conversation with the user passed in via POST request
	            api_endpoint("users/$user_id/meet");
	            
	            // JSON object increases the page offset
	            $this->js_next_profile($offset);
	             
	        }
	    }	    
	}
	
	public function js_block()
	{	
		if ($this->input->is_ajax_request())
		{
			$offset = (intval($this->input->post('offset')));
			
			$user_id = $this->input->post('id');
			
			// Block the user passed in via POST request
			api_endpoint("users/$user_id/mute");
				
			// JSON object increases the page offset
			$this->js_next_profile($offset);
		}
	}

	public function js_skip()
	{		
		if ($this->input->is_ajax_request())
		{	
			$offset = abs(intval($this->input->post('offset')));
			
			$user_id = $this->input->post('id');
			
			// Skip the user passed in via POST request
			api_endpoint("users/$user_id/skip");
				
			// JSON object increases the page offset
			$this->js_next_profile($offset);
		}
	}
	
	public function index()
	{
	    $this->profile();
	}
	
	public function profile($offset = 0)
	{		    	    	    
		$offset = abs(intval($offset));
		
		// Restart at the beginning
		if ($offset >= 100)
		{
		    $offset = 0;
		}
		
		// We send the offset to the template
		$this->wb_template->assign('offset', $offset);
		

		// Load list of conversations into the template
		build_conversations_sidebar();	
		
		// Determine which profile to show next
		
		$properties = array(
		    'limit' => 1,
		    'offset' => $offset
		);		
		
		$user = api_endpoint('users/matches', $properties);	
								
		// The API endpoint is returning an array with only one user in it, since we have limit => 1
		if (isset($user[0]->id))
		{
			$this->wb_template->assign('user', $user[0]);
			
			// Generate their profile
			$this->wb_template->assign('profile_fragment', $this->load->view('app/profile/fragment', $this->wb_template->get(), true), true);
		
			// Spit out the entire page
			$this->load->view('app/browse/profile', $this->wb_template->get());
		}
		else if ($offset > 0)
		{
		    // Unavailable offset; Start at the beginning (recursive)
		    $this->profile();
		}
		else
		{
			// Error if no more profiles available to show
			$this->load->view('app/browse/oops', $this->wb_template->get());
		}
	}
	
}