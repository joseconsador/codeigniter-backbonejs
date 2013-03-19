<?php

/**
 * This class represents a user description.
 */
class User_Ref extends Base
{	
	public function getModel()
	{
		$ci =& get_instance();
		$ci->load->model('user_ref_model');
        return $ci->user_ref_model;
	}
}