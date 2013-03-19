<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Employee_controller extends Front_Controller
{
	public function __construct()
	{
		parent::__construct();

		// Check if user has parent access to this controller.
		if (!is_allowed('PARENT_EMPLOYEE')) {
			show_404();
		}
	}

    // --------------------------------------------------------------------

    /**
	* This is the default action, lists all employees.
	*	
	*/ 
	public function index()
	{				
		add_js('libs/daterangepicker.jQuery.js');
		add_js('modules/employee/model.js');
		add_js('modules/timekeeping/model.js');
		add_js('modules/timekeeping/collection.js');
		add_js('modules/timekeeping/view.js');
		add_js('modules/timekeeping/app.js');

		$data = $this->rest->get('201/employee');			

		$this->layout->view('timekeeping/employee/list', $data);
	}

    // --------------------------------------------------------------------

    /**
	* Display an employee's time activity for a given period.
	*	
	*/ 
	public function timegraph()
	{					
		$this->layout->view('timekeeping/employee/timegraph');
	}	

    // --------------------------------------------------------------------

    /**
	* Display an employee's calendar.
	*
	*/ 
	public function calendar()
	{	
		add_js('libs/fullcalendar.min.js');
		add_css('fullcalendar.css');
				
		$shift = $this->rest->get('employee/id/' . $this->user->employee_id . '/shift');

		$this->layout->view('timekeeping/employee/calendar', array('shift' => $shift));
	}		
}