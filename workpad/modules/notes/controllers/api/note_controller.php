<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Note_controller extends HDI_rest_controller
{
    // --------------------------------------------------------------------

    function note_get()
    {
        $note = new Note($this->get('id'));

        $this->response($note->getData());
    }        

    // --------------------------------------------------------------------
    
    function note_post() 
    {
        $note = new Note();
        $note->persist($this->_args);

        $this->save($note);    
    }

    // --------------------------------------------------------------------
    
    function note_put() 
    {
        $note = new Note($this->put('id'));
        $note->persist($this->_args);

        $this->save($note);
    }

    // --------------------------------------------------------------------
    
    function note_delete() 
    {
        $this->response($this->model->delete($this->get('id')));
    }    

    // --------------------------------------------------------------------    
}