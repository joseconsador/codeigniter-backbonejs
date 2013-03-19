<?php

/**
 * This class represents an accountability (unit).
 */
class Accountability extends Base
{	
	// --------------------------------------------------------------------

	public function getModel()
	{
		$CI =& get_instance();
        $CI->load->model('accountability_model', '' ,true);
        
        return $CI->accountability_model;
	}
}