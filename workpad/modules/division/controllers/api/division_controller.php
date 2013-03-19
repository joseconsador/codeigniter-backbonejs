<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Division_controller extends HDI_rest_controller
{
    // Filters for sending out data via REST, we don't want to give out data like passwords and such.
    private $_response_filter = array('');

	function __construct()
	{
		parent::__construct();
        $this->load->library('division');
        $this->model = $this->division->getModel();
	}

    // --------------------------------------------------------------------

    /**
     * Returns all divisions when called via get
     * 
     * @return xml
     */
    function divisions_get()
    {
        $cache = Cache::get_instance();        
        
        $response = $cache::get('divisions' . serialize($this->_args));
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
                $divisions = $this->model->fetch_all($offset, $limit);
                
                if ($divisions) {                                                
                    foreach ($divisions->result() as $division) {
                        $e = new Division($division);
                        $response['data'][] = $e->getData();
                    }
                }
            }

            $cache::save('divisions' . serialize($this->_args), $response, 86400);
        }        

        $this->response($response, 200, 'xml');

    }
}