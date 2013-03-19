<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Employee_controller extends HDI_rest_controller
{
	function __construct()
	{
		parent::__construct();		
        $this->load->model('goal_model');
        $this->load->model('goal_item_model');     
	}

    public function goals_get()
    {
        $this->_args['created_by'] = $this->get_user()->employee_id;

        $my_goals = $this->goal_model->fetch($this->_args);
        $assigned_goals = $this->goal_model->get_assigned_goals($this->get_user()->employee_id);

        $response['_count'] = $my_goals->num_rows() + $assigned_goals->num_rows();
        $response['data']   = array();

        if ($response['_count'] > 0)
        {
            $params = array();

            $goals = array_merge($assigned_goals->result(), $my_goals->result());

            foreach ($goals as $goal) {
                $goal = new Goal($goal);

                $response['data'][] = $goal->getData();
            }
        }

        $this->response($response);
    }

    // --------------------------------------------------------------------

    public function created_get() 
    {
        $this->_args['created_by'] = $this->get_user()->employee_id;

        $emp_goals = $this->goal_model->fetch($this->_args);

        $response['_count'] = $emp_goals->num_rows();
        $response['data']   = array();

        if ($response['_count'] > 0)
        {
            $params = array();

            foreach ($emp_goals->result() as $goal) {
                $goal = new Goal($goal);

                $response['data'][] = $goal->getData();
            }
        }

        $this->response($response);
    }


    // --------------------------------------------------------------------

    public function assigned_get() 
    {
        $emp_goals = $this->goal_model->get_assigned_goals($this->get_user()->employee_id);

        $response['_count'] = $emp_goals->num_rows();
        $response['data']   = array();

        if ($response['_count'] > 0)
        {
            $params = array();

            foreach ($emp_goals->result() as $goal) {
                $goal = new Goal($goal);

                $response['data'][] = $goal->getData();
            }
        }

        $this->response($response);
    }    
}