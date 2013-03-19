<?php

require_once MODPATH . 'person/libraries/PersonAbstract.php';

/**
 * This class represents a Person's work experience.
 */
class Training extends PersonAbstract
{	
	// --------------------------------------------------------------------

	public function getModel()
	{
		$CI =& get_instance();
        $CI->load->model('training_model', '' ,true);
        
        return $CI->training_model;
	}
}