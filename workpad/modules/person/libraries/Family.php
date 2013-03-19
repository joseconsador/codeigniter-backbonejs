<?php

require_once MODPATH . 'person/libraries/PersonAbstract.php';

/**
 * This class represents an family member.
 */
class Family extends PersonAbstract
{	
	// --------------------------------------------------------------------

	public function getModel()
	{
		$CI =& get_instance();
        $CI->load->model('family_model', '' ,true);
        
        return $CI->family_model;
	}
}