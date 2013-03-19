<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Form_controller extends HDI_rest_controller
{    
    const MODULE = 'timekeeping';

	function __construct()
	{
		parent::__construct();
        
        $this->load->model('form_application_model', 'model');
	}

    // --------------------------------------------------------------------

    function forms_get()
    {
        $response = array();
        $response['_count'] = $this->model->count_results($this->_args);

        if ($response['_count'] > 0)
        {
            $forms = $this->model->fetch($this->_args, TRUE);

            if ($this->get('raw')) {
                $response['data'] = $forms->result();
            } else {
                foreach ($forms->result() as $form) {
                    $e = new Form_Application();
                    $e->loadArray($form);
                    $response['data'][] = $e->getData();
                }
            }
        }

        $this->response($response, 200, 'xml');
    }

    // --------------------------------------------------------------------

    function forms_approval_get()
    {
        $this->load->helper('approver');
        $response = array();
        // helpers/approver_helper.php
        $employees = get_employees_for_approval(new User($this->get_user()->user_id), self::MODULE);

        if (count($employees) > 0) {        
            $search = array(
                array(
                    'field' => 'employee_id',
                    'type'  => 'in',
                    'value' => $employees
                ),
                array(
                    'field' => 'status_id',
                    'type'  => 'nin',
                    'value' => array(Form_Application::DRAFT_STATUS, Form_Application::CANCELLED_STATUS)
                )
            );

            $response['_count'] = $this->model->fetch($this->_args, FALSE, $search)->num_rows();
        } else {
            $response['_count'] = 0;
        }

        if ($response['_count'] > 0)
        {
            $forms = $this->model->fetch($this->_args, TRUE, $search);

            if ($this->get('raw')) {
                $response['data'] = $forms->result();
            } else {
                foreach ($forms->result() as $form) {
                    $e = new Form_Application();
                    $e->loadArray($form);
                    $response['data'][] = $e->getData();
                }
            }
        }

        $this->response($response, 200, 'xml');
    }    

    // --------------------------------------------------------------------

    function form_get()
    {
        $form = new Form_Application($this->get('id'));

        $this->response($form->getData());
    }

    // --------------------------------------------------------------------
    
    function form_post() 
    {
        $form = new Form_Application();
    
        $this->_save($form, 201);    
    }

    // --------------------------------------------------------------------
    
    function form_put() 
    {
        $form = new Form_Application($this->get('id'));

        $this->_save($form);
    }

    // --------------------------------------------------------------------

    private function _save(Form_Application $form, $success_code = 200)
    {
        $form->persist($this->_args);

        $this->save($form);
    }

    // --------------------------------------------------------------------
    
    function form_delete() 
    {
        $this->response($this->model->delete($this->get('id')));
    }    

    // --------------------------------------------------------------------
    
    function approve_put() 
    {                
        $form = new Form_Application($this->get('id'));
        $this->_args['status_id'] = Form_Application::APPROVED_STATUS;
        
        $this->_save($form);
    }    

    // --------------------------------------------------------------------
    
    function reject_put()
    {        
        $form = new Form_Application($this->get('id'));
        $this->_args['status_id'] = Form_Application::REJECTED_STATUS;
        
        $this->_save($form);
    }

    // --------------------------------------------------------------------
}