<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/** 
 * 
 *  @author     Jose Mari Consador
 *  @version    1.0.0
 *  @date       2013-01-15
 */

class Formtype_model extends MY_Model
{      
    protected $_search_fields = array(
        'form', 'form_code'     
    );


    protected $_allowed_filters = array('is_leave');    

    protected $_table = 'time_form_type';
    protected $_primary = 'form_id';

    // --------------------------------------------------------------------

    public function _set_join()
    {
        $this->db->select($this->_table . '.*, a.option as civil_status',
            FALSE
        );
        
        $this->db->join('admin_options a', 'a.option_id = civil_status_id', 'left');
    }
    
    // --------------------------------------------------------------------
    
    public function get_allowed_types($employee_id, array $args = array())
    {
    	$employee = new Employee($employee_id);
    	$edata = $employee->getData();
		$position = $employee->getUser()->getPosition()->getData();

        $search = array(
            array(
                'field' => 'gender',
                'type'  => 'in',
                'value' => array(strtolower($edata['gender']), 'all')
                ),
            array(
                'field' => 'civil_status_id',
                'type'  => 'in',
                'value' => array($edata['civil_status_id'], 0)
                ),
            array(
                'field' => 'employment_type_id',
                'type'  => 'in',
                'value' => array($position['default_type'], 0)
                ),            
            array(
                'field' => 'employment_status_id',
                'type'  => 'in',
                'value' => array($edata['status_id'], 0)
                ),   
            array(
                'field' => 'tenure',
                'type'  => 'lte',
                'value' => $edata['tenure']
                ),
            );

        return parent::fetch($args, FALSE, $search);
    }
}