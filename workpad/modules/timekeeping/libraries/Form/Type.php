<?php

/**
 * This class represents a form/form type.
 */
class Form_Type extends Base
{	
    // --------------------------------------------------------------------

    public function getModel()
    {
        $CI =& get_instance();
        $CI->load->model('formtype_model', '' ,true);

        return $CI->formtype_model;
    }
	
	// --------------------------------------------------------------------
	
    public function set_validators()
    {
    	$this->_validators['form_code'] = array(new Zend_Validate_NotEmpty());
    	$this->_validators['form'] = array(new Zend_Validate_NotEmpty());
    }
}