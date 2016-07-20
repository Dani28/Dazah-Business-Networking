<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profile extends CI_Controller
{
    public function js_notifications()
    {         
        if ($this->input->is_ajax_request())
        {
            $properties = array(
                'filter' => 'notifications'
            );
            
            $notifications = api_endpoint('conversations/report', $properties);
                        
            if (!empty($notifications))
            {
                $this->wb_template->assign('notifications', $notifications);
                $html = $this->load->view('app/notifications', $this->wb_template->get(), true);
            }
            else
            {
                $html = "<li>You currently have no notifications.</li>";
            }
            
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(array(
                    'html' => $html
                )));
        }        
    }
    
	public function view($id = 0)
	{
	    $id = decrypt_id($id);
	    
		if ($id > 0)
		{
		    $response = api_endpoint("users/$id");
		    
		    // We just want to talk about the user object
		    $user = $response[0];
		}
		else
		{			
		    // Let's talk about ourselves
			$user = who_am_i();
			$id = $user->id;
		}
							
		$this->wb_template->assign('user', $user);
		
		// Our relationship with the user
		$match = api_endpoint("users/$id/match");
				
		$this->wb_template->assign('match', $match[0]);
		
		// Generate their profile
		$this->wb_template->assign('profile_fragment', $this->load->view('app/profile/fragment', $this->wb_template->get(), true), true);
				
		build_conversations_sidebar();
		
		// Display their profile
		$this->load->view('app/profile/view', $this->wb_template->get());
	}
	
}
