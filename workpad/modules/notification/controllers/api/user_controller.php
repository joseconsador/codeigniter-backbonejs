<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class User_controller extends HDI_rest_controller
{
	function __construct()
	{
		parent::__construct();	
        $this->load->model('notification_model', 'model');
        $this->load->library('Notification');        
	}

    // --------------------------------------------------------------------

    /**
     * Return notifications of user
     * @return json
     */
    function notifications_get()
    {
        $this->_args['recipient_id'] = $this->_args['id'];

        $response['_count'] = $this->model->count_results($this->_args);
        $response['data']   = array();

        if ($response['_count'] > 0)
        {
            $notifications = $this->model->fetch($this->_args, TRUE);

            if ($this->get('raw')) {
                $response['data'] = $notifications->result();
            } else {
                foreach ($notifications->result() as $notification) {
                    $e = new Notification();
                    $e->loadArray($notification);
                    $response['data'][] = $e->getData();
                }
            }
        }
        
        $this->response($response, 200, 'xml');
    }
}