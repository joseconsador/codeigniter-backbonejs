<?php

/**
 * This class represents a time record entry.
 */
class Timerecord extends Base
{
    private $_minutes_late = 0;
    private $_employee = null;
    private $_shift = null;

    // --------------------------------------------------------------------

    public function getModel()
    {
        $CI =& get_instance();
        $CI->load->model('timerecord_model', '' , TRUE);

        return $CI->timerecord_model;
    }

    // --------------------------------------------------------------------

    public function get_applied_forms($require_approved = TRUE)
    {

    }

    // --------------------------------------------------------------------

    public function get_applied_leaves($require_approved = TRUE)
    {

    }    

    // --------------------------------------------------------------------

    public function get_employee()
    {
        $this->_employee = new Employee($this->employee_id);

        return $this->_employee;
    }

    // --------------------------------------------------------------------

    /**
    *  Return the shift for this day.
    */
    public function get_shift() 
    {
        $this->_shift = new Shift($this->get_employee()->schedule_id);

        return $this->_shift;
    }

    // --------------------------------------------------------------------

    public function is_late() 
    {

    }

    // --------------------------------------------------------------------

    public function get_minutes_late()
    {
        $shift = $this->get_shift();

        $this->_minutes_late = (strtotime($this->get_time_in()) - strtotime($shift->get_shift_start())) / 60;        
    }

    // --------------------------------------------------------------------

    public function get_time_in()
    {

    }

    // --------------------------------------------------------------------

    public function get_time_out()
    {

    }

    // --------------------------------------------------------------------

    public function is_undertime() {}

    // --------------------------------------------------------------------

    public function is_absent() {}    

    // --------------------------------------------------------------------

    public function has_late_infraction() {}    

    // --------------------------------------------------------------------

    public function has_absent_infraction() {}        

    // --------------------------------------------------------------------

    public function has_undertime_infraction() {}
}