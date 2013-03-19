<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Message_controller extends Front_Controller
{
	public function index()
	{		
		add_js('modules/message/view.js');
		add_js('modules/message/model.js');
		add_js('modules/message/collection.js');
		add_js('modules/message/modal_message.js');
		add_js('modules/message/app.js');

		$data = $this->rest->get('user');

		$this->layout->view('messages_ui', $data);
	}	
}