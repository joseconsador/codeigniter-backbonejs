<?php
/**
 * This class represents an employee (single employee).
 */
class Employee extends Base
{
	// Default values
	protected $_data = array(
		'employee_id'  => 0,
		'deleted'      => 0,
		'resigned'     => 0,
		'flexible'     => 0,
		'status_id'    => 0,
		'id_number'    => null,
		'biometric_id' => null,
		'hire_date'    => null,
		'resign_date'  => null,
		'effectivity'  => null,
		'regular_date' => null,
		'schedule_id'  => 0,
		'employment_status' => ''
		);	

	private $_user = null;
	private $_shift = null;
	private $_approver = null;

	// --------------------------------------------------------------------

	public function getModel()
	{
		$CI =& get_instance();
        $CI->load->model('employee_model', '' ,true);

        return $CI->employee_model;
	}

	// --------------------------------------------------------------------

	public function save()
	{
		// Save to variable because after save() $_data is fetched from DB again.
		$data = parent::getData();

		$id = parent::save();
		if ($id) {
			$data['employee_id'] = $id;
			$this->getUser()->persist($data);

			if ($this->getUser()->save()) {				
				return $id;
			} else {
				$this->_validation_errors = $this->getUser()->get_validation_errors();
			}
		}

		return FALSE;
	}

	// --------------------------------------------------------------------

	/**
	 * Get the User object of this employee.
	 * @return User
	 */
	public function getUser()
	{
		if (is_null($this->_user)) {			
			$ci =& get_instance();		
			$ci->load->library('User');
			
			if ($this->user_id > 0) {
				$this->_user = new User($this->user_id);
			} else {
				$this->_user = new User();
			}
		}

		return $this->_user;		
	}

	// --------------------------------------------------------------------

	public function get_approver($module_code = '')
	{
		$ci =& get_instance();
		$ci->load->helper('approver');

		if (is_null($this->_approver)) {
			$this->_approver = get_approver($this, $module_code);
		}

		return $this->_approver;
	}

	public function get_shift()
	{
		$ci =& get_instance();
		$ci->load->library('shift');		
		
		if ($this->schedule_id > 0 && is_null($this->_shift)) {
			$this->_shift = new Shift($this->schedule_id);
		} 
		
		return $this->_shift;
	}	

	// --------------------------------------------------------------------

	public function get_accountabilities()
	{
		$ci =& get_instance();
		$ci->load->model('accountability_model');

		$accountabilities = $ci->accountability_model->search('employee_id', $this->getId());

		if ($accountabilities) {
			return $accountabilities->result();
		} else {
			return null;
		}
	}	

	// --------------------------------------------------------------------

	public function getData()
	{
		$data = array_merge($this->getUser()->getData(), parent::getData());
		
		$data['accountabilities'] = $this->get_accountabilities();
		$hire_date = new DateTime($this->hire_date);
		$curr = new DateTime();
		$diff = $curr->diff($hire_date);
		$data['tenure'] = ($diff->format('%y') * 12) + $diff->format('%m');

		return $data;
	}	
}