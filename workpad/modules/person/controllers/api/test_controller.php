<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Test_controller extends HDI_rest_controller
{
	function __construct()
	{
		parent::__construct();		
        $this->load->library('Test');
	}

    // --------------------------------------------------------------------

    public function test_get()
    {
        $this->response($this->get('id'));
    }

    // --------------------------------------------------------------------

    public function test_post()
    {
        $test = new Test();
        $test->persist($this->_args);

        if ($test->save()) {            
        	$response = $test->getData();
        	$response['url'] = site_url('api/test/id/' . $test->id);

        	$this->response($this->_args, 201);
        } else {
        	$this->response(array('message' => $test->get_validation_errors()), 403);
        }        
    }    

    // --------------------------------------------------------------------

    public function test_put()
    {
        $test = new Test($this->put('id'));
        $test->persist($this->_args);

        if ($test->save()) {            
            $this->response($test->getData());
        } else {
            $this->response(array('message' => $test->get_validation_errors()), 403);
        }        
    }     

    // --------------------------------------------------------------------
    
    public function test_delete()
    {
        $test = new Test($this->get('id'));
        
        $this->response($test->delete());
    }    
}