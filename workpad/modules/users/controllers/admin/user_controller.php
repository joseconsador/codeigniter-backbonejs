<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller for user management
 */
class User_controller extends Front_Controller
{
	public function __construct()
	{
	   parent::__construct();	   
	}

    // --------------------------------------------------------------------

    /**
	* This is the default action, lists all users.
	*
	* @param int $page
	*/	
	public function index()
	{          
		add_js('libs/backbone-paginator.min.js');
		add_js('modules/user');
		add_js('libs/paginated_view.js');

		$status = $this->rest->get('options', 
			array(
				'option_group' => 'EMPLOYMENT-STATUS',
				'sort'		   => 'sort_order',
				'order'		   => 'asc'
				), 'json');				
		
		$all = new stdClass();
		$all->option = 'All';
		$all->option_id = '';

		$status->data[] = $all;

		$this->layout->view('user/admin/user_list', array(
			'employment_statuses' => $status->data
			)
		);        
	}
}
