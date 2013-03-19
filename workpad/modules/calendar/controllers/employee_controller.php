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

		force_ssl();
	}

    // --------------------------------------------------------------------

    /**
	* Display an employee's calendar.
	*
	*/ 
	public function index()
	{
		$this->load->config('google');

		add_js('libs/fullcalendar/fullcalendar.min.js');
		add_js('modules/employee/model.js');
		add_js('libs/fullcalendar/gcal.js');
		add_js('libs/google/api.js');
		add_js('modules/calendar/model.js');
		add_js('modules/calendar/view.js');
		add_js('modules/calendar/router.js');

		add_js('modules/calendar/event/model.js');
		add_js('modules/calendar/event/view.js');

		add_js('modules/timekeeping/form/application/model.js');
		add_js('modules/timekeeping/form/application/view.js');

		add_css('fullcalendar.css');
		remove_css('table-responsive.css');

		add_js('libs/jquery-ui-timepicker-addon.js');

		add_css('colorpicker/colorpicker.css');
		add_js('libs/colorpicker/bootstrap-colorpicker.js');
		/*add_js('libs/chosen/chosen.jquery.min.js');
		add_css('chosen/chosen.css');*/

		$types = $this->rest->get('employee/id/' . $this->user->employee_id . '/leavetypes');

		$this->layout->view('calendar/calendar');
	}		
}