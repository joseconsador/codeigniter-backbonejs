<?php
/**
 * This class represents an employee (single employee).
 */
class Options extends Base
{
	// Default values
	protected $_data = array(
		'option_id'  	=> 0,
		'option_group' 	=> null,
		'option_code'	=> null,
		'option'     	=> null,
		'inactive'    	=> 0,
		'deleted'    	=> 0,
		'sort_order' 	=> 0
		);

	// --------------------------------------------------------------------

	public function getModel()
	{
		$CI =& get_instance();
        $CI->load->model('options_model', '' ,true);

        return $CI->master_model;
	}

	// --------------------------------------------------------------------
	
	public function getData()
	{		
		$data = parent::getData(); 

		return $data;		
	}
}