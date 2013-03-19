<?php

/**
 * This class represents a shift.
 */
class Shift extends Base
{	
    // --------------------------------------------------------------------

    public function getModel()
    {
        $CI =& get_instance();
        $CI->load->model('shift_model', '' ,true);

        return $CI->shift_model;
    }
}