<?php

/**
 * This class represents a log template.
 */
class Log_template extends Base
{
	// --------------------------------------------------------------------
    
	public function getModel()
	{	
		$ci =& get_instance();
		$ci->load->model('log_template_model');
        return $ci->log_template_model;
	}

    // --------------------------------------------------------------------

	/**
	 * Renders the template, populating variables with the given values
	 *
	 * @param array $vals Associative array of values to populate the template
	 * 
	 * @return string 
	 */
	public function render($vals = array())
	{
		$CI =& get_instance();
		$CI->load->library('parser');

		return $CI->parser->parse_string($this->template, $vals);
	}
}