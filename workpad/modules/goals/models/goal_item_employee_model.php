<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/** 
 * 
 *  @author     Jose Mari Consador
 *  @version    1.0.0
 *  @date       2013-02-28
 */

class Goal_item_employee_model extends MY_Model
{
    protected $_table = 'goal_item_employee';
    protected $_primary = 'goal_item_employee_id';

    // --------------------------------------------------------------------    

    public function get_by_goal_item($goal_item_id)
    {
		$search = array(
			array(
				'field' => $this->get_table_name() .'.goal_item_id',
				'type'  => 'eq',
				'value' => $goal_item_id
				)
			);

		return parent::fetch(array(), FALSE, $search);
    }
}