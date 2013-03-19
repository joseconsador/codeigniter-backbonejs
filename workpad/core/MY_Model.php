<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 *  @author     Jose Mari Consador
 *  @version    1.0.0
 *  @date       2011-03-10
 */

class MY_Model extends CI_Model
{
    // The name of the table the model represents.
    protected $_table;
    // The primary key of the table.
    protected $_primary;

    // Format: array('FIELD_NAME' => 'TABLE') .
    protected $_allowed_filters = array();
    // Search fields are evaluated in 'LIKE % %' clauses.
    protected $_search_fields = array();
    // Default limit for queries in search.
    protected $_limit = 10;    
    // Used to override default sort order
    public $sort_by = null;
    public $sort_order = null;
    
    public function __construct()
    {
        parent::__construct();
        // Load the database library, we can either set it here or in autoload.php
        $this->load->database();

        $this->set_table_name($this->_table);
        $this->set_primary_key($this->_primary);        
    }

    // --------------------------------------------------------------------

    // For php4 instantiation.
    function MY_Model()
    {
        self::__construct();
    }

    // --------------------------------------------------------------------

    /**
     * Get table name being used.
     *
     * @return string
     */
    public function get_table_name()
    {
        return $this->db->dbprefix . $this->_table;
    }

    // --------------------------------------------------------------------

    /**
     * Set the table that will be used in most of the queries for the subclassed model.
     *
     * @param string $table_name
     */
    public function set_table_name($table_name)
    {
        $this->_table = $table_name;
    }

    // --------------------------------------------------------------------

    public function get_primary_key($append_table_name = TRUE)
    {
        if ($append_table_name) {
            return $this->get_table_name() . '.' . $this->_primary;
        } else {
            return $this->_primary;
        }
    }

    // --------------------------------------------------------------------

    public function set_primary_key($primary_key)
    {
        $this->_primary = $primary_key;
    }

    // --------------------------------------------------------------------

    /**
    *
    *  Handle saving or creating of new database entries.
    *  @param $params array Data to be stored.
    *  @return int
    */
    function do_save($params)
    {
        $fields = $this->get_fields();

        // Save only fields on database, so we don't have to use unset($params[]) to often.
        $valid_fields = array_intersect($fields, array_keys($params));

        $data = array();

        foreach ($valid_fields as $field) {
            if (!is_array($params[$field])) {
                $data[$field] = $params[$field];            
            }
        }

        if (in_array('modified', $fields)) {
            $data['modified'] = date('Y-m-d H:i:s', time());
        }        

        if (isset($data[$this->_primary]) && $this->get($data[$this->_primary]) != FALSE)
        {            
            return $this->do_update($data);
        }
        else
        {
            return $this->do_create($data);
        }
    }

    // --------------------------------------------------------------------

    /**
     * Adds a new record.
     *
     * @param array $params
     * @return mixed
     */
    function do_create($params)
    {
        if ($this->db->field_exists('created', $this->get_table_name())) {
            $params['created'] = date('Y-m-d H:i:s', time());
        }

        // $this->db->insert() creates a new record.
        if ($this->db->insert($this->get_table_name(), $params))
        {
            // Return the last inserted ID.
            return $this->db->insert_id();
        }
        else
        {
            return FALSE;
        }
    }

    function get_fields()
    {
        return $this->db->list_fields($this->_table);
    }

    // --------------------------------------------------------------------

    /**
     * Updates an existing record.
     *
     * @param array $params
     * @return int
     */
    function do_update($params)
    {
        $fields = $this->get_fields();
        $data = array();

        if ($this->db->field_exists('modified', $this->get_table_name())) {
            $data['modified'] = date('Y-m-d H:i:s', time());
        }

        // Build the query based on the primary key value.
        foreach ($params as $key => $column) {
            if (in_array($key, $fields) && $key != $this->_primary) {
                $data[$key] = $column;
            }
        }

        $this->db->where($this->_primary, $params[$this->_primary]);
        $this->db->update($this->get_table_name(), $data);

        return $params[$this->_primary];
    }

    // --------------------------------------------------------------------

    /**
     * Update multiple rows.
     *
     * @param <type> $ids
     * @param <type> $params
     * @return <type>
     */
    function bulk_update($ids, $params)
    {
        if (!is_array($ids))
        {
            $ids = array($ids);
        }

        $this->db->where_in($this->_primary, $ids);

        return $this->db->update($this->get_table_name(), $params);
    }

    // --------------------------------------------------------------------

