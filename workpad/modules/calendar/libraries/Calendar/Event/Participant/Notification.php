<?php

class Calendar_Event_Participant_Notification
{
	private $_participant;

	public function __construct(Calendar_Event_Participant $participant)
	{
		$this->_participant = $participant;
	}

	public function send()
	{
        $ci =& get_instance();
        $ci->load->library('parser');

        $user = new User($this->_participant->get_event()->user_id);

        $notification = new Notification();
        $notification->recipient_id = $this->_participant->user_id;
        $notification->user_id = $user->user_id;
        $notification->url = 'employee/calendar#/event/invite/' . $this->_participant->getId();
        $notification->notification = $ci->parser->parse(
            'calendar/template/participant_new_notification',
            array(
                'created'  => $user->full_name,
                'event' => $this->_participant->get_event()->title,
                'date_from' => _d($this->_participant->get_event()->date_from, 'M d'),
                )
            , TRUE
        );
        $notification->set_meta(array('id' => $this->_participant->getId()));

        return $notification->save();
	}
}