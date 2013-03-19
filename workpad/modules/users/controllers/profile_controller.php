<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profile_controller extends Front_Controller
{
	public function __construct()
	{
	   parent::__construct();	   	   
	}

    // --------------------------------------------------------------------

    /**
	* Show current user's profile.
	*	
	*/	
	public function index()
	{
		$profile = $this->rest->get('user/id/' . $this->session->userdata('user_id'));
		$this->_user($profile);
	}

	// --------------------------------------------------------------------
	
	public function show($hash)
	{			
		$profile = $this->rest->get('user', array('hash' => $hash), 'json');				
		$this->_user($profile);		
	}

	// --------------------------------------------------------------------

	/**
	* Show a user's profile.
	* 
	* @param int $user user_id
	*/
	private function _user($profile)
	{		
		if ($this->rest->status() == '404') {
			redirect ('employee/dashboard');
		}

		add_js('modules/feeds.js');
		add_js('modules/profile/contact.js');
		add_js('modules/thankyou/model.js');
		add_js('modules/thankyou/view.js');

		// Get goals if employee
		if ($profile->employee_id > 0) {
			$profile->goals = $this->rest->get('employee/id/' . $profile->employee_id . '/goals');
		}

		if ($profile->own_profile = ($this->session->userdata('user_id') == $profile->user_id)) {
			add_js('modules/profile/router.js');
			add_js('modules/profile/about.js');
			add_js('libs/load-image.min.js');
			add_js('libs/jquery.ui.widget.js');
			add_js('libs/tmpl.min.js');
			add_js('libs/jquery.fileupload.js');
			add_js('libs/jquery.fileupload-fp.js');			
			add_js('libs/jquery.iframe-transport.js');
			add_js('modules/profile/upload_photo.js');
			add_js('modules/profile.js');
			
			add_css('jquery.fileupload-ui.css');
		}
		
		$this->layout->view('profile', $profile);		
	}
}