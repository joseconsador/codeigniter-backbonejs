<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Feed extends Base
{
	protected $_validators = array(
        'feeds' => array('Zend_Validate_NotEmpty')
    );

	public function getModel()
	{
		$ci =& get_instance();
		$ci->load->model('feeds_model');
		
		return $ci->feeds_model;
	}

	public function __toString()
	{
		return $this->feeds;
	}

	public function delete()
	{
		$ci =& get_instance();

		$user = $ci->get_user();

		if ($user->user_id == $this->user_id || 
			$ci->acl->check_acl('HR_DELETE_POST', $user->login) 
			) {
			return parent::delete();			
		} else {
			$this->_validation_errors[] = 'Insufficient access.';
			return FALSE;
		}
	}
}