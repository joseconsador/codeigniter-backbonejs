<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Employee_controller extends Front_Controller
{
	public function __construct() {
		parent::__construct();
	}
  	// --------------------------------------------------------------------

	/**
	 * Page that displays employee's dashboard
	 * 	 
	 */
	public function index()
	{
		add_js('modules/notes');
		add_js('modules/todo');
		add_js('libs/jquery-ui-timepicker-addon.js');

		$data['employee'] = $this->rest->get('201/employee');	

		$data['goals'] = $this->rest->get('employee/id/' . $this->user->employee_id . '/goals');
		$data['todo']  = $this->rest->get('user/todos');		
		$data['notes'] = $this->rest->get('user/id/' . $this->user->user_id . '/notes');
		$data['activities'] = array();

		$activities = $this->rest->get('user/activity', array('limit' => 10, 'offset' => 0));

		if ($activities->_count > 0) {
			foreach ($activities->data as $activity_row) {
				$data['activities'][$activity_row->created_date][] = new Activity($activity_row);
			}
		}

		$this->layout->view('dashboard/employee', $data);
	}
}