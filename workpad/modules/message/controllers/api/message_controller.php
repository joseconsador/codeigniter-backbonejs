<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Message_controller extends HDI_rest_controller
{
	function __construct()
	{
		parent::__construct();		
        $this->load->library('Message');
        $this->load->model('message_model', 'model');
	}

    // --------------------------------------------------------------------

    /**
     * Get a set of messages
     * 
     * @return mixed
     */
    public function messages_get()
    {        
        $messages = $this->model->fetch_by_user($this->get_user()->user_id, $this->_args);        

        $response['_count'] = $messages->num_rows();        
        $response['data']   = $messages->result();

        $this->response($response);
    }

    // --------------------------------------------------------------------

    /**
     * Updates all messages of user
     * 
     * @return mixed
     */
    public function messages_put()
    {
        if ($this->model->mark_all_read($this->get_user()->user_id)) {
            $this->response(TRUE);
        } else {
            $this->response(null, 409);
        }

    }    

    // --------------------------------------------------------------------

    /**
     * Gets recieved messages
     * 
     * @return mixed
     */
    public function recieved_get()
    {
        $this->_args['recipient_id'] = $this->get_user()->user_id;

        $response['_count'] = $this->model->count_results($this->_args);
        $response['data']   = array();

        if ($response['_count'] > 0) {
            $messages = $this->model->fetch($this->_args, TRUE)->result();
            foreach ($messages as $message) {
                $m = new Message();
                $m->loadArray($message);                    
                $response['data'][] = $m->getData();
            }
        }

        $this->response($response);
    }

    // --------------------------------------------------------------------

    /**
     * Gets sent messages
     * 
     * @return mixed
     */
    public function sent_get()
    {
        $this->_args['user_id'] = $this->get_user()->user_id;

        $cache = Cache::get_instance();

        if (!$response = $cache::get('messages/received' . serialize($this->_args))) {
            $response['_count'] = $this->model->count_results($this->_args);

            if ($response['_count'] > 0) {
                $messages = $this->model->fetch($this->_args, TRUE)->result();
                foreach ($messages as $message) {
                    $m = new Message();
                    $m->loadArray($message);                    
                    $response['data'][] = $m->getData();
                }
            }
            $cache::save('messages/received' . serialize($this->_args), $response, 30);
        }
        $this->response($response);
    }    

	// --------------------------------------------------------------------

	/**
	 * Get a message with ID of
	 * 
	 * @return mixed
	 */
    public function message_get()
    {        
        $message = new Message($this->get('id'));

        // Only return the message if this user is involved.
        if ($message->user_id == $this->get_user()->user_id 
            || $message->recipient_id == $this->get_user()->user_id) {
            $this->response($message);
        } else {
            $this->response(null, 403);
        }
    }

    // --------------------------------------------------------------------
    
    /**
     * Add a new message via the API
     */
    public function message_post()
    {
    	$data = array();

    	$data['user_id'] = $this->get_user()->user_id;
    	$data['message'] = $this->post('message');
    	$data['recipient_id'] = $this->post('recipient_id');

    	$message = new Message($data);
    	$response = array();

    	if (!$message->save()) {
			$response['message'] = $message->get_validation_errors();
            $this->response($response, 400);
		} else {
			$response['id']       = $message->id;
            $response['resource'] = site_url('api/message/id/' . $message->id);
            $this->response($response, 201);
        }
    }

    // --------------------------------------------------------------------
    
    /**
     * Updates via the API
     */
    public function message_put()
    {
        $data = array();

        $message = new Message($this->put('id'));
        $message->user_id = $this->put('user_id');
        $message->message = $this->put('message');
        $message->recipient_id = $this->put('recipient_id');
        $message->log_read = $this->put('log_read');

        $response = array();

        if (!$message->save()) {
            $response['message'] = $message->get_validation_errors();
            $this->response($response, 400);
        } else {
            $response['id']       = $message->id;
            $response['resource'] = site_url('api/message/id/' . $message->id);
            $this->response($response, 200);
        }
    }    
}