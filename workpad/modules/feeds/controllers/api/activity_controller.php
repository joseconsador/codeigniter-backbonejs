<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Activity_controller extends HDI_rest_controller
{    
	function __construct()
	{
		parent::__construct();
		$this->load->model('activity_model', 'model');
	}

    // --------------------------------------------------------------------

    /**
     * Returns activity when called via get
     * 
     * @return xml
     */
	function activity_get()
	{        
        if (!$this->get('id')) {
            $id = $this->get_user()->user_id;
        } else {
            $id = $this->get('id');
        }
        $offset = 0;
        if ($this->get('offset')) {
            $offset = $this->get('offset');
        }
        
        $limit = 10;
        if ($this->get('limit')) {
            $limit = $this->get('limit');
        }

        $this->load->helper('approver');
        $this->load->model(array('employee_model', 'activity_model'));

        $response['_count'] = 0;            
        $response['data'] = array();

        $user = new User($id);
        
        $search = array(
                array(
                    'field' => 'user_id', 'type' => 'eq' , 'value' => $id,
                    )
            );

        $response['_count'] += $this->activity_model->fetch($this->_args, FALSE, $search)->num_rows();

        if ($response['_count'] > 0) {                
            $response['data'] = $this->activity_model->fetch($this->_args, TRUE, $search)->result();
        }

        $approvals = get_employees_for_approval($user, Form_Application::MODULE);        

        if (count($approvals) > 0) {
            $search = array(
                    array(
                        'field' => 'user_id', 'type' => 'in' , 'value' => $approvals,                        
                        ),
                    array('field' => 'resource_type', 'value' => 'form_application')
                );

            $response['_count'] += $this->activity_model->fetch($this->_args, FALSE, $search)->num_rows();

            if ($response['_count'] > 0) {
                $approval_data = $this->activity_model->fetch($this->_args, TRUE, $search)->result();
                $response['data'] = array_merge($response['data'], $approval_data);
            }
        }

        $subordinates = $this->employee_model->get_subordinates($user->user_id);

        if ($subordinates->num_rows() > 0) {
            foreach ($subordinates->result() as $sub) {
                $subarray[] = $sub->user_id;
            }

            $exclude = array();

            foreach ($response['data'] as $act) {
                $exclude[] = $act->log_id;
            }

            if (count($exclude) > 0) {
                $search = array(array(
                            'field' => 'user_id', 'type' => 'in' , 'value' => $subarray,
                            'field' => 'log_id', 'type' => 'nin' , 'value' => $exclude
                        )
                    );
            } else {
                $search = array(array(
                            'field' => 'user_id', 'type' => 'in' , 'value' => $subarray,                      
                        )
                    );                
            }

            $response['_count'] += $this->activity_model->search($search)->num_rows();

            if ($response['_count'] > 0) {
                $subordinates_activity = $this->activity_model->fetch($this->_args, TRUE, $search);

                $response['data'] = array_merge($response['data'], $subordinates_activity->result());
            }
        }

        if ($response['_count'] > 0) {
            // Sort by created asc
            foreach ($response['data'] as $key => $data) {
                $created[$key] = $data->created;
            }

            array_multisort($created, SORT_DESC, $response['data']);

            $response['data'] = array_slice($response['data'], $offset, $limit);
        }

        $this->response($response);
	}

}