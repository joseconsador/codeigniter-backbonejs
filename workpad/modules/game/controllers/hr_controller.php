<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Hr_controller extends Front_Controller
{
	public function __construct()
	{
	   parent::__construct();	   
	}

    // --------------------------------------------------------------------
    
	public function index()
	{
		add_js('modules/rewards');

		// AJAX File upload files
		add_js('libs/load-image.min.js');
		add_js('libs/jquery.ui.widget.js');
		add_js('libs/tmpl.min.js');
		add_js('libs/jquery.fileupload.js');
		add_js('libs/jquery.fileupload-fp.js');
		add_js('libs/jquery.iframe-transport.js');

		add_css('jquery.fileupload-ui.css');		
		
		$rewards = $this->rest->get('rewards');

		$this->layout->view('rewards/hr/list', array('rewards' => $rewards));
	}
}
