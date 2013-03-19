<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Options_controller extends Front_Controller
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
		add_js('libs/backbone.relational.js');
		add_js('libs/backbone-paginator.min.js');
		add_js('modules/admin_options');

		$status = $this->rest->get('moptions', 
			array(
				'sort'		   => 'sort_order',
				'order'		   => 'desc'
				), 'json');
		$user = $this->rest->get('201/employee');

		$all = new stdClass();
		$all->option_group = 'All';
		$all->option_id = '';

		$status->data[] = $all;
		
		$this->layout->view('admin_options/list', array(
			'employment_statuses' => $status->data
			)
		);
	}

    // --------------------------------------------------------------------

}