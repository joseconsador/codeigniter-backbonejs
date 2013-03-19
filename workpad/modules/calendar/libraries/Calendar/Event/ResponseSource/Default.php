<?php

class Calendar_Event_ResponseSource_Default extends Calendar_Event_ResponseSource
{
	function format()
	{
        $this->_eventSource->type = strtolower($this->_eventSource->type);

        if (in_array($this->_eventSource->type, array('event', 'form'))) {
            $e = Calendar_Event_ResponseSource::get_source($this->_eventSource->type, $this->_eventSource);
            $return = @$e->format();
        }
    
    	$return['type']  = $this->_eventSource->type;
        $return['allday'] = $this->_eventSource->allday;
        $return['start'] = $this->_eventSource->start;
        $return['end']   = $this->_eventSource->end;
        $return['color'] = $this->_eventSource->color;
		$return['title'] = $this->_eventSource->title;
        $return['editable'] = $this->_eventSource->editable;    

        return $return;
	}
}