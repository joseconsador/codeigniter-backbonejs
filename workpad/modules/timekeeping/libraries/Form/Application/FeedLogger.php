<?php

class Form_Application_FeedLogger extends Activity_Logger
{
	public function log($action)
	{
        $log['user_id'] = $this->get_source()->get_employee()->user_id;
        $log['action']  = $action;
        $log['resource_type'] = 'form_application';        

        $modified = new User($this->get_source()->modified_by);

        $log['data'] = serialize(
            array(
                'full_name' => $this->get_source()->get_employee()->full_name,
                'id' => $this->get_source()->getId(),
                'employee_id' => $this->get_source()->employee_id,                
                'form_type' => $this->get_source()->form_type,
                'date_from' => $this->get_source()->date_from,
                'date_to' => $this->get_source()->date_to,
                'modified_by_id' => $this->get_source()->modified_by,
                'modified_by_name' => $modified->full_name,
            )
        );

        return $this->get_logger()->loadArray($log)->save();
	}
}