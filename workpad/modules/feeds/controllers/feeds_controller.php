<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Feeds_controller extends Front_Controller
{
	// --------------------------------------------------------------------

	/**
	* Post a feed to the current user's stream
	* 
	*/
	function feed_post()
	{
		$request = get_request_body();

		$response = $this->rest->post('feed', 
			array('feeds' => $request['feeds'])
		);

		$response['status'] = $this->rest->status();
		$this->load->view('ajax', array('json' => $response));
	}
}