<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Activity extends Base
{
	protected $_validators = array(
        'user_id' => array('Zend_Validate_NotEmpty'),
        'resource_type' => array('Zend_Validate_NotEmpty')        
    );

	private $_activity_renderers = array(
		'form_application' => 'Form_Application_FeedRenderer',
		'goal'			   => 'Goal_FeedRenderer',
		'goal_objective'   => 'Goal_Item_FeedRenderer'		
		);

	// --------------------------------------------------------------------
	
	public function getModel()
	{
		$ci =& get_instance();
		$ci->load->model('activity_model');
		
		return $ci->activity_model;
	}

	// --------------------------------------------------------------------

	public function get_display()
	{
		if (!array_key_exists($this->resource_type, $this->_activity_renderers)) {
			throw new Exception("No renderer defined for this type of resource : " . $this->resource_type, 1);
		} else {
			$renderer = new $this->_activity_renderers[$this->resource_type]($this);
		}

		return call_user_func(array($renderer, $this->action));
	}
}