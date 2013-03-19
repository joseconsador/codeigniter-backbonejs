<?php

/**
 * This class represents a module item.
 */
class Module extends Base
{
    // --------------------------------------------------------------------

    public function getModel()
    {
        $CI =& get_instance();
        $CI->load->model('module_model', '' ,true);

        return $CI->module_model;
    }
}