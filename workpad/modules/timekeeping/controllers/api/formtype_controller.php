<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Formtype_controller extends HDI_rest_controller
{    
	function __construct()
	{
		parent::__construct();
        
        $this->load->model('formtype_model', 'model');
	}

    // --------------------------------------------------------------------

    function formtypes_get()
    {
        $cache = Cache::get_instance();        
        
        $response = $cache::get('formtypes' . serialize($this->_args));
        $last_modified = $this->model->get_last_modified_date();

        if (!$response || $last_modified != $response['_last_modified']) {
            $response = array();            
            $response['_count'] = $this->model->count_results($this->_args);            
            $response['_last_modified'] = $last_modified;

            if ($response['_count'] > 0)
            {
                $formtypes = $this->model->fetch($this->_args, TRUE);

                if ($this->get('raw')) {
                    $response['data'] = $formtypes->result();
                } else {                    
                    foreach ($formtypes->result() as $formtype) {
                        $e = new Form_Type();
                        $e->loadArray($formtype);
                        $response['data'][] = $e->getData();
                    }
                }
            }

            $cache::save('formtypes' . serialize($this->_args), $response);
        }
        
        $this->response($response, 200, 'xml');
    }    

    // --------------------------------------------------------------------

    function formtype_get()
    {
        $formtype = new Form_Type($this->get('id'));

        $this->response($formtype->getData());
    }        

    // --------------------------------------------------------------------
    
    function formtype_post() 
    {
        $formtype = new Form_Type();
        $formtype->persist($this->_args);

        $this->save($formtype);    
    }

    // --------------------------------------------------------------------
    
    function formtype_put() 
    {
        $formtype = new Form_Type($this->get('id'));
        $formtype->persist($this->_args);

        $this->save($formtype);
    }

    // --------------------------------------------------------------------
    
    function formtype_delete() 
    {        
        $this->response($this->model->delete($this->get('id')));
    }    

    // --------------------------------------------------------------------
}