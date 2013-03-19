<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class User_controller extends HDI_rest_controller
{
	function __construct()
	{
		parent::__construct();		
        $this->load->model('todo_model');
	}

    // --------------------------------------------------------------------

    public function todo_get() 
    {
        $this->_args['user_id'] = $this->get_user()->user_id;

        $user_todo = $this->todo_model->fetch($this->_args);

        $response['_count'] = $user_todo->num_rows();
        $response['data']   = array();

        if ($response['_count'] > 0)
        {
            $params = array();

            foreach ($user_todo->result() as $todo) {
                $todo = new Todo($todo);   

                $response['data'][] = $todo->getData();
            }
        }

        $this->response($response);
    }
}