    /**
    *
    *  Fetch a table row by primary key.
    *  @param $key mixed Value of index.
    *  @param $field string OPTIONAL
    *
    *  @return mixed
    */
    function get($key, $field = '')
    {
        if ($this->db->field_exists('deleted', $this->get_table_name())) {
            $this->db->where($this->get_table_name() . '.deleted', 0);
        }

        $this->_set_join();

        if (!is_array($key))
        {
            $key = array ($key);
        }
        
        if ($field == '') {
            $field = $this->get_primary_key();
        } else {
            $field = $this->get_table_name() . '.' . $field;
        }

        $this->db->where_in($field, $key);

        $obj = $this->db->get($this->get_table_name());

        if ($obj->num_rows > 0)
        {
            if ($obj->num_rows >= 1)
            {   // row() returns an object which holds data from a single row.
                return $obj->row();
            }
        } 
        else
        {
            return FALSE;
        }
    }

    // --------------------------------------------------------------------

    /**
    *
    *  Fetch all rows.
    *  @return obj
    */
    function fetch_all($limit = null, $offset = null, $sort = null, $order = 'desc')
    {
        if ($this->db->field_exists('deleted', $this->get_table_name())) {
            $this->db->where($this->get_table_name() . '.deleted', 0);
        }

        $this->_prepare_query();
        $this->_set_join();

        $default_sort = (is_null($this->sort_by) ? $this->_primary : $this->sort_by);
        $order = (is_null($this->sort_order) ? $order : $this->sort_order);

        if (is_null($sort)) {
            $this->db->order_by($default_sort . ' ' . $order);
        } else {
            $this->db->order_by($sort . ' ' . $order);
        }

        return $this->db->get($this->get_table_name(), $limit, $offset);
    }

    // --------------------------------------------------------------------

    /**
    *
    *  Return count of query. Use this function to return count in pagination.    
    *    
    *  @return int
    */
    public function count_results($params = array())
    {
        return $this->search($this->_build_search($params))->num_rows();
    }

    public function fetch($params = null, $include_limit = FALSE, $search = array())
    {
        $limit  = NULL;
        $offset = NULL;        

        $sort  = (isset($params['sort']) && $params['sort'] != '') 
                    ? $params['sort'] : null;
        $order = (isset($params['order']) && $params['order'] != '')
                    ? $params['order'] : 'desc';

        if ($include_limit && _p($params, 'offset') != '') {
            $offset = $params['offset'];
        }
        
        if ($include_limit && _p($params, 'limit') != '') {            
            $limit = $params['limit'];
        }

        if (_p($params, 'all') == true) {
            $limit = NULL;
            $offset = NULL;
        }
        
        $search = array_merge($search, $this->_build_search($params));

        return $this->search($search, null, $limit, $offset, $sort, $order);
    }

    private function _build_search($params = array())
    {
        $search = array();

        if (array_key_exists('exclude_ids', $params)) {
            $search[] = array(
                'type'  => 'nin', 
                'field' => $this->get_primary_key(), 
                'value' => $params['exclude_ids']
            );
            
            unset($params['exclude_ids']);
        }

        foreach ($this->_allowed_filters as $key => $f) {            
            if (!array_key_exists($key, $params)) {
                // Check if same table.
                if (array_key_exists($f, $params)) {
                    $key = $f;
                    $f = $this->get_table_name();
                }
            }

            if (array_key_exists($key, $params) && $params[$key] != '') {
                $search[] = array('type' => 'eq', 'field' => $f . '.'. $key, 'value' => $params[$key]);
            }
        }

        if (isset($params['searchVal']) && $params['searchVal'] != 'null' && count($this->_search_fields) > 0) {
            foreach ($this->_search_fields as $f) {
                $like[] = $f.'  LIKE "%'.$params['searchVal'].'%"';
            }

            $search[] = array('field' => '', 'type'=> 'custom', 'value' => '(' . implode(' OR ', $like) . ')');
        }

        return $search;        
    }

    // --------------------------------------------------------------------

    /**
     * Search function.
     *
     * @param mixed $key The field name/s.
     * @param mixed $value Value
     * @param int $limit
     * @param int $offset
     */
    public function search($key, $value = null, $limit = null, $offset = null, $sort = null, $order ='desc')
    {
        if ($key == '') {
            return $this->fetch_all($limit, $offset, $sort, $order);
        }

        if (!is_array($key))
        {
            $key = array ($key);
        }

        $type = 'eq';

        foreach ($key as $field)
        {
            if (is_array($field)) {                
                if (isset($field['type']) && $field['type'] != '') {
                    $type = $field['type'];
                }

                if (isset($field['value'])) {
                    $value = $field['value'];
                }

                $field = $field['field'];
            }

            switch ($type) {
                case 'eq':
                    $this->db->where($field, $value);
                    break;
                case 'ne':
                    $this->db->where($field . ' !=', $value);
                    break;
                case 'bw':
                    $this->db->like($field, $value, 'before');
                    break;
                case 'ew':
                    $this->db->like($field, $value, 'after');
                    break;
                case 'bn':
                    $this->db->not_like($field, $value, 'before');
                    break;
                case 'en':
                    $this->db->not_like($field, $value, 'after');
                    break;
                case 'cn':
                    $this->db->like($field, $value);
                    break;
                case 'ocn':
                    $this->db->or_like($field, $value);
                    break;                    
                case 'nc':
                    $this->db->not_like($field, $value);
                    break; 
                case 'gt': 
                    $this->db->where($field . ' >', $value);              
                    break;
                case 'lt': 
                    $this->db->where($field . ' <', $value);
                    break;
                case 'gte': 
                    $this->db->where($field . ' >=', $value);              
                    break;
                case 'lte': 
                    $this->db->where($field . ' <=', $value);              
                    break;                    
                case 'in': 
                    $this->db->where_in($field, $value);              
                    break;
                case 'nin': 
                    $this->db->where_not_in($field, $value);              
                    break;
                case 'custom':                    
                    $this->db->where($value, null, FALSE);           
                    break;
            }            
        }
        
        return $this->fetch_all($limit, $offset, $sort, $order);
    }

