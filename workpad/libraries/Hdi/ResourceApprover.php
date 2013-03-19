<?php

/**
 * This class should handle changing status of a resource (leave application, manpower request, etc)
 */
class Hdi_ResourceApprover
{
	private $_resource;
	private $_approver;
	private $_validation_errors = array();

	protected $user_reference = 'employee_id';
	protected $new_status_id;
	protected $status_reference = 'status_id';
	protected $module_code;

	function set_new_status_id($status_id)
	{
		$this->new_status_id = $status_id;
	}

	function set_resource(Base $resource)
	{
		$this->_resource = $resource;
	}

	function set_updater(User $user)
	{
		$this->_updater = $user;
	}

	function set_module_code($code)
	{
		$this->module_code = $code;
	}

	function get_module_code()
	{
		return $this->module_code;
	}

	function get_resource()
	{
		return $this->_resource;
	}

	function get_updater()
	{
		return $this->_updater;
	}

	function update()
	{
		if ($this->validate()) {
			$this->get_resource()->{$this->status_reference} = $this->new_status_id;
			return $this->get_resource()->getModel()->do_save(
				$this->get_resource()->getData()
			);
		}

		return FALSE;
	}

	function validate() 
	{
		$ci =& get_instance();
		$ci->load->helper('approver');

		$approver = get_approver(
			new Employee($this->get_resource()->{$this->user_reference}), $this->get_module_code()
		);

		return ($approver->user_id == $this->get_updater()->user_id);
	}
}