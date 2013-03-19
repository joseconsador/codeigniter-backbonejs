<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 *  @author     Jose Mari Consador
 *  @version    1.0.0
 *  @date       2012-11-07
 */

class Options_model extends MY_Model
{
    private $_table_name = 'admin_options';
    private $_primary_key = 'option_id';	
    
    public $sort_by = 'sort_order';
    public $sort_order = 'asc';

    protected $_allowed_filters = array(
        'option_group', 'option_code', 'exclude_ids'
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

	// --------------------------------------------------------------------

    public function get_option_group($group)
    {
    	return $this->get($group, 'option_group');
    }
   
}