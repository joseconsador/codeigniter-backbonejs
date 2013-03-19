<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Involved_controller extends HDI_rest_controller
{
    // --------------------------------------------------------------------

    function involved_get()
    {
        $involved = new Calendar_Event_Participant($this->get('id'));

        if ($this->get('format') == 'eventSource') {
            $response = Calendar_Event_ResponseSource::get_source('involvedEvent', $involved->getData());
            $response = $response->format();
        } else {
            $response = $involved->getData();
        }

        $this->response($response);
    }

    // --------------------------------------------------------------------

    function involved_post()
    {
        $involved = new Calendar_Event_Participant();
        $involved->persist($this->_args);
        $involved->user_id = $this->get_user()->user_id;

        $this->save($involved);
    }

    // --------------------------------------------------------------------

    function involved_put()
    {
        $involved = new Calendar_Event_Participant($this->get('id'));

        if ($involved->user_id == $this->get_user()->user_id ||
            $involved->get_event()->user_id == $this->get_user()->user_id
            ) {
            
            $involved->persist($this->_args);

            $this->save($involved);
        } else {
            show_access_denied();
        }
    }

    // --------------------------------------------------------------------

    function involved_delete()
    {
        $involved = new Calendar_Event_Participant($this->get('id'));

        if ($involved->get_event()->user_id != $this->get_user()->user_id) {
            show_access_denied();
        }

        $this->response($involved->delete());
    }

    // --------------------------------------------------------------------
}