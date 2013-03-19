<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Unit_controller extends HDI_rest_controller
{
	function __construct()
	{
		parent::__construct();		
        $this->load->library('Unit');
	}

    // --------------------------------------------------------------------

    public function unit_get()
    {
        $this->response($this->get('id'));
    }

    // --------------------------------------------------------------------

    public function unit_post()
    {
        $unit = new Unit();
        $unit->persist($this->_args);

        if ($unit->save()) {
            $response = $unit->getData();        	
        	$response['url'] = site_url('api/unit/id/' . $unit->id);

        	$this->response($response, 201);
        } else {
        	$this->response(array('message' => $unit->get_validation_errors()), 403);
        }
    }

    // --------------------------------------------------------------------

    public function unit_put()
    {
        $unit = new Unit($this->put('id'));
        $unit->persist($this->_args);

        if ($unit->save()) {            
            $this->response($unit->getData());
        } else {
            $this->response(array('message' => $unit->get_validation_errors()), 403);
        }
    }     

    // --------------------------------------------------------------------
    
    public function unit_delete()
    {
        $unit = new Unit($this->get('id'));
        
        $this->response($unit->delete());
    }    
}