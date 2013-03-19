<?php

/**
 * This class represents a thankyou.
 */
class Thankyou extends Base
{   
    protected $_validators = array(
            'user_id' => array('Zend_Validate_NotEmpty', 
                'Zend_Validate_GreaterThan' => array('min' => 0)),
            'message' => array('Zend_Validate_NotEmpty'),
            'recipient_id' => array('Zend_Validate_NotEmpty', 
                'Zend_Validate_GreaterThan' => array('min' => 0)),
    );

    private $_sender = null;

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
        $CI->load->model('thankyou_model', '' ,true);

        return $CI->thankyou_model;
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
    
    public function getData()
    {
        $data = parent::getData();        
        $data['thumbnail_url'] = $this->get_sender()->getThumbnailUrl();
        $data['full_name']     = $this->get_sender()->getFullName();

        return $data;
    }

    static function cansend($user_id, $recipient_id)
    {
        $prev = self::getModel()->get_by_sender_recipient($user_id, $recipient_id);

        if ($prev->num_rows() > 0) {
            $currday = strtotime(date('Y-m-d'));
            if (strtotime(date('Y-m-d', strtotime($prev->row()->created))) == $currday) {
                return FALSE;   
            }
        }

        return TRUE;
    }

    // --------------------------------------------------------------------
    
    public function validates()
    {        
        if (!$this->cansend($this->user_id, $this->recipient_id)) {
            $this->_validation_errors['error'] = 'Can only thank once a day.';
        }

        return parent::validates();
    }
}