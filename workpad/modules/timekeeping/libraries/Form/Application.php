<?php

/**
 * This class represents a form.
 */
class Form_Application extends Base
{	
    const MODULE = 'timekeeping';    
    const DRAFT_STATUS = 12;
    const PENDING_STATUS = 13;
    const APPROVED_STATUS = 14;
    const REJECTED_STATUS = 15;
    const CANCELLED_STATUS = 16;
    const COMPLETED_STATUS = 17;

    // --------------------------------------------------------------------

    private $_type = null;
    private $_employee = null;

    // --------------------------------------------------------------------

    protected $_statusVerbs = array(
        self::APPROVED_STATUS => "approve",
        self::REJECTED_STATUS => "decline",
        self::CANCELLED_STATUS => "cancel",
    );    

    // --------------------------------------------------------------------

    protected $_statusVerbsPast = array(
        self::PENDING_STATUS => "pending",
        self::APPROVED_STATUS => "approved",
        self::REJECTED_STATUS => "declined",
        self::CANCELLED_STATUS => "cancelled",
    );    

    // --------------------------------------------------------------------

    protected $_data = array(       
        'status_id' => self::PENDING_STATUS
    );

    // --------------------------------------------------------------------

    public function save()
    {
        $ci =& get_instance();
        $this->modified_by = $ci->get_user()->user_id;

        if ($this->isNew()) {
            if ($id = parent::save()) {
                Hdi_EventDispatcher::dispatch_event('form_application_create', $this);
            }

            return $id;
        } else {
            if (!$this->is_locked()) {
                if ($this->hasChanged('status_id')) {
                    return $this->update_status();
                }

                return parent::save();
            }  else {
                return $this->getId();
            }
        }
    }

    // --------------------------------------------------------------------

    public function update_status()
    {
        $ci =& get_instance();

        $application_approver = new Hdi_ResourceApprover();
        $application_approver->set_new_status_id($this->status_id);
        $application_approver->set_resource($this);
        $application_approver->set_updater(new User($ci->get_user()->user_id));
        $application_approver->set_module_code(self::MODULE);

        if ($application_approver->update()) {
            Hdi_EventDispatcher::dispatch_event('form_application_update_status', $this);

            return TRUE;
        } else {
            $this->_validation_errors['status_id'] = 'Failed to update status.';

            return FALSE;
        }        
    }

    // --------------------------------------------------------------------

    public function get_status_verb()
    {
        return $this->_statusVerbs[$this->status_id];
    }

    // --------------------------------------------------------------------

    public function get_status_verb_past()
    {
        return $this->_statusVerbsPast[$this->status_id];
    }

    // --------------------------------------------------------------------

    public function getModel()
    {
        $CI =& get_instance();
        $CI->load->model('form_application_model', '' ,true);

        return $CI->form_application_model;
    }

    // --------------------------------------------------------------------

    public function get_form_type()
    {
        if (is_null($this->_type) && $this->form_type_id > 0) {
            $this->_type = new Form_Type($this->form_type_id);
        }

        return $this->_type;
    }

    // --------------------------------------------------------------------

    public function get_employee()
    {
        if (is_null($this->_employee)) {
            $this->_employee = new Employee($this->employee_id);
        }

        return $this->_employee;
    }

    // --------------------------------------------------------------------

    public function get_color()
    {
        if ($this->is_approved()) {
            return 'blue';
        } elseif ($this->is_rejected()) {
            return 'red';
        } else {
            return 'green';
        }
    }

    // --------------------------------------------------------------------

    public function is_approved()
    {
        return ($this->get_original_value('status_id') == self::APPROVED_STATUS);
    }

    // --------------------------------------------------------------------

    public function is_rejected()
    {
        return ($this->get_original_value('status_id') == self::REJECTED_STATUS);
    }

    public function is_locked()
    {
        return $this->is_approved() || $this->is_rejected();
    }

    // --------------------------------------------------------------------    

    public function getData()
    {
        $data = parent::getData();
        $data['employee'] = Rest_ResponseFilter::filter($this->get_employee()->getData(), array('login', 'password'));
        $data['approved'] = $this->is_approved();
        $data['locked']   = $this->is_locked();

        return $data;
    }	

    // --------------------------------------------------------------------

    /**
     * Sets validators.
     * Fetch the form type's attributes and validate the rules against the user
     *     
     */
    public function set_validators()
    {    
        $form_validator = new Zend_Validate_NotEmpty();
        $form_validator->setMessage('Please select a form type.');

        $form_validate_greater = new Zend_Validate_GreaterThan(array('min' => 0));
        $form_validate_greater->setMessage('Please select a form type.');

        $this->_validators['form_type_id'] = array(
            $form_validator,
            $form_validate_greater
        );
        
        if ($this->reason != '') {
            $this->_validators['reason'] = array(new Zend_Validate_NotEmpty());
        }

        $time_validator = new Zend_Validate_GreaterThan(array('min' => date('Y-m-d', strtotime('-1 day', strtotime($this->date_from)))));
        $time_validator->setMessage('Start date cannot be greater than end date.');

        $this->_validators['date_from'] = array(new Zend_Validate_NotEmpty());
        $this->_validators['date_to'] = array(
            new Zend_Validate_NotEmpty(), 
            $time_validator    
        );

        $employee = $this->get_employee()->getData();

        $this->civil_status_id = $employee['civil_status_id'];
        $this->type_id = $employee['civil_status_id'];  
        // use strtolower to avoid case problems 'Male' != 'male'      
        $this->gender  = strtolower($employee['gender']);
        $this->tenure  = $employee['tenure'];

        if ($this->form_type_id > 0) {
            $form_type = $this->get_form_type()->getData();

            if ($form_type['civil_status_id'] > 0) {         
                $validator = new Zend_Validate_Identical(
                    array(
                        'token' => $form_type['civil_status_id'],
                        'strict' => FALSE
                    )
                );
                
                $validator->setMessage('This form is available for ' . $form_type['civil_status'] . ' employees only.', 
                    Zend_Validate_Identical::NOT_SAME);

                $this->_validators['civil_status_id'] = array($validator);
            }

            if ($form_type['employment_status_id'] > 0) {
                $validator = new Zend_Validate_Identical(
                    array(
                        'token' => $form_type['employment_status_id'],
                        'strict' => FALSE
                    )
                );

                $this->_validators['type_id'] = array($validator);
            }

            if ($form_type['tenure'] > 0) {
                $this->_validators['tenure'] = 
                    array(new Zend_Validate_GreaterThan(array('min' => ($form_type['tenure'] - 1))));
            }

            if ($form_type['gender'] != strtolower('all')) {
                $this->_validators['gender'] = array(new Zend_Validate_Identical(strtolower($form_type['gender'])));
            }
        }
    }
}