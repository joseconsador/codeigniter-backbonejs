<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Immediate_controller extends Front_Controller
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
		add_js('libs/backbone-paginator.min.js');
		add_js('modules/employee');

		$status = $this->rest->get('options', 
			array(
				'option_group' => 'EMPLOYMENT-STATUS',
				'sort'		   => 'sort_order',
				'order'		   => 'asc'
				), 'json');				
		
		$all = new stdClass();
		$all->option = 'All';
		$all->option_id = '';

		$status->data[] = $all;

		$this->layout->view('201/immediate/list', array(
			'employment_statuses' => $status->data
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

		$person = $this->rest->get('person/id/' . $user->person_id);

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
		add_js('modules/person/workhistory');
		add_js('modules/person/references');
		add_js('modules/person/affiliation');
		add_js('modules/person/skills');
		add_js('modules/person/training');
		add_js('modules/person/tests');
		add_js('modules/person/family');
		add_js('modules/person/education');
		add_js('modules/employee/units');
		add_js('libs/jquery.timeago.js');

		$this->layout->view('201/immediate/view_201', $data);
	}
}