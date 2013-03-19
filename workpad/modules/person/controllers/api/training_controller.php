<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Training_controller extends HDI_rest_controller
{
	function __construct()
	{
		parent::__construct();		
        $this->load->library('Training');
	}

    // --------------------------------------------------------------------

    public function training_get()
    {
        $this->response($this->get('id'));
    }

    // --------------------------------------------------------------------

    public function training_post()
    {
        $training = new Training();
        $training->persist($this->_args);

        if ($training->save()) {
        	$response = $training->getData();
        	$response['url'] = site_url('api/training/id/' . $training->id);

        	$this->response($response, 201);
        } else {
        	$this->response(array('message' => $training->get_validation_errors()));
        }        
    }    

    // --------------------------------------------------------------------

    public function training_put()
    {
        $training = new Training($this->put('id'));
        $training->persist($this->_args);

        if ($training->save()) {            
            $this->response($training->getData());
        } else {
            $this->response(array('message' => $training->get_validation_errors()));
        }        
    }     

    // --------------------------------------------------------------------
    
    public function training_delete()
    {        
        $this->load->model('training_model');        
        $this->response($this->training_model->delete($this->get('id')));
    }    
}