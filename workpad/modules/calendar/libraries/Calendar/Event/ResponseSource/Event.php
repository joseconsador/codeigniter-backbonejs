<?php

class Calendar_Event_ResponseSource_Event extends Calendar_Event_ResponseSource
{	
	function format()
	{        
        $event = new Calendar_Event($this->_eventSource);

    	$return['type']  = 'event';    	
        $return['allday'] = $event->whole_day;
        $return['start'] = strtotime($event->date_from);
        $return['end']   = strtotime($event->date_to);
        $return['color'] = $event->color;
        $return['title'] = $event->title;
        $return['description'] = $event->description;
        $return['location'] = $event->location;
        $return['event_id'] = $event->event_id;
        $return['involved'] = $event->get_involved();
        $return['is_participant'] = FALSE;

        return $return;
	}
}