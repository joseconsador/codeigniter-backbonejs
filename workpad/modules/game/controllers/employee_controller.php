<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Employee_controller extends Front_Controller
{
	public function __construct()
	{
	   parent::__construct();	   
	}

    // --------------------------------------------------------------------
    
	public function index()
	{
		add_js('modules/rewards');
		
		$rewards = $this->rest->get('rewards');

		$this->layout->view('rewards/employee/list', array('rewards' => $rewards));
	}
}
