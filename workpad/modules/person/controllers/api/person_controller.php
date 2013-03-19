<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Person_controller extends HDI_rest_controller
{
	function __construct()
	{
		parent::__construct();
        $this->load->library('Person');
	}

    // --------------------------------------------------------------------

    public function person_get()
    {
        $person = new Person($this->get('id'));

        $this->response($person->getData());
    }


    // --------------------------------------------------------------------

    public function person_post()
    {
        $response = array('status' => 'failed', 'message' => '');
    
        $person = new Person();
        
        $id = $person->persist($this->_args)->save();

        if ($id) {
            $response['id'] = $id;
            $response['url'] = site_url('api/person/id/' . $id);
        } else {
            $response['message'] = $person->get_validation_errors();
        }        

        $this->response($response, 201, 'xml');
    }

    // --------------------------------------------------------------------

    public function person_put()
    {
        $person = new Person($this->put('person_id'));
        $person->persist($this->_args);

        $id = $person->save();

        if (!$id) {
            $this->response(array('message' => $person->get_validation_errors()));
        } else {            
            $cache = Cache::get_instance();
            $cache::delete('person' . $person->person_id);
            $this->response($person->getData());
        }
    }        

    // --------------------------------------------------------------------

    /**
     * Return an array of a person's work experience
     *
     * @param $id Person ID
     * 
     * @return mixed Depends on chosen format
     */
    public function work_get()
    {
        $this->load->library('Work');
        $work = new Work();

        $response['_count'] = 0;

        if ($r = $work->getModel()->search('person_id', $this->get('id'))) {
            $response = array();
            $response['data']   = $r->result();
            $response['_count'] = $r->num_rows();
        }    

        $this->response($response);
    }

    // --------------------------------------------------------------------

    /**
     * Return an array of a person's details
     *
     * @param $id Person ID
     * 
     * @return mixed Depends on chosen format
     */
    public function detail_get()
    {
        $this->load->library('Detail');
        $detail = new Detail();
        
        $response = $detail->getData();

        if ($r = $detail->load($this->get('id'), 'person_id')) {
            $response = $r->getData();            
        }    

        $this->response($response);
    }    

    // --------------------------------------------------------------------

    /**
     * Return an array of a person's personal references
     *
     * @param $id Person ID
     * 
     * @return mixed Depends on chosen format
     */
    public function references_get()
    {
        $this->load->library('Reference');
        $reference = new Reference();

        $response['_count'] = 0;

        if ($r = $reference->getModel()->search('person_id', $this->get('id'))) {
            $response = array();
            $response['data']   = $r->result();
            $response['_count'] = $r->num_rows();
        }    

        $this->response($response);
    }    

    // --------------------------------------------------------------------

    /**
     * Return an array of a person's affiliations
     *
     * @param $id Person ID
     * 
     * @return mixed Depends on chosen format
     */
    public function affiliations_get()
    {
        $this->load->library('Affiliation');
        $affiliation = new Affiliation();

        $response['_count'] = 0;

        if ($r = $affiliation->getModel()->search('person_id', $this->get('id'))) {
            $response = array();
            $response['data']   = $r->result();
            $response['_count'] = $r->num_rows();
        }    

        $this->response($response);
    }       

    // --------------------------------------------------------------------

    /**
     * Return an array of a person's skills
     *
     * @param $id Person ID
     * 
     * @return mixed Depends on chosen format
     */
    public function skills_get()
    {
        $this->load->library('Skill');
        $skill = new Skill();

        $response['_count'] = 0;

        if ($r = $skill->getModel()->search('person_id', $this->get('id'))) {
            $response = array();
            $response['data']   = $r->result();
            $response['_count'] = $r->num_rows();
        }    

        $this->response($response);
    }         

    // --------------------------------------------------------------------

    /**
     * Return an array of a person's trainings
     *
     * @param $id Person ID
     * 
     * @return mixed Depends on chosen format
     */
    public function trainings_get()
    {
        $this->load->library('Training');
        $trainings = new Training();

        $response['_count'] = 0;

        if ($r = $trainings->getModel()->search('person_id', $this->get('id'))) {
            $response = array();
            $response['data']   = $r->result();
            $response['_count'] = $r->num_rows();
        }    

        $this->response($response);
    }        

    // --------------------------------------------------------------------

    /**
     * Return an array of a person's test profiles
     *
     * @param $id Person ID
     * 
     * @return mixed Depends on chosen format
     */
    public function tests_get()
    {
        $this->load->library('Test');
        $tests = new Test();

        $response['_count'] = 0;

        if ($r = $tests->getModel()->search('person_id', $this->get('id'))) {
            $response = array();
            $response['data']   = $r->result();
            $response['_count'] = $r->num_rows();
        }    

        $this->response($response);
    }

    /**
     * Return an array of a person's education 
     *
     * @param $id Person ID
     * 
     * @return mixed Depends on chosen format
     */
    public function education_get()
    {
        $this->load->library('Education');
        $education = new Education();

        $response['_count'] = 0;

        if ($r = $education->getModel()->search('person_id', $this->get('id'))) {
            $response = array();
            $response['data']   = $r->result();
            $response['_count'] = $r->num_rows();
        }    

        $this->response($response);
    }    

    // --------------------------------------------------------------------

    /**
     * Return an array of a person's Government ID numbers
     *
     * @param $id Person ID
     * 
     * @return mixed Depends on chosen format
     */
    public function idnos_get()
    {
        $this->load->library('Idnos');
        $idnos = new Idnos();

        $response['_count'] = 0;

        if ($r = $idnos->getModel()->search('person_id', $this->get('id'))) {
            $response = array();
            $response['data']   = $r->result();
            $response['_count'] = $r->num_rows();
        }    

        $this->response($response);
    }

    // --------------------------------------------------------------------

    /**
     * Return an array of a person's addresses
     *
     * @param $id Person ID
     * 
     * @return mixed Depends on chosen format
     */
    public function addresses_get()
    {
        $this->load->library('Address');
        $address = new Address();

        $response['_count'] = 0;

        if ($r = $address->getModel()->search('person_id', $this->get('id'))) {
            $response = array();
            $response['data']   = $r->result();
            $response['_count'] = $r->num_rows();
        }    

        $this->response($response);
    }

    // --------------------------------------------------------------------

    /**
     * Return an array of a person's accountabilities
     *
     * @param $id Person ID
     * 
     * @return mixed Depends on chosen format
     */
    public function accountabilities_get()
    {
        $this->load->library('Accountability');
        $accountability = new Accountability();

        $response['_count'] = 0;

        if ($r = $accountability->getModel()->search('employee_id', $this->get('id'))) {
            $response = array();
            $response['data']   = $r->result();
            $response['_count'] = $r->num_rows();
        }    

        $this->response($response);
    }    

    // --------------------------------------------------------------------

    /**
     * Return an array of a person's family members
     *
     * @param $id Person ID
     * 
     * @return mixed Depends on chosen format
     */
    public function family_get()
    {
        $this->load->library('Family');
        $family = new Family();

        $response['_count'] = 0;

        if ($r = $family->getModel()->search('person_id', $this->get('id'))) {
            $response = array();
            $response['data']   = $r->result();
            $response['_count'] = $r->num_rows();
        }    

        $this->response($response);
    }        
}