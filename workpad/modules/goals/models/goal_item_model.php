<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/** 
 * 
 *  @author     Jose Mari Consador
 *  @version    1.0.0
 *  @date       2012-12-04
 */

class Goal_item_model extends MY_Model
{
    protected $_table = 'goal_item';
    protected $_primary = 'goal_item_id';    

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
}