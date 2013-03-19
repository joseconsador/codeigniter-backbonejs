<?php

/**
 * @see Zend_Validate_Abstract
 */
require_once 'Zend/Validate/Abstract.php';

class Hdi_Validate_NoRecordExists extends Zend_Validate_Abstract
{
	const EXISTS = 'exists';

    protected $_messageTemplates = array(
        self::EXISTS => "'%value%' is already on the database."
    );	

    /**
     * The following option keys are supported:
     * 'table'   => The database table to validate against     
     * 'field'   => The field to check for a match     
     *
     */
    public function __construct($options)
    {
        if (!array_key_exists('table', $options)) {            
            throw new Zend_Validate_Exception('Table or Schema option missing!');
        }

        if (!array_key_exists('field', $options)) {         
            throw new Zend_Validate_Exception('Field option missing!');
        }

        $this->_table = $options['table'];
        $this->_field = $options['field'];
    }

    public function isValid($value)
    {
    	$ci =& get_instance();

    	$ci->db->where($this->_field, $value);    	

    	if ($ci->db->count_all_results($this->_table) > 0) {
    		$this->_setValue($value);
	        $this->_error(self::EXISTS);
	        return false;
    	} else {
    		return true;
    	}
    }    
}