    function get_dropdown_array($field)
    {
        $records = $this->fetch_all();

        $values = array(''  => 'Select&hellip;');
        
        foreach ($records->result_array() as $record) {
            $values[$record[$this->get_primary_key()]] =  $record[$field];
        }
        
        return $values;    
    }

    // --------------------------------------------------------------------

    /**
     * Fulltext Search function. You MUST have an index specified and engine set to MyISAM.
     *
     * @param array $index The index name/s.
     * @param mixed $value Value
     * @param int $limit
     * @param int $offset
     * 
     * @return object
     */
    function fulltext_search($index, $key_value, $limit = null, $offset = null)
    {
        foreach ($index as $key => $value)
        {
            $this->db->or_where('MATCH (' . $value . ') AGAINST ("' . $key_value . '") > ', 0, FALSE);
        }

        return $this->db->get($this->get_table_name(), $limit, $offset);
    }

    // --------------------------------------------------------------------

    /**
     *
     * Delete single or multiple records.
     * @param mixed $value Array of key values for multiple and int for single.
     * @return boolean
     */
    function delete($value, $key = null)
    {
        if ($this->db->field_exists('deleted', $this->get_table_name())) {
            return $this->do_update(array($this->_primary => $value, 'deleted' => 1));
        }

        if (!is_array($value))
        {
            $value = array($value);
        }

        if (is_null($key)) {
            $key = $this->_primary;
        }

        $this->db->where_in($this->get_table_name() . '.' . $key, $value);

        return $this->db->delete($this->get_table_name());
    }
    
    // --------------------------------------------------------------------
    
    /**
     * Get previous record.
     * 
     * @param int $id Primary
     *
     * @return mixed FALSE if no record found.
     */        
    function get_previous($id)
    {
        $this->db->where($this->_primary . ' <', $id);
        $this->db->order_by($this->_primary, 'ASC');
        
        $id = $this->db->get($this->get_table_name());
        
        if ($id->num_rows() > 0)
        {
            return $id->row();
        }
        else
        {
            return FALSE;
        }
    }

    // --------------------------------------------------------------------
    
    /**
     * Get next record.
     * 
     * @param int $id Primary
     *
     * @return mixed FALSE if no record found.
     */
    function get_next($id)
    {
        $this->db->where($this->_primary . ' >', $id);
        $this->db->order_by($this->_primary, 'DESC');
        
        $id = $this->db->get($this->get_table_name());
        
        if ($id->num_rows() > 0)
        {
            return $id->row();
        }
        else
        {
            return FALSE;
        }    
    }    
    
    // --------------------------------------------------------------------
    
    /**
     * Insert multiple records at once.
     *
     * @param $data Array or Object.
     *
     * @return mixed.
     */
    function insert_batch($data = null)
    {
        // Check if the parameters have been set correctly.
        if (is_null($data) || (!is_object($data) && !is_array($data)))
        {
            return FALSE;
        }

        if ($this->db->insert_batch($this->get_table_name(), $data))
        {
            // Return the last inserted ID.
            return $this->db->insert_id();
        }
        else
        {
            return FALSE;
        }        
    }

    // --------------------------------------------------------------------       

    /**
     * Get last modified item in table.
     * 
     * @return date/NULL
     */
    function get_last_modified_date()
    {
        if ($this->db->field_exists('modified', $this->get_table_name())) {
            $this->db->select('modified');
            $this->db->order_by('modified', 'desc');
            $this->db->limit(1);

            $result = $this->db->get($this->get_table_name());

            if ($result->num_rows() > 0) {
                return strtotime($result->row()->modified);
            }
        }
        
        return null;
    }

    // --------------------------------------------------------------------       
    
    /**
     * Method to prepare joins, can be overriden by extending classes.
     */
    protected function _set_join() {}

    // --------------------------------------------------------------------       
    
    /**
     * Called on MY_Model::fetch_all() to contain any additional business rules.
     */
    protected function _prepare_query() {}
}

/* End of file MY_Model.php */
/* Location: ./application/core/MY_Model.php */