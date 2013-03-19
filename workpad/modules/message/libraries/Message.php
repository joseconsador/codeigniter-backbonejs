<?php

/**
 * This class represents a private nessage.
 */
class Message extends Base
{	
    protected $_validators = array(
            'user_id' => array('Zend_Validate_NotEmpty', 
                'Zend_Validate_GreaterThan' => array('min' => 0)),
            'message' => array('Zend_Validate_NotEmpty'),
            'recipient_id' => array('Zend_Validate_NotEmpty', 
                'Zend_Validate_GreaterThan' => array('min' => 0)),
    );

    private $_sender = null;
    private $_recipient = null;

    // --------------------------------------------------------------------

    public function getModel()
    {
        $CI =& get_instance();
        $CI->load->model('message_model', '' ,true);

        return $CI->message_model;
    }

    // --------------------------------------------------------------------
   
    public function get_sender()
    {
        if (is_null($this->_sender)) {
            $this->_sender = new User($this->user_id);
        }

        return $this->_sender;
    }

    // --------------------------------------------------------------------
   
    public function get_recipient()
    {
        if (is_null($this->_recipient)) {
            $this->_recipient = new User($this->recipient_id);
        }

        return $this->_recipient;
    }

    // --------------------------------------------------------------------
    
    public function getData()
    {
        $data = parent::getData();
        $data['thumbnail_url']  = $this->get_sender()->getThumbnailUrl();
        $data['full_name']      = $this->get_sender()->getFullName();
        $data['recipient_name'] = $this->get_recipient()->getFullName();

        return $data;
    }
}