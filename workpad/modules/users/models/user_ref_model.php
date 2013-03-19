<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 *  @author     Jose Mari Consador
 *  @version    1.0.0
 *  @date       2012-12-17
 */

class User_ref_model extends MY_Model
{
    protected $_table = 'user_ref';
    protected $_primary = 'id';	

    // --------------------------------------------------------------------

    public function _set_join()
    {
        $this->db->select($this->_table . '.*,                         
            admin_position.position, admin_company.company,admin_department.department, 
            admin_location.location, admin_division.division',
            FALSE
        );
        
        $this->db->join('admin_position', 'admin_position.position_id = user_ref.position_id', 'left');
        $this->db->join('admin_company', 'admin_company.company_id = user_ref.company_id', 'left');
        $this->db->join('admin_department', 'admin_department.department_id = user_ref.department_id', 'left');
        $this->db->join('admin_location', 'admin_location.location_id = user_ref.location_id', 'left');
        $this->db->join('admin_division', 'admin_division.division_id = user_ref.division_id', 'left');
    }    
}