<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 *  @author     Jose Mari Consador
 *  @version    1.0.0
 *  @date       2013-01-25
 */

class Reward_model extends MY_Model
{
    protected $_table = 'rewards';
    protected $_primary = 'reward_id';

	// --------------------------------------------------------------------

    public function  _set_join()
    {
        $this->db->select($this->_table . '.*, log_uploads.filename, log_uploads.upload as image_path');

        $this->db->join('log_uploads', 
            'image_upload_id = upload_id AND ' . $this->db->dbprefix . 'log_uploads.deleted = 0', 
            'left');        
    }    

    // --------------------------------------------------------------------

    public function do_create($params)
    {
        $ci =& get_instance();
        $params['created_by'] = $ci->get_user()->user_id;

        return parent::do_create($params);
    }

    // --------------------------------------------------------------------

    public function do_update($params)
    {
        $ci =& get_instance();
        $params['modified_by'] = $ci->get_user()->user_id;

        return parent::do_update($params);
    }    
}