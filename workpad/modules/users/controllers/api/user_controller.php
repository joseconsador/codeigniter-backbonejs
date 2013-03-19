<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class User_controller extends HDI_rest_controller
{
    // Filters for sending out data via REST, we don't want to give out data like passwords and such.
    private $_user_response_filter = array('password', 'login');

	function __construct()
	{
		parent::__construct();
		$this->load->model('users_model', 'model');
        $this->load->library('User');
	}

    // --------------------------------------------------------------------

    /**
     * Returns Users when called via get
     *
     * @param data array Key-Field pair of values to filter.
     *
     * Allowed 'data':
     *
     *    - department_id : filter by department ID
     *    - position_id   : filter by position ID
     *    - company_id    : filter by company ID
     *    - exclude_ids   : exclude user_id 
     * 
     * @return xml
     */
	function users_get()
	{
        $search   = array();
        $response = FALSE;        
        
        $cache = Cache::get_instance();
        $response = $cache::get('users' . serialize($this->_args));
        $last_modified = $this->model->get_last_modified_date();

        if (!$response || $last_modified != $response['_last_modified']) {
            $response = array();            
            $response['_count'] = $this->model->count_results($this->_args);
            $response['_last_modified'] = $last_modified;

            if ($response['_count'] > 0)
            {
                $results = $this->model->fetch($this->_args, TRUE);

                $users = $results->result();

                foreach ($users as $user) {
                    $e = new User();
                    $e->loadArray($user);
                    $response['data'][] = Rest_ResponseFilter::filter(
                        $e->getdata(), 
                        $this->_get_response_filer()
                    );
                }
            }                 
            
            $cache::save('users' . serialize($this->_args), $response);
        }

        $this->response($response);
	}

    // --------------------------------------------------------------------        

    private function _get_response_filer()
    {
        if ($this->acl->check_acl(User::USER_ALL_ACCESS)) {
            return array('password');
        }

        return $this->_user_response_filter;
    }

    // --------------------------------------------------------------------

    /**
     * Returns a single User.
     * 
     * @return xml
     */
    function user_get()
    {
        $load = 'user_id';
        if ($this->get('id') != '') {
            $id   = $this->get('id');            
        } elseif ($this->get('hash') != '') {
            $id   = $this->get('hash');
            $load = 'hash';
        } else {
            $id = $this->get_user()->user_id;
        }
        
        $user = new User();
        $user->load($id, $load);

        $response = Rest_ResponseFilter::filter($user->getData(), $this->_user_response_filter);

        $this->response($response); 
    }

    // --------------------------------------------------------------------
    
    /**
     * Saves or updates a new User.
     * 
     * @return xml
     */
    function user_post()
    {
        $response = array('status' => 'failed', 'message' => '');
    
        $user = new User();

        $user->persist($this->_args);
        $this->save($user);
    }

    // --------------------------------------------------------------------
    
    /**
     * Saves or updates a new User.
     * 
     * @return xml
     */
    function user_put()
    {
        $response = array('status' => 'failed', 'message' => '');

        if ($this->get('id')) {
            $id = $this->get('id');
        } else {
            $id = $this->get_user()->user_id;
        }

        $user = new User($id);

        $user->persist($this->_args);        

        $this->save($user);
    }

    // --------------------------------------------------------------------
    
    function user_delete() 
    {
        $user = new User($this->get('id'));

        $this->response($user->delete());
    }    

    // --------------------------------------------------------------------
    
    /**
     * Get references
     * 
     */    
    function ref_get()
    {
        $this->load->library('UserRef');
        
        $user = new User($this->get('id'));
        $ref = new User_Ref($user->person_id);        

        $this->response($ref->getData());
    }

    // --------------------------------------------------------------------

    /**
     * Returns subordinates when called via get
     * 
     * @return xml
     */
    function subordinates_get()
    {
        $this->load->model('employee_model');

        $cache = Cache::get_instance();
        
        $response = $cache::get('subordinates' . $this->get('id') . serialize($this->_args));
        $last_modified = $this->model->get_last_modified_date();

        if (!$response || $last_modified != $response['_last_modified']) {
            $response['data'] = array();
            $response['_count'] = $this->employee_model->get_subordinates($this->get('id'), $this->_args)->num_rows();
            $response['_last_modified'] = $last_modified;

            if ($response['_count'] > 0)
            {            
                $users = $this->employee_model->get_subordinates($this->get('id'), $this->_args, TRUE);

                if ($this->get('raw')) {
                    $response['data'] = $users->result();
                } else {
                    foreach ($users->result() as $user) {
                        $e = new User();
                        $e->loadArray($user);
                        $response['data'][] = Rest_ResponseFilter::whitelist($e->getData(), 
                            array('user_id', 'employee_id', 'first_name', 'last_name', 'full_name', 'hash')
                        );
                    }
                }
            }

            $cache::save('subordinates' . $this->get('id') . serialize($this->_args), $response, 7200);
        }

        $this->response($response, 200, 'xml');
    }
}