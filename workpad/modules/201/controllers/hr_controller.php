<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Hr_controller extends Front_Controller
{
	public function __construct()
	{
		parent::__construct();

		// Check if user has parent access to this controller.
		if (!is_allowed('PARENT_HR')) {
			show_404();
		}
	}
  	
  	// --------------------------------------------------------------------

	/**
	 * Page that displays employee's 201 from the HR's point of view.
	 * 
	 * @param  string $hash Employee's unique hash	 
	 */
	public function index()
	{
		add_js('libs/backbone-paginator.min.js');
		add_js('modules/person');
		add_js('modules/employee');
		add_js('modules/user/model.js');
		add_js('modules/options.js');

		$employment_statuses = $this->rest->get('options', 
			array(
				'option_group' => 'EMPLOYMENT-STATUS',
				'sort'		   => 'sort_order',
				'order'		   => 'asc'
				), 'json');

		$this->layout->view('201/hr/list', array(
			'employment_statuses' => $employment_statuses,
			'departments' => $this->rest->get('departments'),
			'companies' => $this->rest->get('companies')
			)
		);
	}

    // --------------------------------------------------------------------

	/**
	 * Page that displays employee's 201 from the supervisor's point of view.
	 * 
	 * @param  string $hash Employee's unique hash	 
	 */
	public function employee($hash)
	{
		$user = $this->rest->get('user', array('hash' => $hash), 'json');	

		$data = $this->rest->get('201/id/' . $user->employee_id);
		if ($this->rest->status() == '404') {
			redirect ('employee/dashboard');
		}

		$data->employee = $data;

		$person = $this->rest->get('person/id/' . $user->person_id);

		$data->maiden_name = $person->maiden_name;
		$data->work_experience = $person->work_experience;
		$data->references = $person->references;
		$data->affiliations = $person->affiliations;
		$data->skills = $person->skills;
		$data->trainings = $person->trainings;
		$data->tests = $person->tests;
		$data->details = $person->details;		
		$data->education = $person->education;
		$data->idnos = $person->idnos;
		$data->addresses = $person->addresses;
		$data->family = $person->family;

		add_js('modules/profile/contact.js');
		// Copy this to immediate_controller
		add_js('modules/person/workhistory');
		add_js('modules/person/references');
		add_js('modules/person/affiliation');
		add_js('modules/person/skills');
		add_js('modules/person/training');
		add_js('modules/person/tests');
		add_js('modules/person/family');
		add_js('modules/person/education');
		add_js('modules/person/details');
		add_js('modules/employee/units');
		add_js('modules/employee/add_employee_view.js');
		add_js('modules/employee/router.js');
		add_js('modules/employee/model.js');
		add_js('modules/user/user_ref_model.js');		
		add_js('modules/employee/edit201.js');
		add_js('libs/jquery.timeago.js');
		add_js('modules/message/modal_message.js');		
		// AJAX File upload files
		add_js('libs/load-image.min.js');
		add_js('libs/jquery.ui.widget.js');
		add_js('libs/tmpl.min.js');
		add_js('libs/jquery.fileupload.js');
		add_js('libs/jquery.fileupload-fp.js');
		add_js('libs/jquery.iframe-transport.js');

		add_css('jquery.fileupload-ui.css');

		$data->edit = true;		

		$this->layout->view('201/immediate/view_201', $data);
	}	
}