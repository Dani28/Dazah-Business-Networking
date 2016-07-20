<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

ini_set('memory_limit', '256M');
ini_set('max_execution_time', 0);
set_time_limit(3600);

class Invites extends CI_Controller
{
    /*
    public function index()
    {
        global $properties;
                 
        prepare_header();
                
        if (isset($_FILES['csv']) AND $_FILES['csv']['size'] > 0)
        {
            // We do this hack to force form validation to run
            $_POST['csv'] = $_FILES['csv']['tmp_name'];
        }
        
        // Fetch data from form
        // We are about to manipulate this array from within the form validation fn
        $properties = $this->input->post();
        
        if ($this->form_validation->run('invite') !== false)
        {
            // Remove the hack :P
            if (isset($_FILES['csv']) AND $_FILES['csv']['size'] > 0)
            {
                unset($_POST['csv']);
            }
                        	
            // Split into an array and remove duplicates
            if (isset($properties['emails']) AND !empty($properties['emails']))
            {
                $properties['emails'] = array_flip(array_flip(explode("\n", $properties['emails'])));
                
                // Sanitize array into a list of valid emails
                foreach ($properties['emails'] AS &$email)
                {
                    // Strip illegal characters
                    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
                
                    // If not an illegal email ...
                    if (filter_var($email, FILTER_VALIDATE_EMAIL) !== false)
                    {
                        // Create an invite object
                        $email = new Invite(array(
                            'email' => $email
                        ));
                
                        // We don't push this to the database because we do a bulk insert in process_invites() instead
                    }
                }
                
                process_invites($properties['emails']);
            }
            
            if (isset($properties['csv']) AND !empty($properties['csv']))
            {
                parse_csv(json_decode($properties['csv'])->full_path);
            }
            
            $this->wb_template->assign('success', true, false, false);
            
        }
        
        // Login form
        prepare_form_for_template('invite');
        
        $this->load->view('invites/index', $this->wb_template->get());
    }
    */
    
}