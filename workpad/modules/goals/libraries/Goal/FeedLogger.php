<?php

class Goal_FeedLogger extends Activity_Logger
{
	public function log($action)
	{
        $log['user_id'] = $this->get_source()->get_created_by()->user_id;
        $log['action']  = $action;        
        $log['resource_type'] = 'goal';

        $log['data'] = serialize(
            array(
                'id' => $this->get_source()->getId(),
                'created_by' => $this->get_source()->get_created_by()->user_id,
                'created_by_name' => $this->get_source()->get_created_by()->full_name,
                'full_name' => $this->get_source()->get_created_by()->full_name,
                'target' => $this->get_source()->target,
                'title' => $this->get_source()->title,
            )
        );

        return $this->get_logger()->loadArray($log)->save();
	}
}