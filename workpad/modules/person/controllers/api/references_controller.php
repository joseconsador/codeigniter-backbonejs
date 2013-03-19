<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class References_controller extends HDI_rest_controller
{
	function __construct()
	{
		parent::__construct();		
        $this->load->library('Reference');
	}

    // --------------------------------------------------------------------

    public function reference_get()
    {
        $this->response($this->get('id'));
    }

    // --------------------------------------------------------------------

    public function reference_post()
    {
        $reference = new Reference();
        $reference->persist($this->_args);

        if ($reference->save()) {
        	$resposne = $reference->getData();
        	$response['url'] = site_url('api/reference/id/' . $reference->id);

        	$this->response($response, 201);
        } else {
        	$this->response(array('message' => $reference->get_validation_errors()));
        }        
    }    

    // --------------------------------------------------------------------

    public function reference_put()
    {
        $reference = new Reference($this->put('id'));
        $reference->persist($this->_args);

        if ($reference->save()) {            
            $this->response($reference->getData());
        } else {
            $this->response(array('message' => $reference->get_validation_errors()));
        }        
    }     

    // --------------------------------------------------------------------
    
    public function reference_delete()
    {        
        $this->load->model('reference_model');        
        $this->response($this->reference_model->delete($this->get('id')));
    }    
}