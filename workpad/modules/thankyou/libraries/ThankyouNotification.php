<?php
$ci =& get_instance();
$ci->load->library('Notification');
/**
 * This class represents a thankyou.
 */
class ThankyouNotification extends Notification
{	
    private $_template_code;
    public $thankyou;
    public $_data = array('user_id', 'recipient_id');

    public function set_thankyou(Thankyou $thankyou)
    {
        $this->thankyou = $thankyou;
        $this->user_id  = $thankyou->user_id;
        $this->recipient_id  = $thankyou->recipient_id;
        $this->message = $thankyou->message;
    }

    public function get_notification()
    {
        $template = new Log_template();
        $template->load('THANK-YOU', 'code');        
        $recipient = $this->thankyou->get_recipient();
        $vals['username'] = $recipient['full_name'];
        $vals['message'] = $this->message;

        return $template->render($vals);
    }
}