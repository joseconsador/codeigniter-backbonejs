<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 *  @author     Jose Mari Consador
 *  @version    1.0.0
 *  @date       2012-11-29
 */

class Notification_model extends MY_Model
{
    protected $_table = 'log_notification';
    protected $_primary = 'id';	
    
    protected $_allowed_filters = array('user_id', 'recipient_id');

    public $sort_by = 'created';

    /**
     * Mark all user's messages recieved as read
     * @param  int     $user_id User ID
     * @return boolean TRUE/FALSE on success
     */
    public function mark_all_read($user_id)
    {
        $this->db->where('recipient_id', $user_id);
        return $this->db->update($this->_table, array('log_read' => $user_id));
    }    
}