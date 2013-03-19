<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Details_controller extends HDI_rest_controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('Detail');
    }

    // --------------------------------------------------------------------

    public function detail_get()
    {
        $detail = new Detail($this->get('id'));

        $this->response($detail->getData());
    }


    // --------------------------------------------------------------------

    public function detail_post()
    {
        $response = array('status' => 'failed', 'message' => '');
    
        $detail = new Detail();
        
        $id = $detail->persist($this->_args)->save();

        if ($id) {
            $response['id'] = $id;
            $response['url'] = site_url('api/persondetail/id/' . $id);
        } else {
            $response['message'] = $detail->get_validation_errors();
        }        

        $this->response($response, 201, 'xml');
    }

    // --------------------------------------------------------------------

    public function detail_put()
    {
        $detail = new Detail($this->put('id'));
        $detail->persist($this->_args);

        $id = $detail->save();

        if (!$id) {
            $this->response(array('message' => $detail->get_validation_errors()));
        } else {
            $cache = Cache::get_instance();
            $cache::delete('persondetail' . $detail->id);

            $this->load->library('person');

            $person = new Person($detail->person_id);

            $person->persist($this->_args)->save();

            $this->response($detail->getData());
        }
    }   
}