<?php

/**
 * This class represents a goal.
 */
class Goal extends Base
{
    private $_items = array();

    const ALL_RESOURCE = 'GOALS_ALL';
    const SUCCESS_STATUS_ID = 75;

    const DRAFT_STATUS = 71;
    const UPCOMING_STATUS = 72;
    const INPROGRESS_STATUS = 73;
    const PENDING_STATUS = 74;
    const COMPLETED_STATUS = 75;
    const FAILED_STATUS = 76;

    // --------------------------------------------------------------------

    public function getModel()
    {
        $CI =& get_instance();
        $CI->load->model('goal_model', '' ,true);

        return $CI->goal_model;
    }

    // --------------------------------------------------------------------

    public function save()
    {
        if ($this->isNew() && $this->validates()) {
            Hdi_EventDispatcher::dispatch_event('goal_create', $this);            
        }
        
        return parent::save();        
    }

    // --------------------------------------------------------------------
   
    public function get_items()
    {
        if (count($this->_items) == 0) {
            $CI =& get_instance();
            $CI->load->model('goal_item_model');            
            
            $items = $CI->goal_item_model->search('goal_id', $this->goal_id);

            if ($items->num_rows() > 0) {
                foreach ($items->result() as $item) {
                    $this->_items[] = new Goal_Item($item);
                }
            }
        }

        return $this->_items;
    }

    // --------------------------------------------------------------------
   
    public function get_involved()
    {
        $items = $this->get_items();
        $involved = array();

        foreach ($items as $objective) {
            $_i = $objective->get_involved();
            
            foreach ($_i as $_o_i) {
                if (!in_array($_o_i['employee_id'], $involved)) {
                    $involved[$_o_i['employee_id']] = $_o_i;
                }
            }
        }

        return $involved;
    }

    // --------------------------------------------------------------------
    
    public function get_total_points()
    {   
        $points = 0;

        foreach ($this->get_items() as $item) {
            $points += $item->get_total_points();
        }

        return $points;
    }

    // --------------------------------------------------------------------
    
    public function get_current_points()
    {   
        $points = 0;

        foreach ($this->get_items() as $item) {
            $points += $item->get_current_points();
        }

        return $points;
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
                $color = '#D9EDF7';
                break;
            default: 
                $color = '#EEEEEE';
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

    public function has_children()
    {
        return ($this->getModel()->get_children($this->getId())->num_rows() > 0);
    }

    // --------------------------------------------------------------------
   
    public function getData()
    {
        $data = parent::getData();
        
        $data['color'] = $this->get_color();        

        if (count($this->get_items()) > 0) {
            foreach ($this->get_items() as $item) {
                $data['items'][] = $item->getData();
            }
        }

        $data['is_owner'] = $this->is_owner();
        $data['points'] = $this->get_total_points();
        $data['involved'] = $this->get_involved();
        $data['has_children'] = $this->has_children();

        return $data;
    }    

    /**
     * Sets validators
     *
     * Using this method so we can control error messages.
     * 
     */
    public function set_validators()
    {
        $this->_validators = array(
            'title' => array('Zend_Validate_NotEmpty'),
            'target' => array('Zend_Validate_NotEmpty', 'Zend_Validate_Date')
        );
    }    
}