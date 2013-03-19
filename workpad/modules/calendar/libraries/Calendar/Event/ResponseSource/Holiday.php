<?php

class Calendar_Event_ResponseSource_Holiday extends Calendar_Event_ResponseSource
{
	function format()
	{
    	$return['type']  = 'holiday';
        $return['allday'] = '1';
        $return['start'] = strtotime($this->_eventSource->calendar);
        $return['end']   = strtotime($this->_eventSource->calendar);
        $return['color'] = '#91414A';
		$return['title'] = $this->_eventSource->holiday;
        $return['editable'] = '0';

        return $return;
	}
}