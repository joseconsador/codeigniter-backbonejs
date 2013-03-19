<?php

/**
 * This class represents a goal.
 */
class Goal_Item extends Base
{
    protected $_validators = array(
            'title' => array('Zend_Validate_NotEmpty'),
            'target_date' => array('Zend_Validate_NotEmpty', 'Zend_Validate_Date'),
            'goal_id' => array('Zend_Validate_NotEmpty'),
            'description' => array('Zend_Validate_NotEmpty'),
            'points' => array('Zend_Validate_NotEmpty')            
    );

    private $_employee = null;
    private $_goal = null;
    private $_involved = array();

    const DRAFT_STATUS = 71;
    const UPCOMING_STATUS = 72;
    const INPROGRESS_STATUS = 73;
    const PENDING_STATUS = 74;
    const COMPLETED_STATUS = 75;
    const FAILED_STATUS = 76;    

    protected $_data = array(       
        'status_id'     => self::PENDING_STATUS,
    );

    // --------------------------------------------------------------------

    public function getModel()
    {
        $CI =& get_instance();
        $CI->load->model('goal_item_model', '' ,true);

        return $CI->goal_item_model;
    }

    // --------------------------------------------------------------------

    public function save()
    {
        if ($this->isNew() && $this->validates()) {            
            Hdi_EventDispatcher::dispatch_event('goal_item_create', $this);            
        }            

        if ($id = parent::save()) {
            foreach ($this->_involved as $involved) {
                $i = new Goal_Item_Employee($involved);

                $i->goal_item_id = $id;
                $i->save();
            }

            $cache = Cache::get_instance();
            $cache->delete('_oGoal' . $this->goal_id);
        }

        return $id;
    }

    // --------------------------------------------------------------------    

    /**
     * Add a user to the event
     * @param int $involved User ID
     */         
    public function add_involved($involved)
    {
        $this->_involved[] = $involved;
    }    

    // --------------------------------------------------------------------

    public function get_goal()
    {
        if ($this->_goal == null) {
            $this->_goal = new Goal($this->goal_id);
        }

        return $this->_goal;
    }

    // --------------------------------------------------------------------
    
    public function get_total_points()
    {
        return $this->points;
    }

    // --------------------------------------------------------------------
    
    public function get_current_points()
    {
        return $this->points_earned;
    }

    // --------------------------------------------------------------------    

    public function get_involved()
    {        
        $ci =& get_instance();

        $ci->load->model('goal_item_employee_model');

        $involved = $ci->goal_item_employee_model->get_by_goal_item($this->getId());

        if ($involved->num_rows() > 0) {
            foreach ($involved->result() as $i) {
                $_g = new Goal_Item_Employee($i);
                $this->_involved[] = $_g->getData();
            }
        }

        return $this->_involved;
    }

    // --------------------------------------------------------------------    

    public function get_employee()
    {
        if ($this->_employee == null) {            
            $CI =& get_instance();
            $CI->load->library('Employee');

            $this->_employee = new Employee($this->employee_id);
        }
        
        return $this->_employee;
    }

    // --------------------------------------------------------------------        

    public function get_color() 
    {
        switch ($this->status_id) {
            case self::DRAFT_STATUS : 
                $color = '#EEEEEE';
                break;
            case self::FAILED_STATUS :
                $color = '#F2DEDE';
                break;
            case self::INPROGRESS_STATUS :
                $color = '#DFF0D8';
                break;
            case self::COMPLETED_STATUS :
                $color = '#468847';
                break;
            default: 
                $color = 'gray';
        }

        return $color;
    }

    // --------------------------------------------------------------------        

    public function is_owner()
    {
        $ci =& get_instance();
        return ($this->created_by == $ci->get_user()->user_id);
    }

    // --------------------------------------------------------------------        
    
    public function getData()
    {
        $data = parent::getData();
        $data['color'] = $this->get_color();
        $data['involved'] = $this->get_involved();
        $data['is_owner'] = $this->is_owner();
        
        return $data;
    }
}