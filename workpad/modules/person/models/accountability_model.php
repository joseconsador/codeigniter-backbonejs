<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 *  @author     Jose Mari Consador
 *  @version    1.0.0
 *  @date       2012-11-19
 */

class Accountability_model extends MY_Model
{
    protected $_table = 'employee_units';
    protected $_primary = 'id';

    public function _set_join()
    {
        $this->db->select($this->_table . '.*, log_uploads.filename, log_uploads.upload');

        $this->db->join('log_uploads', 
        	'upload_id = log_uploads_id AND ' . $this->db->dbprefix . 'log_uploads.deleted = 0', 
        	'left');        
    }    
}