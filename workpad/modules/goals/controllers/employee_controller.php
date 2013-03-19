<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Employee_controller extends Front_Controller
{

	public function index()
	{
		add_js('modules/employee/model.js');
		add_js('modules/goals');		

		add_js('libs/jquery-star-rating');
		add_css('jquery.rating.css');

		$data['goals'] = $this->rest->get('employee/goals/assigned');

		$this->layout->view('goals/employee/list', $data);
	}
}