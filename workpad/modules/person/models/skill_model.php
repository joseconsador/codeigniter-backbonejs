<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 *  @author     Jose Mari Consador
 *  @version    1.0.0
 *  @date       2012-11-13
 */

class Skill_model extends MY_Model
{
    protected $_table = 'person_skill';
    protected $_primary = 'id';	
    
	// --------------------------------------------------------------------

    public function  _set_join()
    {
        $this->db->select($this->_table . '.*, a.option as skill_type, b.option as proficiency');
        $this->db->join('admin_options a', 'a.option_id = skill_type_id', 'left');
        $this->db->join('admin_options b', 'b.option_id = proficiency_id', 'left');
    }   
}