<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/** 
 * 
 *  @author     Jose Mari Consador
 *  @version    1.0.0
 *  @date       2012-12-04
 */

class Goal_model extends MY_Model
{
    protected $_table = 'goal';
    protected $_primary = 'goal_id';    

    protected $_allowed_filters = array(
        'employee_id',
        'exclude_ids',
        'created_by',
        'parent_id'
    );

    // --------------------------------------------------------------------    

    public function _set_join()
    {
        $this->db->select('admin_options.option as status, ' . $this->get_table_name() . '.*');
        $this->db->join('admin_options', 'admin_options.option_id = status_id', 'left');        
    }

    // --------------------------------------------------------------------    
    
    public function do_create($params)
    {
        $ci =& get_instance();

        $params['created_by'] = $ci->get_user()->user_id;

        return parent::do_create($params);
    }

    // --------------------------------------------------------------------

    public function get_assigned_goals($employee_id)
    {
        $this->load->model(array('goal_item_model', 'goal_item_employee_model'));

        $query = 'SELECT * '
                    . 'FROM ' . $this->get_table_name() . ' '
                    . 'WHERE '
                    . $this->get_primary_key() . ' IN('
                        . 'SELECT
                               goal_id
                            FROM ' . $this->goal_item_model->get_table_name() . '
                               LEFT JOIN '. $this->goal_item_employee_model->get_table_name() .'
                                 ON '. $this->goal_item_employee_model->get_table_name() . '.goal_item_id' 
                                    . ' = ' . $this->goal_item_model->get_primary_key() .'
                            WHERE '. $this->goal_item_employee_model->get_table_name() . '.employee_id = ' . $employee_id .')';

        return $this->db->query($query);
    }

    // --------------------------------------------------------------------    
    
    public function get_children($goal_id)
    {
        $search = array(
            array(
                'field' => $this->get_table_name() .'.parent_id',
                'type'  => 'eq',
                'value' => $goal_id
                )
            );

        return parent::fetch(array(), FALSE, $search);
    }
}