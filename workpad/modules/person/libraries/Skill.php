<?php

/**
 * This class represents a Person's skill.
 */
class Skill extends Base
{	
	// --------------------------------------------------------------------

	public function getModel()
	{
		$CI =& get_instance();
        $CI->load->model('skill_model', '' ,true);
        
        return $CI->skill_model;
	}
}