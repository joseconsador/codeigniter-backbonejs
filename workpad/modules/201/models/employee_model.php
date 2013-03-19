<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *  Contains logic for database retrieval/operations and business logic for employees.
 *  Methods like delete_all_employees, search_all, get_XXXX_employees
 * 
 *  @author     Jose Mari Consador
 *  @version    1.0.0
 *  @date       2012-10-05
 */

class Employee_model extends MY_Model
{
    protected $_table = 'employee';
    protected $_primary = 'employee_id';

    protected $_allowed_filters = array(
        'department_id' => 'user_ref', 
        'position_id' => 'user_ref', 
        'company_id' => 'user_ref', 
        'status_id',
        'exclude_ids'
    );
    
    protected $_search_fields = array(
        'CONCAT(first_name," ",last_name)', 
        'department', 
        'position', 
        'company'
    );

    // --------------------------------------------------------------------

    public function _set_join()
    {
        $this->db->select($this->_table . '.*, user.first_name, user.last_name, user.hash, 
            user.user_id, CONCAT(first_name, " ", last_name) full_name,user_ref.person_id, 
            user_ref.position_id, user_ref.company_id, user_ref.division_id,
            user_ref.job_title_id, user_ref.department_id, admin_position.position, b.option as type,
            admin_company.company,admin_department.department, a.option as employment_status',
            FALSE
        );

        $this->db->join('user_ref', 'user_ref.employee_id = '. $this->_table .'.employee_id', 'left');
        $this->db->join('user', 'user_ref.user_id = user.user_id');
        $this->db->join('admin_position', 'admin_position.position_id = user_ref.position_id', 'left');
        $this->db->join('admin_company', 'admin_company.company_id = user_ref.company_id', 'left');
        $this->db->join('admin_department', 'admin_department.department_id = user_ref.department_id', 'left');
        $this->db->join('admin_options a', 'employee.status_id = a.option_id', 'left');        
        $this->db->join('admin_options b', 'admin_position.default_type = b.option_id', 'left');
    }

    // --------------------------------------------------------------------

    public function get_subordinates($user_id, $params = array(), $include_limit = FALSE)
    {
        $search = array(
            array('field' => 'manager_id', 'value' => $user_id)
        );

        if (!isset($params['sort'])) {
            $params['sort'] = 'full_name';
        }

        if (!isset($params['order'])) {
            $params['order'] = 'asc';
        }

        return $this->fetch($params, $include_limit, $search);
    }
}