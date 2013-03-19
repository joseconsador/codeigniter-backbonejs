<?php

/**
 * This class represents a Person.
 */
class Person extends Base
{
	public function __construct($id = null)
	{
		parent::__construct($id);
	}

	// --------------------------------------------------------------------

	public function getModel()
	{	
		$ci =& get_instance();	
        $ci->load->model('person_model', '' ,true);
        
        return $ci->person_model;
	}

	// --------------------------------------------------------------------

	public function get_references()
	{
		$ci =& get_instance();
		$ci->load->model('reference_model');

		$references = $ci->reference_model->search('person_id', $this->getId());

		if ($references) {
			return $references->result();
		} else {
			return null;
		}
	}

	// --------------------------------------------------------------------

	public function get_work_experience()
	{
		$ci =& get_instance();

		$ci->load->model('work_model');

		$workexperiences = $ci->work_model->search('person_id', $this->getId());

		if ($workexperiences) {
			return $workexperiences->result();
		} else {
			return null;
		}
	}

	// --------------------------------------------------------------------

	public function get_affiliations()
	{
		$ci =& get_instance();

		$ci->load->model('affiliation_model');

		$affiliations = $ci->affiliation_model->search('person_id', $this->getId());

		if ($affiliations) {
			return $affiliations->result();
		} else {
			return null;
		}
	}
	
	// --------------------------------------------------------------------

	public function get_skills()
	{
		$ci =& get_instance();
		$ci->load->model('skill_model');

		$skills = $ci->skill_model->search('person_id', $this->getId());

		if ($skills) {
			return $skills->result();
		} else {
			return null;
		}
	}

	// --------------------------------------------------------------------

	public function get_trainings()
	{
		$ci =& get_instance();
		$ci->load->model('training_model');

		$trainings = $ci->training_model->search('person_id', $this->getId());

		if ($trainings) {
			return $trainings->result();
		} else {
			return null;
		}
	}

	// --------------------------------------------------------------------

	public function get_tests()
	{
		$ci =& get_instance();
		$ci->load->model('test_model');

		$tests = $ci->test_model->search('person_id', $this->getId());

		if ($tests) {
			return $tests->result();
		} else {
			return null;
		}
	}

	// --------------------------------------------------------------------

	public function get_details()
	{
		$ci =& get_instance();
		$ci->load->model('detail_model');

		$details = $ci->detail_model->search('person_id', $this->getId());

		if ($details) {
			return $details->row();
		} else {
			return null;
		}
	}

	// --------------------------------------------------------------------

	public function get_education()
	{
		$ci =& get_instance();
		$ci->load->model('education_model');

		$educations = $ci->education_model->search('person_id', $this->getId());

		if ($educations) {
			return $educations->result();
		} else {
			return null;
		}
	}

	// --------------------------------------------------------------------

	public function get_idnos()
	{
		$ci =& get_instance();
		$ci->load->model('idnos_model');

		$idnos = $ci->idnos_model->search('person_id', $this->getId());

		if ($idnos) {
			return $idnos->result();
		} else {
			return null;
		}
	}

	// --------------------------------------------------------------------

	public function get_addresses()
	{
		$ci =& get_instance();
		$ci->load->model('address_model');

		$addresses = $ci->address_model->search('person_id', $this->getId());

		if ($addresses) {
			return $addresses->result();
		} else {
			return null;
		}
	}

	// --------------------------------------------------------------------

	public function get_family()
	{
		$ci =& get_instance();
		$ci->load->model('family_model');

		$families = $ci->family_model->search('person_id', $this->getId());

		if ($families) {
			return $families->result();
		} else {
			return null;
		}
	}	

	// --------------------------------------------------------------------
	
	public function getData()
	{
		$data = parent::getData();
		$data['references'] 	  = $this->get_references();
		$data['work_experience']  = $this->get_work_experience();
		$data['affiliations']     = $this->get_affiliations();
		$data['skills'] 	 	  = $this->get_skills();
		$data['trainings']        = $this->get_trainings();
		$data['tests']			  = $this->get_tests();
		$data['details']		  = $this->get_details();
		$data['education']		  = $this->get_education();
		$data['idnos']			  = $this->get_idnos();
		$data['addresses']		  = $this->get_addresses();
		$data['family']			  = $this->get_family();

		return $data;
	}
}