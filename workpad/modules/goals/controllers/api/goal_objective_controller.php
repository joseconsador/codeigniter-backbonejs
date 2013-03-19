<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Goal_objective_controller extends HDI_rest_controller
{
	function __construct()
	{
		parent::__construct();        
	}

    // --------------------------------------------------------------------

    function goal_item_get()
    {
        $response = Cache::get_instance()->get('goal_item'. $this->get('id'));

        if (!$response) {
            $goal_item = new Goal_Item($this->get('id'));
            $response = $goal_item->getData();
        }

        $this->response($response);
    }        

    // --------------------------------------------------------------------
    
    function goal_item_post() 
    {
        $goal_item = new Goal_Item();
        $goal_item->persist($this->_args);

        if ($this->post('involved')) {
            $this->_add_involved($this->post('involved'), $goal_item);
        }

        $id = $goal_item->save();

        if ($id) {            
            $response = $goal_item->getData();
            Cache::get_instance()->save('goal_item' . $id, $response);
            $response['url'] = site_url('api/goal_item/id/' . $id, 3600);
            $code = 201;
        } else {
            $response['message'] = $goal_item->get_validation_errors();
            $code = 403;
        }        

        $this->response($response, $code);        
    }

    // --------------------------------------------------------------------
    
    function goal_item_put() 
    {
        $goal_item = new Goal_Item($this->get('id'));

        if (!$goal_item->is_owner()) {
            show_access_denied();            
        }

        $goal_item->persist($this->_args);

        if ($this->put('involved')) {
            $this->_add_involved($this->put('involved'), $goal_item);
        }

        $id = $goal_item->save();

        if (!$id) {
            $this->response(array('message' => $goal_item->get_validation_errors()), 403);
        } else {
            $cache = Cache::get_instance();
            $response = $goal_item->getData();
            Cache::get_instance()->save('goal_item' . $goal_item->goal_item_id, $response, 3600);
            $this->response($response);
        }
    }

    // --------------------------------------------------------------------
    
    function goal_item_delete() 
    {
        $goal = new Goal_Item($this->get('id'));
        
        if (!$goal->is_owner()) {
            show_access_denied();
        }
        
        $this->response($goal->delete());
    }    


    // --------------------------------------------------------------------
    
    private function _add_involved(array $involved, Goal_Item $objective)
    {
        foreach ($involved as $user) {
            $objective->add_involved($user);
        }
    }    
}