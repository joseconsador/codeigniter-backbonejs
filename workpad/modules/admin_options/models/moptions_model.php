<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 *  @author     Jomel P. Dicen
 *  @version    1.0.0
 *  @date       2012-11-16
 */

class Moptions_model extends MY_Model
{
    private $_table_name = 'admin_options';
    private $_primary_key = 'option_id';    

    protected $_allowed_filters = array(
        'option_group', 'option_code'
    );
    
    protected $_search_fields = array(
        'option', 'option_code', 'option_group'
    );


    // --------------------------------------------------------------------

    public function __construct()
    {
        parent::__construct();

        // Set the values for MY_Model::_table and MY_Model::_primary .
        $this->set_table_name($this->_table_name);
        $this->set_primary_key($this->_primary_key);
    }

     /**
    *
    *  Fetch all rows.
    *  @return obj
    */
    function fetch_all($limit = null, $offset = null, $sort = null, $order = 'desc')
    {
        $this->_set_join();

        if (is_null($sort)) {
            $this->db->order_by($this->_primary_key . ' ' . $order);
        } else {
            $this->db->order_by($sort . ' ' . $order);
        }        

        $group = array('EMPLOYMENT-STATUS', 'EMPLOYMENT-TYPE', 'EXAM-TYPE', 'PROFICIENCY', 'SKILL-TYPE', 'EDUCATION', 'RELATIONSHIP', 'RELIGION');
        $this->db->where_in('option_group', $group);
        $this->db->group_by('option_group');
        $data = $this->db->get($this->_table_name, $limit, $offset);
        return $data;
    }

}