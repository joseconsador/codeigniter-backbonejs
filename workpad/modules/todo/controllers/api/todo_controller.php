<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Todo_controller extends HDI_rest_controller
{
    // --------------------------------------------------------------------

    function todo_get()
    {
        $todo = new Todo($this->get('id'));

        $this->response($todo->getData());
    }        

    // --------------------------------------------------------------------
    
    function todo_post() 
    {
        $todo = new Todo();
        $todo->persist($this->_args);
        $todo->user_id = $this->get_user()->user_id;
        
        $this->save($todo);
    }

    // --------------------------------------------------------------------
    
    function todo_put() 
    {
        $todo = new Todo($this->get('id'));

        if (isset($this->_args['action']) && method_exists($this, '_' . $this->_args['action'])) {            
            call_user_func( array($this, '_' . $this->_args['action']) , $todo );
        } else {
            // Unset the completed var because we want it to pass through the _toggle_status function
            // so that validation may be applied.
            unset($this->_args['completed']);

            $todo->persist($this->_args);

            $this->save($todo);
        }
    }

    // --------------------------------------------------------------------

    function todo_delete()
    {
        $this->delete(new Todo($this->get('id')));
    }

    // --------------------------------------------------------------------
    
    private function _toggle_status($todo)
    {
        $todo->completed = $this->_args['completed'];

        if ($todo->completed) {
            $todo->date_completed = date('Y-m-d');
        } else {
            $todo->date_completed = null;
        }

        $this->save($todo);
    }
}