<?php

/**
 * This class represents a department.
 */
class Department extends Base
{
	public function getModel()
	{	
		$ci =& get_instance();
		$ci->load->model('department_model');
        return $ci->department_model;
	}	

	// --------------------------------------------------------------------
	
	public function __toString()
	{
		return _p($this->getData(), 'department');
	}
}