<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Options_controller extends HDI_rest_controller
{
    // Filters for sending out data via REST, we don't want to give out data like passwords and such.
    private $_response_filter = array('');

	function __construct()
	{
		parent::__construct();

        $this->load->model('options_model', 'model');
        $this->load->model('moptions_model', 'model2');
        $this->load->library('Options');
	}

    // --------------------------------------------------------------------

    /**
     * Returns Options when called via get
     *
     * @param data array Key-Field pair of values to filter.
     *          
     * @return xml
     */
	function options_get()
	{
        $search   = array();
        $response = FALSE;        
        
        $cache = Cache::get_instance();
        $response = $cache::get('options' . serialize($this->_args));
        $last_modified = $this->model->get_last_modified_date();

        if (!$response || $last_modified != $response['_last_modified']) {
            $response['_count'] = $this->model->count_results($this->_args);
            $response['_last_modified'] = $last_modified;

            if ($response['_count'] > 0)
            {
                $response['data'] = $this->model->fetch($this->_args)->result();
            }                             
            
            $cache::save('options' . serialize($this->_args), $response, 3600);
        }

        $this->response($response);
	}

    /**
     * Returns Options when called via get
     *
     * @param data array Key-Field pair of values to filter.
     *          
     * @return xml
     */
    function moptions_get()
    {
        $search   = array();
        $response = FALSE;        
        
        $cache = Cache::get_instance();
        $response = $cache::get('moptions' . serialize($this->_args));

        if (!$response) {
            $response['_count'] = $this->model2->count_results($this->_args);

            if ($response['_count'] > 0)
            {
                $response['data'] = $this->model2->fetch($this->_args)->result();
            }                 
            $response['l'] = $this->db->last_query();          
            //$cache::save('options' . serialize($this->_args), $response);
        }

        $this->response($response);
    }   

    // --------------------------------------------------------------------

    /**
     * Returns employees when called via get
     * 
     * @return xml
     */
    function masters_get()
    {
        $cache = Cache::get_instance();        
        
        $response = $cache::get('masters' . serialize($this->_args));

        if (!$response) {
            $response['_count'] = $this->model->count_results($this->_args);

            if ($response['_count'] > 0)
            {
                $masters = $this->model->fetch($this->_args, TRUE);
                foreach ($masters->result() as $master) {
                    $e = new Options();
                    $e->loadArray($master);
                    $response['data'][] = $e->getData();
                }
            }

            $cache::save('masters' . serialize($this->_args), $response);
        }
        
        $this->response($response, 200, 'xml');
    }

    // --------------------------------------------------------------------

    /**
     * Returns a single master.
     * 
     * @return xml
     */
    function master_get()
    {
        $load = 'employee_id';
        if ($this->get('id') != '') {
            $id   = $this->get('id');     
        } else {
            $id = $this->get_user()->employee_id;
        }

        $cache = Cache::get_instance();
        $employee = $cache::get('employee' . $id);

        if (!$employee) {            
            $employee = new Employee($id);            
            $cache::save('employee' . $employee->employee_id, $employee, 1800);
        }
        
        $response = $employee->getData();        

        $this->response($response);        
    }

    // --------------------------------------------------------------------	
}
