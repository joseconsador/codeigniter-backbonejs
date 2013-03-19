<?php

class Calendar_Event_Participant_Observer
{
	public function notify_participant($participant)
	{
        $notification = new Calendar_Event_Participant_Notification($participant);
        $notification->send();

        return $this;
	}
}