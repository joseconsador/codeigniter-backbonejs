<?php

/**
 * Formats the data to a readable fullcalendar
 */
abstract class Calendar_Event_ResponseSource
{
    protected $_eventSource;

    private function __construct(array $options)
    {
        if (!array_key_exists('source', $options)) {
            throw new Exception("Source not specified.", 1);        
        }

        $this->_eventSource = $options['source'];
    }

    static function get_source($type, $source)
    {
        $obj = 'Calendar_Event_ResponseSource_' . ucfirst($type);
        return new $obj(array('source' => $source));
    }

    abstract function format();
}