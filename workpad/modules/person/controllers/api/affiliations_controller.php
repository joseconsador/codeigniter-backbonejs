<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Affiliations_controller extends HDI_rest_controller
{
	function __construct()
	{
		parent::__construct();		
        $this->load->library('Affiliation');
	}

    // --------------------------------------------------------------------

    public function affiliation_get()
    {
        $this->response($this->get('id'));
    }

    // --------------------------------------------------------------------

    public function affiliation_post()
    {
        $affiliation = new Affiliation();
        $affiliation->persist($this->_args);

        if ($affiliation->save()) {
        	$response = $affiliation->getData();
        	$response['url'] = site_url('api/affiliation/id/' . $affiliation->id);

        	$this->response($response, 201);
        } else {
        	$this->response(array('message' => $affiliation->get_validation_errors()));
        }        
    }    

    // --------------------------------------------------------------------

    public function affiliation_put()
    {
        $affiliation = new Affiliation($this->put('id'));
        $affiliation->persist($this->_args);

        if ($affiliation->save()) {            
            $this->response($affiliation->getData());
        } else {
            $this->response(array('message' => $affiliation->get_validation_errors()));
        }        
    }     

    // --------------------------------------------------------------------
    
    public function affiliation_delete()
    {        
        $this->load->model('affiliation_model');        
        $this->response($this->affiliation_model->delete($this->get('id')));
    }    
}