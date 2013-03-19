<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Separating the notifications from the API to allow future design changes,
 * in this controller the messages and thank you's are collected and returned as 
 * a json array
 */
class Notification_controller extends Front_Controller
{
	/**
	 * the messages and thank you's are collected and returned as 
	 * a json array
	 * 
	 * @return json
	 */
	public function get()
	{
		$response['messages'] = $this->rest->get('messages/recieved', array(), 'json', FALSE);
		$user = $this->user->user_id;
		$response['notifications'] = $this->rest->get('user/id/' . $user . '/notifications', array(), 'json', FALSE);

		$this->load->view('ajax', array('json' => $response));
	}	
}