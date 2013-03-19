<?php

/**
 * This class represents a Person's work experience.
 */
class Affiliation extends Base
{	
	// --------------------------------------------------------------------

	public function getModel()
	{
		$CI =& get_instance();
        $CI->load->model('affiliation_model', '' ,true);
        
        return $CI->affiliation_model;
	}
}