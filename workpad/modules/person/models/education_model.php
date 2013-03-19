<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 *  @author     Jose Mari Consador
 *  @version    1.0.0
 *  @date       2012-11-16
 */

class Education_model extends MY_Model
{
    protected $_table = 'person_education';
    protected $_primary = 'id';	    	

    public function _set_join()
    {
        $this->db->select($this->_table . '.*, admin_options.option as education_level');
        $this->db->join('admin_options', 'admin_options.option_id = education_level_id', 'left');
        $this->db->order_by('admin_options.sort_order desc');
    }    
}