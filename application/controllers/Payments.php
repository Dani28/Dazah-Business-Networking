<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Payments extends CI_Controller
{
    public function process($id = 0)
    {
        $id = decrypt_id($id);
        
        // Send to the template the User ID we want to meet
        $this->wb_template->assign('user_id', $id);
        
        // Load the template
        $this->load->view('app/payments/process', $this->wb_template->get());
    }
    
    public function js_check_payment()
    {
        if ($this->input->is_ajax_request())
        {
            // Retrieve the User ID
            $user_id = $this->input->post('user_id');
                        
            // Starting time
            $time = time();
            
            // Keep looping until it's free to meet them or 15 seconds are up
            while (time() - $time <= 15)
            {
                // Determine our match relationship
                $match = api_endpoint("users/$user_id/match")[0];
                    
                // Check if they are free to meet
                if (isset($match->meet->price_usd) AND $match->meet->price_usd == 0)
                {
                    // If they are, meet them!
                    $result = api_endpoint("users/$user_id/meet");
                    
                    // Spit out a link to the conversation we just started
                    if (isset($result->conversation->id))
                    {        
                        $conversation_id = $result->conversation->id;
            
                        $this->output
                            ->set_content_type('application/json')
                            ->set_output(json_encode(array('url' => conversation_url($conversation_id))));                        
                    }
                    
                    // Break out of the loop
                    break;                    
                }
                
                // Wait 5 seconds before trying again
                sleep(5);
            }            
        }
    }
    
}