<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 *  @author     Jose Mari Consador
 *  @version    1.0.0
 *  @date       2012-11-13
 */

class Message_model extends MY_Model
{
    protected $_table = 'log_message';
    protected $_primary = 'id';	
    
    protected $_allowed_filters = array('user_id', 'recipient_id');

    public $sort_by = 'created';

    // --------------------------------------------------------------------

    /**
     * [fetch_by_user description]
     * @param  [type] $user_id [description]
     * @param  array  $args    [description]
     * @param  [type] $type    [description]
     * @return [type]          [description]
     */
    public function fetch_by_user($user_id, $args = array()) 
    {        
        $this->db->or_where('user_id', $user_id);
        $this->db->or_where('recipient_id', $user_id);

        return parent::fetch($args, TRUE);
    }

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