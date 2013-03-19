<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 *  @author     Jose Mari Consador
 *  @version    1.0.0
 *  @date       2012-11-16
 */

class Detail_model extends MY_Model
{
    protected $_table = 'person_details';
    protected $_primary = 'id';	   

    public function _set_join()
    {
        $this->db->select($this->_table . '.*, admin_options.option as civil_status',
            FALSE
        );
        
        $this->db->join('admin_options', 'admin_options.option_id = person_details.civil_status_id', 'left');
    }
}