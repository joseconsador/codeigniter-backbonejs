<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Event_controller extends HDI_rest_controller
{
    public function events_get()
    {        
        $this->load->model('event_model', 'model');
        $this->load->model('form_application_model');
        
        $user = new User($this->get_user());// MY_Controller::get_user()

        $sources = $this->model->fetch_calendar_events(
            $user,
            $this->get('from'), 
            $this->get('to'), 
            $this->_args
        );        

        $response = array();

        // Using this style so that whenever there is a new event source, there would be no need
        // to add to this piece of code, instead new classes must be created.
        foreach ($sources as $type => $events) {
            foreach ($events as $t => $source) {
                $e = Calendar_Event_ResponseSource::get_source($type, $source);
                $response[] = $e->format();
            }
        }

        $this->response($response);
    }

    // --------------------------------------------------------------------

    function event_get()
    {
        $event = new Calendar_Event($this->get('id'));

        $this->response($event->getData());
    }

    // --------------------------------------------------------------------

    function event_post()
    {
        $event = new Calendar_Event();
        $event->persist($this->_args);
        $event->user_id = $this->get_user()->user_id;

        if ($this->post('involved')) {
            $this->_add_involved($this->post('involved'), $event);
        }

        $this->save($event);
    }

    // --------------------------------------------------------------------

    function event_put()
    {
        $event = new Calendar_Event($this->get('id'));

        if ($this->get_user()->user_id != $event->user_id) {
            show_access_denied();
        }

        $event->persist($this->_args);

        if ($this->put('involved')) {
            $this->_add_involved($this->put('involved'), $event);
        }

        $this->save($event);
    }

    // --------------------------------------------------------------------

    function event_delete()
    {
        $this->load->model('event_model', 'model');
        $this->response($this->model->delete($this->get('id')));
    }

    // --------------------------------------------------------------------
    
    private function _add_involved(array $involved, Calendar_Event $event)
    {
        foreach ($involved as $user) {
            $event->add_involved($user);
        }
    }
}