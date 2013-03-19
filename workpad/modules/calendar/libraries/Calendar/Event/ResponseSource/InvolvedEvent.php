<?php

class Calendar_Event_ResponseSource_InvolvedEvent extends Calendar_Event_ResponseSource
{	
	function format()
	{    
        $participant = new Calendar_Event_Participant($this->_eventSource);
        $event = $participant->get_event();

        $return['type']  = 'involved_event';
        $return['event_participant_id'] = $participant->getId();
        $return['user_id'] = $participant->user_id;
        $return['allday'] = $event->whole_day;
        $return['start'] = strtotime($event->date_from);
        $return['end']   = strtotime($event->date_to);
        $return['color'] = $event->color;
        $return['title'] = $event->title;
        $return['description'] = $event->description;
        $return['location'] = $event->location;
        $return['event_id'] = $event->event_id;
        $return['is_participant'] = TRUE;
        $return['organizer'] = $event->get_user()->full_name;
        $return['organizer_id'] = $event->get_user()->user_id;
        $return['involved'] = $event->get_involved();
        $return['status_id'] = $participant->status_id;

        return $return;
	}
}