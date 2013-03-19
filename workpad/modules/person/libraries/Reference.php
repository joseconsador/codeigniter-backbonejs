<?php

/**
 * This class represents a Person's work experience.
 */
class Reference extends Base
{	
	// --------------------------------------------------------------------

	public function getModel()
	{
		$CI =& get_instance();
        $CI->load->model('reference_model', '' ,true);
        
        return $CI->reference_model;
	}
}