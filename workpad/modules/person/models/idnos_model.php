<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 *  @author     Jose Mari Consador
 *  @version    1.0.0
 *  @date       2012-11-118
 */

class Idnos_model extends MY_Model
{
    protected $_table = 'person_idnos';
    protected $_primary = 'id';	

    public $sort_by = 'sort_order';

    public function  _set_join()
    {
        $this->db->select($this->_table . '.*, a.option as id_type');
        $this->db->join('admin_options a', 'a.option_id = idnos_id', 'left');        
    }
}