<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Thankyou_controller extends HDI_rest_controller
{
	function __construct()
	{
		parent::__construct();		
        $this->load->model('thankyou_model', 'model');
        $this->load->library('Thankyou');        
	}

    // --------------------------------------------------------------------

    /**
     * Get a set of thankyous
     * 
     * @return mixed
     */
    public function thankyous_get()
    {        
        $cache = Cache::get_instance();        
        
        $response = $cache::get('thankyou' . serialize($this->_args));

        if (!$response) {
            $response['_count'] = $this->model->count_results($this->_args);

            if ($response['_count'] > 0)
            {
                $thankyous = $this->model->fetch($this->_args, TRUE);

                if ($this->get('raw')) {
                    $response['data'] = $thankyous->result();
                } else {                    
                    foreach ($thankyous->result() as $thankyou) {
                        $e = new Thankyou();
                        $e->loadArray($thankyou);
                        $response['data'][] = $e->getData();
                    }
                }
            }

            $cache::save('thankyou' . serialize($this->_args), $response);
        }
        
        $this->response($response, 200, 'xml');
    }

	// --------------------------------------------------------------------

	/**
	 * Get a thankyou with ID of
	 * 
	 * @return mixed
	 */
    public function thankyou_get()
    {        

    }

    // --------------------------------------------------------------------
    
    /**
     * Add a new thankyou via the API
     */
    public function thankyou_post()
    {
        if (!$this->acl->check_acl('THANKYOU_POST', $this->get_user()->login)) {
            $this->response(null, 403);
        } else {
            $thankyou = new Thankyou();
            $thankyou->user_id      = $this->get_user()->user_id;
            $thankyou->recipient_id = $this->post('recipient_id');
            $thankyou->message      = $this->post('message');            

            if (!$thankyou->save()) {
                $response['message'] = $thankyou->get_validation_errors();
            } else {
                // Create notification.
                $this->load->library('ThankyouNotification');
                $notification = new ThankyouNotification();
                $notification->set_thankyou($thankyou);

                if (!$notification->save()) {
                    $response['message'] = $notification->get_validation_errors();
                } else {
                    $response['id']  = $thankyou->id;
                    $response['url'] = site_url('api/thankyou/id/' . $thankyou->id);

                    $this->response($response, 201);

                    return;                    
                }
            }

            $this->response($response);
        }
    }  
}