<?php

class Calendar_Event_ResponseSource_Form extends Calendar_Event_ResponseSource
{
	
	function format()
	{
		$form = new Form_Application($this->_eventSource);

    	$return['type']         = 'form';
        $return['allday']       = TRUE;
        $return['start']        = strtotime($form->date_from);
        $return['end']          = strtotime($form->date_to);
        $return['color']        = $form->get_color();
        $return['title']        = $form->form_type;
        $return['id']           = $form->getId();
        $return[$form->getModel()->get_primary_key()] = $form->getId();
        $return['form_type_id'] = $form->form_type_id;
        $return['form_type']    = $form->form_type;
        $return['reason']       = $form->reason;
        $return['status']       = $form->get_status_verb_past();
        $return['locked']       = $form->is_locked();
        $return['employee']['hash'] = $form->get_employee()->hash;
        $return['employee']['full_name'] = $form->get_employee()->full_name;
        $return['employee_id'] = $form->employee_id;

        return $return;
	}
}