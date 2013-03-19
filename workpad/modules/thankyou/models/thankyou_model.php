<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 *  @author     Jose Mari Consador
 *  @version    1.0.0
 *  @date       2012-11-29
 */

class Thankyou_model extends MY_Model
{
    protected $_table = 'log_thanks';
    protected $_primary = 'id';

    protected $_allowed_filters = array(      
        'recipient_id', 'user_id'
    );

    /**
     * Get a thank you by sender and recipient combination
     * called in Thankyou::validates()
     * 
     * @param  int $sender_id    
     * @param  int $recipient_id 
     * @return DB object
     */
    public function get_by_sender_recipient($sender_id, $recipient_id)
    {
    	$params['recipient_id'] = $recipient_id;
    	$params['user_id'] = $sender_id;

    	return $this->fetch($params);
    }
}