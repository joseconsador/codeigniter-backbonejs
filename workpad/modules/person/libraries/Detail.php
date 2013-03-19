<?php

require_once MODPATH . 'person/libraries/PersonAbstract.php';

/**
 * This class represents a Person's work experience.
 */
class Detail extends PersonAbstract
{	
	protected $_data = array(
		'gender' => 'Male',
		'birth_date' => '0000-00-00',
		'civil_status' => 'Single',
		'spouse_name' => '',
		'spose_work' => '',
		'marriage_date' => '0000-00-00',
		'children' => 0,
		'nationality' => '',
		'height' => '',
		'weight' => '',
		'blood_type' => ''
		);
	// --------------------------------------------------------------------

	public function getModel()
	{
		$CI =& get_instance();
        $CI->load->model('detail_model', '' ,true);
        
        return $CI->detail_model;
	}
}