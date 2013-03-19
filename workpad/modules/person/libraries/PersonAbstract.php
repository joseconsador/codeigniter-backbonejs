<?php

abstract class PersonAbstract extends Base
{	
	protected $_person = null; 
	protected $_user   = null;

	// --------------------------------------------------------------------
	
	public function getPerson()
	{
		if (is_null($this->_person)) {
			$ci =& get_instance();
			$ci->load->library('person');			

			$this->_person = new Person($this->person_id);
		}

		return $this->_person;
	}


	// --------------------------------------------------------------------
	
	public function getUser()
	{
		if (is_null($this->_user)) {
			$ci =& get_instance();
			$ci->load->model('users_model');			

			$this->_user = $ci->users_model->get_by_person_id($this->person_id);
		}

		return $this->_user;
	}	
}