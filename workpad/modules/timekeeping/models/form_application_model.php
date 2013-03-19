<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/** 
 * 
 *  @author     Jose Mari Consador
 *  @version    1.0.0
 *  @date       2013-01-15
 */

class Form_application_model extends MY_Model
{      
    protected $_allowed_filters = array('employee_id', 'status_id', 'date_from', 'date_to', 'exclude_ids');

    protected $_table = 'time_form_application';
    protected $_primary = 'form_application_id';

    const FORMS_ALL_RESOURCE = 'FORMS_ALL';

    // --------------------------------------------------------------------

    public function _set_join()
    {
        $this->load->model(array('formtype_model', 'options_model'));

        $this->db->select($this->_table . '.*, form as form_type, options.option as status',
            FALSE
        );

        $this->db->join($this->formtype_model->get_table_name(), 'form_id = form_type_id', 'left');
        $this->db->join($this->options_model->get_table_name() . ' options', 'option_id = status_id', 'left');
    }

    // --------------------------------------------------------------------

    public function _prepare_query()
    {
        if (!$this->acl->check_acl(self::FORMS_ALL_RESOURCE)) {
            $ci =& get_instance();
            $this->db->where('employee_id', $ci->get_user()->employee_id);
        }
    }

    // --------------------------------------------------------------------
    
    public function get_employee_leaves($employee_id, $args = array())
    {
        $search = array(
            array(
                'field' => 'employee_id',
                'type'  => 'eq',
                'value' => $employee_id
                )
            );

        if (isset($args['from'])) {
            $search[] = array(
                'field' => 'date_from',
                'type' => 'gte',
                'value' => date('Y-m-d', $args['from'])
                );
        }

        if (isset($args['to'])) {
            $search[] = array(
                'field' => 'date_to',
                'type' => 'lte',
                'value' => date('Y-m-d', $args['to'])
                );
        }

        return parent::fetch($args, FALSE, $search);
    }

    // --------------------------------------------------------------------
}