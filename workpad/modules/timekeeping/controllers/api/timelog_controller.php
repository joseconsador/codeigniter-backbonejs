<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Timelog_controller extends HDI_rest_controller
{    
	function __construct()
	{
		parent::__construct();

        $this->load->library('Timerecord');
        $this->load->model('timerecord_model', 'model');
	}

    // --------------------------------------------------------------------

    function timelog_get() {}

    // --------------------------------------------------------------------
    
    function timelog_post() {}

    // --------------------------------------------------------------------
    
    function timelog_put() {}

    // --------------------------------------------------------------------
    
    function timelog_delete() {}    

    // --------------------------------------------------------------------
}