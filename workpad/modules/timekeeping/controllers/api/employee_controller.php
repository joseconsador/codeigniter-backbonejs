<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Employee_controller extends HDI_rest_controller
{    
	function __construct()
	{
		parent::__construct();
	}

    // --------------------------------------------------------------------
    
    /**     
     * Fetch an employee's timelog.
     *
     * @param int $id employee_id
     */
    function timelogs_get()
    {
        $this->load->library('Timerecord');
        $this->load->model('timerecord_model', 'model');

        if ($this->get('id') != $this->get_user()->user_id &&
            !$this->acl->check_acl('EMPLOYEE_TIMELOG_GET', $this->get_user()->login)) {
            $this->response(null, 403);
        }

        $this->_args['employee_id'] = $this->get('id');
        $logs = $this->model->get_logs_from_range($this->_args);
        $response['_count'] = $logs->num_rows();

        if ($response['_count'] > 0) {
            $o_logs = $logs->result();

            foreach ($o_logs as $log) {
                $timerecord = new Timerecord($log);
                $response['data'][] = $timerecord->getData();
            }
        }

        $this->response($response);
    }

    // --------------------------------------------------------------------
    
    /**     
     * Fetch an employee's shift.
     *
     * @param int $id employee_id
     */
    function shift_get()
    {
        $this->load->library('Employee');

        $employee = new Employee($this->get('id'));        

        $response = null;

        if (!is_null($employee->get_shift())) {
            $response = $employee->get_shift()->getData();
        }

        $this->response($response);
    }    

    // --------------------------------------------------------------------
    
    /**
     * Return available leavetypes for given user
     * 
     * @param int $id employee_id
     *
     * @return json [description]
     */
    function leavetypes_get()
    {
        $this->load->model('formtype_model');

        $this->_args['is_leave'] = TRUE;
        $types = $this->formtype_model->get_allowed_types($this->get('id'), $this->_args);

        $response['_count'] = $types->num_rows();

        if ($response['_count'] > 0) {            
            $response['data'] = $types->result();            
        }

        $this->response($response);
    }    
}