<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class User_controller extends HDI_rest_controller
{    
    function __construct()
    {
        parent::__construct();
        $this->load->model('thankyou_model', 'model');
        $this->load->library('Thankyou');
    }

    // --------------------------------------------------------------------

    /**
     * Gets recieved thankyous
     * 
     * @return mixed
     */
    public function recieved_get()
    {
        $this->_args['recipient_id'] = $this->get('id');

        $response['_count'] = $this->model->count_results($this->_args);
        $response['data']   = array();

        if ($response['_count'] > 0) {
            $thankyous = $this->model->fetch($this->_args, TRUE)->result();
            foreach ($thankyous as $thankyou) {
                $m = new Thankyou();
                $m->loadArray($thankyou);                    
                $response['data'][] = $m->getData();
            }
        }

        $this->response($response);
    }

    // --------------------------------------------------------------------

    /**
     * Gets sent thankyous
     * 
     * @return mixed
     */
    public function sent_get()
    {

    }    

    // --------------------------------------------------------------------

    /**
     * Returns whether a user can thank another      
     * 
     * @return  yes/no
     */    
    public function cansend_get()
    {
        if (Thankyou::cansend($this->get_user()->user_id, $this->get('recipient_id'))) {
            $this->response('yes');
        } else {
            $this->response('no');
        }
    }
}