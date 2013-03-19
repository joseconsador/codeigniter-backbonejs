<?php

/**
 * This class represents a division.
 */
class Division extends Base
{
	public function getModel()
	{	
		$ci =& get_instance();
		$ci->load->model('division_model');
        return $ci->division_model;
	}	

	// --------------------------------------------------------------------
	
	public function __toString()
	{
		return _p($this->getData(), 'division');
	}
}