<?php

require_once MODPATH . 'person/libraries/PersonAbstract.php';

/**
 * This class represents an address.
 */
class Address extends PersonAbstract
{	
	// --------------------------------------------------------------------

	public function getModel()
	{
		$CI =& get_instance();
        $CI->load->model('address_model', '' ,true);
        
        return $CI->address_model;
	}
}