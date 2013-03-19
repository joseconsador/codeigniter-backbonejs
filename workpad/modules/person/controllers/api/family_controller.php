<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Family_controller extends HDI_rest_controller
{
	function __construct()
	{
		parent::__construct();		
        $this->load->library('Family');
	}

    // --------------------------------------------------------------------

    public function family_get()
    {
        $this->response($this->get('id'));
    }

    // --------------------------------------------------------------------

    public function family_post()
    {
        $family = new Family();
        $family->persist($this->_args);

        if ($family->save()) {
        	$response = $family->getData();
        	$response['url'] = site_url('api/family/id/' . $family->id);

        	$this->response($response, 201);
        } else {
        	$this->response(array('message' => $family->get_validation_errors()));
        }        
    }    

    // --------------------------------------------------------------------

    public function family_put()
    {
        $family = new Family($this->put('id'));
        $family->persist($this->_args);

        if ($family->save()) {            
            $this->response($family->getData());
        } else {
            $this->response(array('message' => $family->get_validation_errors()));
        }        
    }     

    // --------------------------------------------------------------------
    
    public function family_delete()
    {        
        $this->load->model('family_model');        
        $this->response($this->family_model->delete($this->get('id')));
    }    
}