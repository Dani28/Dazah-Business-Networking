<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// This class is used to automagically sanitize variables as they pass from the controller to the view
//	Therefore, the developer does not need to concern themselves with escaping every variable manually
//	The vast majority of this class was taken and modified directly from DaniWeb.com code
class Wb_template {
	
	private $CI;
	private $output = array();
	
	// ************************
	// PRIVATE HELPER FUNCTIONS
	// ************************
	
	// Encode HTML entities into variables so they will be sanitized from injection bugs
	private function html_escape($string)
	{
	    if (is_array($string))
	    {
	        return array_map('self::html_escape', deep_clone($string));
	    }
	    else if (is_object($string))
	    {	        
	        foreach ($string AS $key => &$value)
	        {
	            if (is_string($value))
	            {
	                $string->{$key} = $this->html_escape($value);	                
	            }
	            else if (is_array($value) OR is_object($value))
	            {
	                // Recursion
	                $string->{$key} = $this->html_escape(deep_clone($value));
	            }
	        }
	        	        
	        return $string;
	    }
	    else if (is_bool($string))
	    {
	        return $string;
	    }
	    else if (is_numeric($string))
	    {
	        return $string;
	    }
	    else
	    {
	        return htmlspecialchars($string);
	        // return filter_var($string, FILTER_SANITIZE_SPECIAL_CHARS, array('flags' => FILTER_FLAG_ENCODE_HIGH));
	    }
	}
	
	// **************
	// PUBLIC METHODS
	// **************
		
	// Used to assign a variable we want to use in a template
	public function assign($name, $dummy, $sanitized = false)
	{
	    // Objects are pointers?!
	    // Dummy variable is being manipulated when it's an object
	    if (!$sanitized AND is_object($dummy))
	    {
	        $variable = clone $dummy;
	    }
	    else if (!$sanitized AND is_array($dummy))
	    {
	        $variable = deep_clone($dummy);
	    }
	    else
	    {
	        $variable = $dummy;
	    }
	     
	    if (!$sanitized)
	    {
	        if (!is_numeric($variable) AND !is_bool($variable))
	        {
	            // HTML escape string
	            $variable = $this->html_escape($variable);
	        }
	    }
	
	    // Make the assignment
	    $this->output[$name] = $variable;
	}
	
	public function deallocate($name)
	{
		unset($this->output["$name"]);
	}
	
	// Used to retrieve all template variables to pass them to the view
	public function get()
	{		
		return $this->output;
	}
	
	// Constructor function
	public function __construct()
	{		
		$this->CI =& get_instance();

		// Retrieve access token so we will have access to who_am_i() from wherever we are
		retrieve_access_token();
		
		// Make sure that the shared header and footer are available from all templates
		$this->output['header'] = $this->CI->load->view('app/header', $this->output, true);
		$this->output['footer'] = $this->CI->load->view('app/footer', $this->output, true);
		$this->output['menu'] = '';			
	}
}