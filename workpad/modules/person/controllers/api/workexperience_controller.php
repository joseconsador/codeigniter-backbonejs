<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Workexperience_controller extends Hdi_Rest_Controller
{
	function __construct()
	{
		parent::__construct();		
        $this->load->library('Work');
	}

    // --------------------------------------------------------------------

    public function work_get()
    {
        $this->response($this->get('id'));
    }

    // --------------------------------------------------------------------

    public function work_post()
    {
        $work = new Work();
        $work->persist($this->_args);

        if ($work->save()) {
        	$response = $work->getData();
        	$response['url'] = site_url('api/workexperience/id/' . $work->id);

        	$this->response($response, 201);
        } else {
        	$this->response(array('message' => $work->get_validation_errors()));
        }        
    }    

    // --------------------------------------------------------------------

    public function work_put()
    {
        $work = new Work($this->put('id'));
        $work->persist($this->_args);

        if ($work->save()) {            
            $this->response($work->getData());
        } else {
            $this->response(array('message' => $work->get_validation_errors()));
        }        
    }     

    // --------------------------------------------------------------------
    
    public function work_delete()
    {        
        $this->load->model('work_model');        
        $this->response($this->work_model->delete($this->get('id')));
    }    
}