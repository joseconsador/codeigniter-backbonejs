<?php

/**
 * This class represents a goal.
 */
class Goal_Item_Employee extends Base
{
    // --------------------------------------------------------------------

    public function save()
    {        
        if ($this->isNew() && $this->validates()) {
            Hdi_EventDispatcher::dispatch_event('goal_item_create', $this);            
        }

        return parent::save();
    }

    // --------------------------------------------------------------------

    public function getModel()
    {
        $CI =& get_instance();
        $CI->load->model('goal_item_employee_model', '' ,true);

        return $CI->goal_item_employee_model;
    }

    // --------------------------------------------------------------------

    public function getEmployee()
    {
    	return new Employee($this->employee_id);
    }

    // --------------------------------------------------------------------

    public function getData()
    {
		$data = parent::getData();
		$data['full_name'] = $this->getEmployee()->full_name;

		return $data;
    }    
}