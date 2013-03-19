<?php

class Goal_Notification
{
	private $_goal;

	public function __construct(Goal $goal)
	{
		$this->_goal = $goal;
	}

	public function send()
	{
        $ci =& get_instance();
        $ci->load->library('parser');

        $notification = new Notification();
        $notification->recipient_id = $this->_goal->get_created_by()->user_id;
        $notification->user_id = $this->_goal->created_by;
        $notification->notification = $ci->parser->parse(
            'goals/template/goal_new_notification',
            array(
                'created'  => $this->_goal->get_created_by()->full_name,
                'goal' => $this->_goal->title
                )
            , TRUE
        );
        $notification->set_meta(array('id' => $this->_goal->getId()));

        return $notification->save();
	}
}