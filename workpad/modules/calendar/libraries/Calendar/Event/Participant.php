<?php

/**
 * This class represents a user defined calendar event.
 */
class Calendar_Event_Participant extends Base
{
	private $_event = null;

    // --------------------------------------------------------------------

    public function getModel()
    {
        $CI =& get_instance();
        $CI->load->model('event_participant_model', '' ,true);

        return $CI->event_participant_model;
    }

    // --------------------------------------------------------------------    

    public function get_event()
    {
    	if (is_null($this->_event)) {
    		$this->_event = new Calendar_Event($this->event_id);
    	}

    	return $this->_event;
    }

    // --------------------------------------------------------------------

    public function save()
    {
        if ($this->isNew()) {
            $id = parent::save();

            if ($id) {                
                Hdi_EventDispatcher::dispatch_event('event_participant_add', $this);
            }

            return $id;
        } else {            
            return parent::save();            
        }
    }
}