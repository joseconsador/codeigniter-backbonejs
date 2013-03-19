<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Notification_controller extends HDI_rest_controller
{
	function __construct()
	{
		parent::__construct();		
        $this->load->library('Notification');
        $this->load->model('notification_model', 'model');
	}

    // --------------------------------------------------------------------

    /**
     * Add new notification
     * 
     * @return mixed
     */
    public function notification_post()
    {
        $notification = new Notification();

        $notification->user_id = $this->post('user_id');
        $notification->notification = $this->post('notification');
        $notification->recipient_id = $this->post('recipient_id');

        if ($notification->save()) {
            $response['id'] = $notification->id;
            $response['url'] = site_url('api/notification/id/' . $notification->id);
            $this->response($response, 201);
        } else {
            $this->response($notification->get_validation_errors());
        }
    }

    // --------------------------------------------------------------------

    /**
     * Updates all notifications of user
     * 
     * @return mixed
     */
    public function notifications_put()
    {
        if ($this->model->mark_all_read($this->get_user()->user_id)) {
            $this->response(TRUE);
        } else {
            $this->response(null, 409);
        }

    }
}