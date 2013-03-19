<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Ref_controller extends HDI_rest_controller
{    
	function __construct()
	{
		parent::__construct();        
	}

    // --------------------------------------------------------------------
    
    /**
     * Get a user's table references.
     * 
     * @return xml
     */
    function ref_get()
    {
        $ref = new User_Ref($this->get('id'));

        $this->response($ref->getData());        
    }

    // --------------------------------------------------------------------
    
    function ref_put()
    {
        $ref = new User_Ref($this->get('id'));
        $ref->persist($this->_args);

        if ($ref->save()) {
            $response = $ref->getData();            

            $cache = Cache::get_instance();
            $cache::delete('user' . $ref->user_id);
            $cache::delete('employee' . $ref->employee_id);
        }

        $this->response($response);
    }
}