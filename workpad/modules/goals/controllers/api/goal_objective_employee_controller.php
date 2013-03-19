<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Goal_objective_employee_controller extends HDI_rest_controller
{
	function __construct()
	{
		parent::__construct();        
	}

    // --------------------------------------------------------------------

    function employee_get()
    {
        $response = Cache::get_instance()->get('goal_item_employee'. $this->get('id'));

        if (!$response) {
            $goal_item_employee = new Goal_Item_Employee($this->get('id'));
            
            $response = $goal_item_employee->getData();
        }

        $this->response($response);
    }

    // --------------------------------------------------------------------
    
    function employee_delete() 
    {
        $goal = new Goal_Item_Employee($this->get('id'));
        $this->response($goal->delete());
    }    
}