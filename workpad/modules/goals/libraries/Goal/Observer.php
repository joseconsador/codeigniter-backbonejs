<?php

class Goal_Observer
{
	public function log_new_goal_feed($goal)
	{
        $logger = Activity_LoggerFactory::get_logger(new Goal_FeedLogger(), $goal);
        $logger->log('create');

        return $this;
	}

	public function log_new_goal_item_feed($goal)
	{
        $logger = Activity_LoggerFactory::get_logger(new Goal_Item_FeedLogger(), $goal);
        $logger->log('create');

        return $this;
	}	
}