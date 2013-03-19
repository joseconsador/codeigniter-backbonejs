<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Education_controller extends HDI_rest_controller
{
	function __construct()
	{
		parent::__construct();		
        $this->load->library('Education');
	}

    // --------------------------------------------------------------------

    public function education_get()
    {
        $this->response($this->get('id'));
    }

    // --------------------------------------------------------------------

    public function education_post()
    {
        $education = new Education();
        $education->persist($this->_args);

        if ($education->save()) {
        	$response = $education->getData();
        	$response['url'] = site_url('api/education/id/' . $education->id);

        	$this->response($response, 201);
        } else {
        	$this->response(array('message' => $education->get_validation_errors()));
        }        
    }    

    // --------------------------------------------------------------------

    public function education_put()
    {
        $education = new Education($this->put('id'));
        $education->persist($this->_args);

        if ($education->save()) {            
            $this->response($education->getData());
        } else {
            $this->response(array('message' => $education->get_validation_errors()));
        }        
    }     

    // --------------------------------------------------------------------
    
    public function education_delete()
    {        
        $this->load->model('education_model');        
        $this->response($this->education_model->delete($this->get('id')));
    }    
}