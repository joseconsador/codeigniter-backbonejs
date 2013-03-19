<?php

class Form_Application_Notification
{
	private $_application;

	public function __construct(Form_Application $application)
	{
		$this->_application = $application;
	}

	public function send_approver()
	{
        $ci =& get_instance();
        $ci->load->library('parser');
        $ci->load->helper('approver');

        $approver = get_approver($this->_application->get_employee(), Form_Application::MODULE);

        $notification = new Notification();
        $notification->recipient_id = $approver->user_id;
        $notification->user_id = $this->_application->get_employee()->user_id;
        $notification->url = 'supervisor/form_applications#/form/' . $this->_application->getId();
        $notification->notification = $ci->parser->parse(
            'template/notification_new_application', 
            array(
                'employee'  => $this->_application->get_employee()->full_name,
                'form_type' => $this->_application->form_type
                )
            , TRUE
        );
        $notification->set_meta(array('id' => $this->_application->getId()));

        return $notification->save();
	}

    public function send_employee()
    {
        $ci =& get_instance();
        $ci->load->library('parser');        
        $ci->load->helper('approver');

        $approver = get_approver($this->_application->get_employee(), Form_Application::MODULE);

        $notification = new Notification();
        $notification->recipient_id = $this->_application->get_employee()->user_id;
        $notification->user_id = $approver->user_id;
        $notification->notification = $ci->parser->parse(
            'template/form_application_status_update', 
            array(
                'approver'  => $approver->full_name,
                'form_type' => $this->_application->form_type,
                'verb'      => $this->_application->get_status_verb_past()
                )
            , TRUE
        );

        $notification->set_meta(array('id' => $this->_application->getId()));

        return $notification->save();
    }    
}