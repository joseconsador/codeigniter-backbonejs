<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Skills_controller extends HDI_rest_controller
{
	function __construct()
	{
		parent::__construct();		
        $this->load->library('Skill');
	}

    // --------------------------------------------------------------------

    public function skill_get()
    {
        $this->response($this->get('id'));
    }

    // --------------------------------------------------------------------

    public function skill_post()
    {
        $skill = new Skill();
        $skill->persist($this->_args);

        if ($skill->save()) {
        	$response = $skill->getData();
        	$response['url'] = site_url('api/skill/id/' . $skill->id);            
        	$this->response($response, 201);
        } else {
        	$this->response(array('message' => $skill->get_validation_errors()));
        }        
    }    

    // --------------------------------------------------------------------

    public function skill_put()
    {
        $skill = new Skill($this->put('id'));
        $skill->persist($this->_args);

        if ($skill->save()) {            
            $this->response($skill->getData());
        } else {
            $this->response(array('message' => $skill->get_validation_errors()));
        }        
    }     

    // --------------------------------------------------------------------
    
    public function skill_delete()
    {        
        $this->load->model('skill_model');        
        $this->response($this->skill_model->delete($this->get('id')));
    }    
}