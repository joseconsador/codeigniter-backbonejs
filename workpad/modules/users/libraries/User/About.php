<?php

/**
 * This class represents a user description.
 */
class User_About extends Base
{
	protected $_data = array(
		'id'	   => null,		
		'about_me' => '',
		'talent'   => '',
		'movies'   => '',
		'music'    => '',
		'dreams'   => '',
		'website'  => '',
		'photo'    => ''
		);

	public function getModel()
	{
		$ci =& get_instance();
		$ci->load->model('about_model');
        return $ci->about_model;
	}

	public function save()
	{
		if ($id = parent::save()) {
			$cache = Cache::get_instance();
			$cache->delete('_oUser' . $this->user_id);
		}

		return $id;
	}	
}