<?php

class Form_Application_Observer
{

	public function send_new_notification($form)
	{
        $notification = new Form_Application_Notification($form);
        $notification->send_approver();

        return $this;
	}

	public function send_status_update_notification($form)
	{
        $notification = new Form_Application_Notification($form);
        $notification->send_employee();

        return $this;
	}	

	public function log_new_feed($form)
	{
		$logger = Activity_LoggerFactory::get_logger(new Form_Application_FeedLogger(), $form);
        $logger->log('create');

        return $this;
	}

	public function log_update_feed($form)
	{
        $logger = Activity_LoggerFactory::get_logger(new Form_Application_FeedLogger(), $form);
        $logger->log($form->get_status_verb());

        return $this;
	}
}