<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Employee_controller extends HDI_rest_controller
{
    // Filters for sending out data via REST, we don't want to give out data like passwords and such.
    private $_employee_response_filter = array('login', 'password');

	function __construct()
	{
		parent::__construct();
		$this->load->model('employee_model', 'model');
        $this->load->library('employee');
	}

    // --------------------------------------------------------------------

    /**
     * Returns employees when called via get
     * 
     * @return xml
     */
	function employees_get()
	{
        $cache = Cache::get_instance();        
        
        $response = $cache::get('employees' . serialize($this->_args));
        $last_modified = $this->model->get_last_modified_date();

        if (!$response || $last_modified != $response['_last_modified']) {
            $response = array();            
            $response['_count'] = $this->model->count_results($this->_args);            
            $response['_last_modified'] = $last_modified;

            if ($response['_count'] > 0)
            {
                $employees = $this->model->fetch($this->_args, TRUE);

                if ($this->get('raw')) {
                    $response['data'] = $employees->result();
                } else {                    
                    foreach ($employees->result() as $employee) {
                        $e = new Employee();
                        $e->loadArray($employee);
                        $response['data'][] = Rest_ResponseFilter::filter($e->getData(), $this->_employee_response_filter);
                    }
                }
            }

            $cache::save('employees' . serialize($this->_args), $response);
        }
        
        $this->response($response, 200, 'xml');
	}

    // --------------------------------------------------------------------

    /**
     * Returns a single employee.
     * 
     * @return xml
     */
    function employee_get()
    {
        $load = 'employee_id';
        if ($this->get('id') != '') {
            $id   = $this->get('id');     
        } else {
            $id = $this->get_user()->employee_id;
        }

        $cache = Cache::get_instance();
        $response = $cache::get('employee' . $id);

        if (!$response) {            
            $employee = new Employee($id);
            $response = Rest_ResponseFilter::filter($employee->getData(), $this->_employee_response_filter);
            $cache::save('employee' . $employee->employee_id, $response, 1800);
        }        

        $this->response($response);        
    }

    // --------------------------------------------------------------------
    
    /**
     * Adds a new employee.
     * 
     * @return xml
     */
    function employee_post()
    {
        $employee = new Employee();
        $employee->persist($this->_args);

        $id = $employee->save();

        if ($id) {            
            $response = $employee->getData();
            Cache::get_instance()->save('employee' . $id, $response);
            $response['url'] = site_url('api/201/employee/id/' . $id);
            $code = 201;
        } else {
            $response['message'] = $employee->get_validation_errors();
            $code = 403;
        }        

        $this->response($response, $code);
    }

    // --------------------------------------------------------------------
    
    /**
     * Updates an employee.
     * 
     * @return xml
     */
    function employee_put()
    {
        $employee = new Employee($this->put('employee_id'));
        $employee->persist($this->_args);

        $id = $employee->save();

        if (!$id) {
            $this->response(array('message' => $employee->get_validation_errors()), 403);
        } else {
            $cache = Cache::get_instance();
            $cache::delete('employee' . $employee->employee_id);

            $this->response($employee->getData());
        }
    }      
}