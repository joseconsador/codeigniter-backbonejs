<?php

/**
 * This class represents a company.
 */
class Company extends Base
{
	public function getModel()
	{	
		$ci =& get_instance();
		$ci->load->model('company_model');
        return $ci->company_model;
	}

	// --------------------------------------------------------------------
	
	public function __toString()
	{
		return _p($this->getData(), 'company');
	}
}