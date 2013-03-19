<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Company_controller extends HDI_rest_controller
{
	function __construct()
	{
		parent::__construct();
        $this->load->library('company');
        $this->model = $this->company->getModel();
	}

    // --------------------------------------------------------------------

    /**
     * Returns all companies when called via get
     * 
     * @return xml
     */
    function companies_get()
    {
        $cache = Cache::get_instance();        
        
        $response = $cache::get('companies' . serialize($this->_args));
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
                $companys = $this->model->fetch_all($offset, $limit);
                
                if ($companys) {                                                
                    foreach ($companys->result() as $company) {
                        $e = new Company($company);
                        $response['data'][] = $e->getData();
                    }
                }
            }

            $cache::save('companies' . serialize($this->_args), $response, 86400);
        }        

        $this->response($response, 200, 'xml');

    }
}