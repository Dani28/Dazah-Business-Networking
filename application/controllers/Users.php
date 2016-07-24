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
	
	public function index($order_by = 'id', $offset = 0)
	{
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
