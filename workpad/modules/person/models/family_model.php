<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 *  @author     Jose Mari Consador
 *  @version    1.0.0
 *  @date       2012-11-19
 */

class Family_model extends MY_Model
{
    protected $_table = 'person_family';
    protected $_primary = 'id';

    public $sort_by = 'a.sort_order';
    public $sort_order = 'asc';
    
    public function  _set_join()
    {
        $this->db->select($this->_table . '.*, a.option as relationship_type, b.option as education_type');
        $this->db->join('admin_options a', 'a.option_id = relationship_id', 'left');
        $this->db->join('admin_options b', 'b.option_id = educational_attainment_id', 'left');
    }
}