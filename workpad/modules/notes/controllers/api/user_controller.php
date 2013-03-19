<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class User_controller extends HDI_rest_controller
{
    // --------------------------------------------------------------------

    function note_get()
    {        
        $note = new Note();
        $note->load($this->get('id'), 'user_id');

        $response = $note->getData();

        $response['url'] = site_url('api/note/id/' . $note->getId());

        $this->response($response);
    }

    // --------------------------------------------------------------------

    function note_put()
    {
        $note = new Note();
        $note->load($this->get_user()->user_id, 'user_id');
        $note->note = $this->put('note');

        $this->save($note);
    }

    // --------------------------------------------------------------------

    function note_post()
    {
        $note = new Note();
        $note->load($this->get_user()->user_id, 'user_id');
        $note->note = $this->post('note');

        $this->save($note);
    }    
}