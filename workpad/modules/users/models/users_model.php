<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 *  @author     Jose Mari Consador
 *  @version    1.0.0
 *  @date       2012-10-05
 */

class Users_model extends MY_Model
{
    protected $_table = 'user';
    protected $_primary = 'user_id';	

    protected $_allowed_filters = array(
        'department_id' => 'user_ref', 
        'position_id' => 'user_ref', 
        'company_id' => 'user_ref', 
        'exclude_ids'
    );
    
    protected $_search_fields = array(
        'CONCAT(hr_user.first_name," ",hr_user.last_name)', 
        'department', 
        'position', 
        'company'
    );

    public function _set_join()
    {
        $this->db->select($this->_table . '.*, 
            CONCAT(' . $this->get_table_name() . '.first_name, " ", ' . $this->get_table_name() . '.last_name) 
            full_name, user_ref.id as ref_id, user_ref.position_id, user_ref.company_id, 
            person_details.person_id, person_details.gender, person_details.birth_date,
            person_details.birth_place, person_details.civil_status_id, person_details.spouse_name,
            person_details.spouse_work, person_details.marriage_date, person_details.children, 
            person_details.nationality, person_details.height, person_details.weight, person_details.blood_type,
            user_ref.employee_id, user_ref.division_id, user_ref.job_title_id, 
            user_ref.department_id, admin_position.position, person.maiden_name,
            admin_company.company,admin_department.department, admin_location.location, 
            admin_division.division, user_ref.role_id,user_ref.person_id person_id',
            FALSE
        );

        $this->db->join('user_ref', 'user_ref.user_id = user.user_id', 'left');        
        $this->db->join('person', 'user_ref.person_id = person.person_id', 'left');
        $this->db->join('person_details', 'person.person_id = person_details.person_id', 'left');
        $this->db->join('admin_position', 'admin_position.position_id = user_ref.position_id', 'left');
        $this->db->join('admin_company', 'admin_company.company_id = user_ref.company_id', 'left');
        $this->db->join('admin_department', 'admin_department.department_id = user_ref.department_id', 'left');
        $this->db->join('admin_location', 'admin_location.location_id = user_ref.location_id', 'left');
        $this->db->join('admin_division', 'admin_division.division_id = user_ref.division_id', 'left');
    }

    // --------------------------------------------------------------------

    /**
    *
    *  Handle saving or creating of new database entries.
    *  @param $params array Data to be stored.
    *  @return int
    */
    function do_create($params)
    {
        if (!isset($params['login'])) {
            $params['login'] = $params['first_name'] . $params['last_name'];            
        }

        $params['password'] = md5($params['password']);

        $id = parent::do_create($params);

        if ($id) { 
            // Save person
            $person_model = new DummyModel('person', 'person_id');
            $params['person_id'] = $person_model->do_save($params);

            // Save person detail
            $persondetail_model = new DummyModel('person_details', 'id');
            $persondetail_model->do_save($params);

            // now we have person_id
            $ref_model = new DummyModel('user_ref', 'id');
            $params['user_id'] = $id;            
            $ref_model->do_save($params);

            return $id;
        }

        return FALSE;
    }    

    // --------------------------------------------------------------------

    public function do_update($params)
    {
        if (isset($params['password']))
        {
            $params['password'] = md5($params['password']);
        }

        return parent::do_update($params);
    }

    // --------------------------------------------------------------------
    
    /**
     * Get user by employee ID.
     * 
     * @param  int $employee_id [Employee ID]
     * @return mixed FALSE if none, User object
     */
    public function get_by_employee_id($employee_id)
    {
        $this->db->where('employee_id', $employee_id);
        $ref = $this->db->get('user_ref');

        if ($ref->num_rows() == 0) {
            return FALSE;
        } else {
            $this->load->library('user');
            
            return new User($ref->row()->user_id);
        }
    } 

    // --------------------------------------------------------------------
    
    /**
     * Get user by person ID.
     * 
     * @param  int $person_id [Person ID]
     * @return mixed FALSE if none, User object
     */
    public function get_by_person_id($person_id)
    {
        $this->db->where('person_id', $person_id);
        $ref = $this->db->get('user_ref');

        if ($ref->num_rows() == 0) {
            return FALSE;
        } else {
            $this->load->library('user');

            return new User($ref->row()->user_id);
        }
    } 


    // --------------------------------------------------------------------
    
    /**
     * Get array of username and passwords.
     *      
     * @return array
     */    
    public function get_login_array()
    {
        $this->db->select('login,password');
        $results = $this->db->get('user');
        $logins = array();
        if ($results->num_rows() > 0) {
            foreach ($results->result() as $user) {
                $logins[$user->login] = $user->password;
            }
        }

        return $logins;
    }

    // --------------------------------------------------------------------
    
    /**
     * Get by username and password.
     *      
     * @return array
     */    
    public function get_by_login($login, $password)
    {
        $this->db->where('login', $login);
        $this->db->where('password', $password);
        $user = $this->db->get('user');

        if ($user->num_rows() > 0) {
            $this->load->library('user');
            $u = new User($user->row()->user_id);            
            return $u->getData();
        }

        return FALSE;
    }
    
}