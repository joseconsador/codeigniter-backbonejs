<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Department_controller extends HDI_rest_controller
{
    // Filters for sending out data via REST, we don't want to give out data like passwords and such.
    private $_response_filter = array('');

	function __construct()
	{
		parent::__construct();
        $this->load->library('department');
        $this->model = $this->department->getModel();
	}

    // --------------------------------------------------------------------

    /**
     * Returns all departments when called via get
     * 
     * @return xml
     */
    function departments_get()
    {
        $cache = Cache::get_instance();        
        
        $response = $cache::get('departments' . serialize($this->_args));
        $last_modified = $this->model->get_last_modified_date();

        if (!$response || $last_modified != $response['_last_modified']) {
            $response['_last_modified'] = $last_modified;

            $offset = 30;
            if ($this->get('offset') != '') {
                $offset = $this->get('offset');
            }

            $limit = 0;
            if ($this->get('limit') != '') {
                $limit = $this->get('limit');
            }

            $records = $this->model->fetch_all();

            $total = $records->num_rows();
                
            if ($total > 0)
            {
                $departments = $this->model->fetch_all($offset, $limit);
                
                if ($departments) {                                                
                    foreach ($departments->result() as $department) {
                        $e = new Department($department);
                        $response['data'][] = $e->getData();
                    }
                }
            }

            $cache::save('departments' . serialize($this->_args), $response, 86400);
        }        

        $this->response($response, 200, 'xml');

    }

    // --------------------------------------------------------------------

    /**
     * Returns a Department when called via get
     * 
     * @return xml
     */
    function department_get()
    {
        $department = new Department($this->get('id'));

        $response = FALSE;
        
        if ($department->hasData()) {
            $response                = $department->getData();
            $response['total_users'] = $department->get_user_count();
        }

        $this->response($response);
    }

    // --------------------------------------------------------------------

    /**
     * Returns users within the department
     * 
     * @return xml
     */
    function users_get()
    {
        $this->load->model('users_model');
        $cache = Cache::get_instance();        
        
        $this->_args['department_id'] = $this->get('id');
        
        $response = $cache::get('departmentusers' . serialize($this->_args));
        $last_modified = $this->users_model->get_last_modified_date();

        if (!$response || $last_modified != $response['_last_modified']) {
            $response['_last_modified'] = $last_modified;            

            $response['_count'] = $this->users_model->count_results($this->_args);
            
            if ($response['_count'] > 0) {
                $response['data'] = $this->users_model->fetch($this->_args, TRUE)->result();
            }

            $cache::save('departmentusers' . serialize($this->_args), $response, 3600);
        }

        $this->response($response);
    }
}