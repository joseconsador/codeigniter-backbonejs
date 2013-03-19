<?php

/**
 * This class represents a user defined calendar event.
 */
class Calendar_Event extends Base
{
    private $_involved = array();
    private $_remove_involved = array();
    private $_user = null;

    // --------------------------------------------------------------------

    public function getModel()
    {
        $CI =& get_instance();
        $CI->load->model('event_model', '' ,true);

        return $CI->event_model;
    }

    public function save()
    {
        $id = parent::save();
        
        if ($id) {
            foreach ($this->_involved as $involved) {
                $i = new Calendar_Event_Participant($involved);
                $i->event_id = $id;
                $i->save();
            }
        }

        return $id;
    }    

    // --------------------------------------------------------------------    

    /**
     * Add a user to the event
     * @param int $involved User ID
     */         
    public function add_involved($involved)
    {
        $this->_involved[] = $involved;
    }

    // --------------------------------------------------------------------    

    public function remove_involved($id)
    {
        $this->_remove_involved[] = $id;
    }

    // --------------------------------------------------------------------    

    public function get_involved()
    {
        $ci =& get_instance();

        $ci->load->model('event_participant_model');

        $involved = $ci->event_participant_model->get_by_event_id($this->getId());

        return $involved->result();
    }
	
    // --------------------------------------------------------------------

    public function set_validators()
    {
        $this->_validators['title'] = array(new Zend_Validate_NotEmpty());

        $time_validator = new Zend_Validate_GreaterThan(array('min' => date('Y-m-d', strtotime('-1 day', strtotime($this->date_from)))));
        $time_validator->setMessage('Start date cannot be greater than end date.');

        $this->_validators['date_from'] = array(new Zend_Validate_NotEmpty());
        $this->_validators['date_to'] = array(
            new Zend_Validate_NotEmpty(), 
        	$time_validator    
        );
    }


    // --------------------------------------------------------------------

    public function get_user()
    {
        if (is_null($this->_user)) {
            $this->_user = new User($this->user_id);
        }

        return $this->_user;
    }

    // --------------------------------------------------------------------
    
    public function getData()
    {
        $data = parent::getData();
        $data['involved'] = $this->get_involved();

        return $data;
    }    
}