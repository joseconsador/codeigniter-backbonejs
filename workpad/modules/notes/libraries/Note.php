<?php

/**
 * This class represents a private nessage.
 */
class Note extends Base
{	    
	protected $_data = array(		
		'note' => ''
	);

    // --------------------------------------------------------------------

    public function getModel()
    {
        $CI =& get_instance();
        $CI->load->model('note_model', '' ,true);

        return $CI->note_model;
    }
}