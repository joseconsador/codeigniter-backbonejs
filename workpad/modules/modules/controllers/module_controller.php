<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller for module management
 */
class Module_controller extends Front_Controller
{
	public function __construct()
	{
	   parent::__construct();	   
	}

    // --------------------------------------------------------------------

    /**
	* This is the default action, lists all modules.
	*
	* @param int $page
	*/	
	public function index()
	{
		add_js('modules/modules');

		$modules = $this->rest->get('modules');
		
		$this->layout->view('modules/admin/modules_list', array(
			'modules' => $modules
			)
		);
	}
}
