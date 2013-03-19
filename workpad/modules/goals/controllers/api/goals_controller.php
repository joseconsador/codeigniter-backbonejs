<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Goals_controller extends HDI_rest_controller
{
	function __construct()
	{
		parent::__construct();		
        $this->load->library('Goal');
        $this->load->model('goal_model', 'model');
	}

    // --------------------------------------------------------------------

    public function goals_get() 
    {
        $response['_count'] = $this->model->count_results($this->_args);
        $response['data']   = array();
        if ($response['_count'] > 0)
        {
            $goals = $this->model->fetch($this->_args, TRUE);

            if ($this->get('raw')) {
                $response['data'] = $goals->result();
            } else {                    
                foreach ($goals->result() as $goal) {                        
                    $e = new Goal();
                    $e->loadArray($goal);
                    $response['data'][] = $e->getData();
                }
            }
        }

        $this->response($response);      
    }

    // --------------------------------------------------------------------

    public function goal_get()
    {
        $response = Cache::get_instance()->get('goal'. $this->get('id'));

        if (!$response) {
            $goal = new Goal($this->get('id'));
            $response = $goal->getData();
        }

        $this->response($response);
    }        

    // --------------------------------------------------------------------
    
    public function goal_post() 
    {
        $goal = new Goal();
        $goal->persist($this->_args);

        $id = $goal->save();

        if ($id) {            
            $response = $goal->getData();
            Cache::get_instance()->save('goal' . $id, $response);
            $response['url'] = site_url('api/goal/id/' . $id, 3600);
            $code = 201;
        } else {
            $response['message'] = $goal->get_validation_errors();
            $code = 403;
        }        

        $this->response($response, $code);        
    }

    // --------------------------------------------------------------------
    
    public function goal_put() 
    {
        $goal = new Goal($this->get('id'));

        if (!$goal->is_owner()) {
            show_access_denied();
        }

        $goal->persist($this->_args);        

        $id = $goal->save();

        if (!$id) {
            $this->response(array('message' => $goal->get_validation_errors()), 403);
        } else {
            $cache = Cache::get_instance();
            $response = $goal->getData();
            Cache::get_instance()->save('goal' . $goal->goal_id, $response, 3600);
            $this->response($response);
        }        
    }

    // --------------------------------------------------------------------
    
    public function goal_delete() 
    {
        $goal = new Goal($this->get('id'));

        if (!$goal->is_owner()) {
            show_access_denied();
        }
        
        $this->response($goal->delete());
    }    

    // --------------------------------------------------------------------

    public function objectives_get() 
    {
        $goal = new Goal($this->get('id'));
        $objectives = $goal->get_items();

        $response['_count'] = count($objectives);

        if ($response['_count'] > 0) {
            foreach ($objectives as $objective) {
                $response['data'][] = $objective->getData();
            }
        }        

        $this->response($response);      
    }      
}