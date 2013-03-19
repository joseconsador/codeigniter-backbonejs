<?php

/**
 * This class represents a Person's id number.
 */
class Idnos extends Base
{	
	// --------------------------------------------------------------------

	public function getModel()
	{
		$CI =& get_instance();
        $CI->load->model('idnos_model', '' ,true);
        
        return $CI->idnos_model;
	}
}