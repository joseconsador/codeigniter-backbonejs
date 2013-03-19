<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 *  @author     Jose Mari Consador
 *  @version    1.0.0
 *  @date       2012-11-18
 */

class Address_model extends MY_Model
{
    protected $_table = 'person_address';
    protected $_primary = 'id';

    public $sort_by = 'sort_order';
    public $sort_order = 'asc';
    
    public function  _set_join()
    {
        $this->db->select($this->_table . '.*, a.option as address_type');
        $this->db->join('admin_options a', 'a.option_id = address_type_id', 'left');
    }
}