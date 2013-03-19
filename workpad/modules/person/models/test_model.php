<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 *  @author     Jose Mari Consador
 *  @version    1.0.0
 *  @date       2012-11-15
 */

class Test_model extends MY_Model
{
    protected $_table = 'person_test_profile';
    protected $_primary = 'id';	
    
	// --------------------------------------------------------------------

    public function  _set_join()
    {
        $this->db->select($this->_table . '.*, a.option as exam_type, 
            b.option as result, log_uploads.filename, log_uploads.upload');
        $this->db->join('admin_options a', 'a.option_id = exam_type_id', 'left');
        $this->db->join('admin_options b', 'b.option_id = result_type_id', 'left');

        $this->db->join('log_uploads', 
            'upload_id = log_uploads_id AND ' . $this->db->dbprefix . 'log_uploads.deleted = 0', 
            'left');        
    }   
}