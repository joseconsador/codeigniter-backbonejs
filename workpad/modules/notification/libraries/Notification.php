<?php

/**
 * This class represents a notification.
 */
class Notification extends Base
{	
    private $_sender = null;

    protected $_validators = array(
            'user_id' => array('Zend_Validate_NotEmpty',
                'Zend_Validate_GreaterThan' => array('min' => 0)
                ),
            'notification' => array('Zend_Validate_NotEmpty'),
            'recipient_id' => array('Zend_Validate_NotEmpty', 
                'Zend_Validate_GreaterThan' => array('min' => 0)
                )            
    );

    protected $_data = array(       
        'url' => '#',
    );
    // --------------------------------------------------------------------

    public function __construct()
    {
        parent::__construct();

        $CI =& get_instance();
        $CI->load->library('Log_template');
        $CI->load->library('User');
    }

    // --------------------------------------------------------------------

    public function getModel()
    {
        $CI =& get_instance();
        $CI->load->model('notification_model', '' ,true);

        return $CI->notification_model;
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
        $user = new User($this->recipient_id);

        return $user->getData();
    }

    // --------------------------------------------------------------------
    
    public function __get($name)
    {
        if ($name == 'notification') {
            return $this->get_notification();
        } else {
            return parent::__get($name);
        }
    }

    // --------------------------------------------------------------------

    public function set_meta($meta)
    {
        $this->data = serialize($meta);

        return $this;
    }

    // --------------------------------------------------------------------

    public function get_meta()
    {        
        return unserialize($this->data);
    }

    // --------------------------------------------------------------------

    public function get_notification()
    {
        return parent::__get('notification');
    }

    // --------------------------------------------------------------------
    
    public function getData()
    {
        $data = parent::getData();
        $data['notification']  = $this->get_notification();
        $data['thumbnail_url'] = $this->get_sender()->getThumbnailUrl();
        $data['full_name']     = $this->get_sender()->getFullName();
        $data['_data']         = $this->get_meta();

        return $data;
    }
}