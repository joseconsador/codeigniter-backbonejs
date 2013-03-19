<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Immediate_controller extends Front_Controller
{
	private function _prep_js()
	{
		add_js('modules/employee/model.js');
		add_js('modules/goals');		

		add_js('libs/jquery-star-rating');
		add_css('jquery.rating.css');		
	}

	public function goals()
	{
		$this->_prep_js();

		$data['employee_id'] = $this->user->employee_id;
		$data['subordinates'] = $this->rest->get('user/id/' . $this->user->user_id . '/subordinates');
		$data['goals'] = $this->rest->get('employee/goals');

		$this->layout->view('goals/immediate/main', $data);
	}
}