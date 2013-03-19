<?php

/**
 * This class represents a todo item.
 */
class Todo extends Base
{
    // --------------------------------------------------------------------

    public function getModel()
    {
        $CI =& get_instance();
        $CI->load->model('todo_model', '' ,true);

        return $CI->todo_model;
    }

    // --------------------------------------------------------------------
    
    public function set_validators()    
    {              
        $this->_validators['description'] = array(new Zend_Validate_NotEmpty());
    }
}