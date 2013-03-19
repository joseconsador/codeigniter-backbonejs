<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Hr_controller extends Front_Controller
{
	public function __construct()
	{
		parent::__construct();

		// Check if user has parent access to this controller.
		if (!is_allowed('PARENT_IMMEDIATE')) {
			show_404();
		}
	}

    // --------------------------------------------------------------------

    /**
	* This is the default action, lists all employees.
	*
	* @param int $page
	*/ 
	public function index()
	{				
		add_js('libs/daterangepicker.jQuery.js');
		add_js('modules/employee/model.js');
		add_js('modules/timekeeping/model.js');
		add_js('modules/timekeeping/collection.js');
		add_js('modules/timekeeping/view.js');
		add_js('modules/timekeeping/app.js');

		$data['employees'] = $this->rest->get('201/employees', 
			array('all' => true, 'raw' => true));			

		$this->layout->view('timekeeping/immediate/list', $data);
	}

	// --------------------------------------------------------------------
	
	public function leavesetup()
	{		
		add_js('libs/paginated_view.js');
		add_js('modules/timekeeping/form/type/router.js');
		add_js('modules/timekeeping/form/type/model.js');
		add_js('modules/timekeeping/form/type/view.js');
		add_js('modules/timekeeping/form/type/directory_view.js');
		add_js('modules/timekeeping/form/type/paginated_collection.js');

		$this->layout->view('timekeeping/hr/formtypes/list');
	}
}