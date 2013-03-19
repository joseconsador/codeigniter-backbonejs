<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/** 
 * 
 *  @author     Jose Mari Consador
 *  @version    1.0.0
 *  @date       2012-11-25
 */

class Timerecord_model extends MY_Model
{
    protected $_table = 'time_logs';
    protected $_primary = 'log_id';
    protected $_allowed_filters = array('employee_id', 'manual', 'device_id', 'date', 'awol');

    // --------------------------------------------------------------------
    
    /**
     * Return logs by either specifying a range in the $args array
     * @param  array  $args Parameters to be used in the query
     * @param  string $from Date from. OPTIONAL
     * @param  string $to   Date to. OPTIONAL
     * @return stdClass mysql query result
     */
    public function get_logs_from_range($args = array(), $from = null, $to = null)
    {
        if (!is_null($from)) {
            $this->db->where('date >=', date('Y-m-d', $from));
        } elseif (isset($args['from'])) {
            $this->db->where('date >=', date('Y-m-d', $args['from']));
        }

        if (!is_null($to)) {
            $this->db->where('date <=', date('Y-m-d', $to));
        } elseif (isset($args['to'])) {
            $this->db->where('date <=', date('Y-m-d', $args['to']));
        }

        return $this->fetch($args);
    }
}