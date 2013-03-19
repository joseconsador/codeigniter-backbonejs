<?php

/**
 * This class represents a User.
 */
class User extends Base
{	
	protected $_data = array(		
		'user_id'     => 0,		
		'login'       => null,
		'password'    => 'password',
		'email'       => '',
		'inactive'    => 0,
		'first_name'  => null,
		'last_name'   => '',
		'nick_name'   => '',
		'hash'  	  => '',
		'theme' 	  => 'default',
		'language' 	  => 'english',
		'timezone'    => 'Asia/Manila',
		'last_login'  => '0000-00-00 00:00:00',
		'login_count' => 0,
		'position_id' => 0,
		'department_id' => 0,
		'company_id'  => 0,
		'role_id' 	  => 5, // Rank and file
		'applicant_id' => 0,
		'division_id' => 0,
		'job_title_id' => 0,
		'deleted' 	  => 0
	);

	// Store about for caching on one instance used in getData.
	private $_about = null;

	const USER_ALL_ACCESS = 'USER_ALL_ACCESS';

	// --------------------------------------------------------------------

	public function getModel()
	{
		$CI =& get_instance();
        $CI->load->model('users_model', '' ,true);
        
        return $CI->users_model;
	}

	// --------------------------------------------------------------------
	
	public function save()
	{
		$data = $this->getData();		

		if (!$this->isNew()) {
			unset($this->_data['password']);
		}

		$tmp = parent::save();

		if (!$tmp) {
			return FALSE;
		} else {
            // Save ref.
            $refdata = $data;
            $refdata['user_id'] = $tmp;

            $this->refresh();

            $ref_model = new DummyModel('user_ref', 'id');

            if ($this->ref_id > 0) {
            	$refdata['id'] = $this->ref_id;
            }

            $ref_model->do_save($refdata);

			$about = $this->getAbout();

			if (!$about->save()) {
				// Join validation errors.
				$this->_validation_errors = array_merge($this->get_validation_errors(), $about->get_validation_errors());	
				return FALSE;
			}
		}		

		$cache = Cache::get_instance();
		$cache::delete('restlogins');

		return $tmp;
	}

	// --------------------------------------------------------------------

	public function isAdmin()
	{
		return $this->role_id == 1;
	}

	// --------------------------------------------------------------------

	public function isEmployee()
	{
		return $this->employee_id > 0;
	}

	// --------------------------------------------------------------------

	/**
	 * Return full name.
	 *
	 * @return string.
	 */
	public function getFullName()
	{
		return $this->first_name . ' ' . $this->last_name;
	}

	// --------------------------------------------------------------------

	/**
	 * Return the profile link.
	 * 
	 * @return Position
	 */
	public function getProfileLink()
	{
		return site_url('profile/' . $this->hash);
	}

	// --------------------------------------------------------------------

	/**
	 * Get the Department object of this employee.
	 * @return Department
	 */
	public function getDepartment()
	{
		$ci =& get_instance();
		$ci->load->library('department');

		$department = new Department($this->department_id);				

		return $department;
	}

	// --------------------------------------------------------------------

	/**
	 * Get the Company object of this employee.
	 * @return company
	 */
	public function getCompany()
	{
		$ci =& get_instance();
		$ci->load->library('company');
				
		$company = new Company($this->company_id);			

		return $company;
	}


	public function getContact()
	{
		$contact = new User_Contact();

        return $contact->getModel()->get_by_user($this->user_id);
	}

	// --------------------------------------------------------------------

	/**
	 * Get the About object of this employee.
	 * @return Position
	 */
	public function getAbout()
	{
		// Check if _about has already been requested by this instance.
		// To avoid multiple calls to the DB.
		if (is_null($this->_about) || is_null($this->_about->user_id)) {
			$ci =& get_instance();			

			$about = new User_About();
			$about->load($this->user_id, 'user_id');		

			if (is_null($about->getId())) {
				$about->loadArray(parent::getData());
			}

			$this->_about = $about;
		}

		return $this->_about;
	}

	// --------------------------------------------------------------------

	/**
	 * Get the Position object of this employee.
	 * @return Position
	 */
	public function getPosition()
	{
		$ci =& get_instance();
		$ci->load->library('position');		
						
		$position = new Position($this->position_id);

		return $position;
	}

	// --------------------------------------------------------------------

	/**
	 * Get the Detail object of this employee.
	 * @return Detail
	 */
	public function getDetails()
	{
		$ci =& get_instance();
		$ci->load->library('detail');
		$detail = new Detail();
		$detail->load($this->person_id, 'person_id');
		
		return $detail;
	}	

	// --------------------------------------------------------------------

	/**
	 * Get the profile photo URL
	 * 
	 * @return string
	 */
	public function getPhotoUrl()
	{
        if ($about = $this->getAbout()) {
        	$ci =& get_instance();
            $ci->load->config('dir');
            $upload_path = $ci->config->item('upload_dir');

			$path = $upload_path . 'media/' . $about->photo;            

            if (!file_exists($path) || $about->photo == '') {
                $url = base_url().BASE_IMG . 'user-photo.jpg';
            } else {
                $url = site_url($path);
            }
        }	

        return $url;	
	}	

	// --------------------------------------------------------------------

	/**
	 * Get the profile photo thumbnial URL
	 * 
	 * @return string
	 */
	public function getThumbnailUrl()
	{
        if ($about = $this->getAbout()) {
        	$ci =& get_instance();
            $ci->load->config('dir');
            $upload_path = $ci->config->item('upload_dir');

			$path = $upload_path . 'media/thumbnails/' . $about->photo;            

            if (!file_exists($path) || $about->photo == '') {
                $url = base_url().BASE_IMG . 'user-photo.jpg';
            } else {
                $url = site_url($path);
            }
        }	

        return $url;
	}

	// --------------------------------------------------------------------

	public function getData()
	{
		$data = parent::getData();        

        $data['about']     = $this->getAbout()->getData();
        $data['contact']   = $this->getContact();
        $data['photo_url'] = $this->getPhotoUrl();
        $data['thumbnail_url'] = $this->getThumbnailUrl();        

        return $data;
	}

	// --------------------------------------------------------------------

	public function delete()
	{
		$this->getAbout()->delete();
		$this->getDetails()->delete();

		$ref = new User_Ref($this->ref_id);
		$ref->delete();

		return parent::delete();
	}

	// --------------------------------------------------------------------

	/**
	 * Sets validators
	 *
	 * Using this method so we can control error messages.
	 * 
	 */
	public function set_validators()
	{
		$this->_validators['login'] = array(new Zend_Validate_NotEmpty());

		if ($this->hasChanged('login') || $this->isNew()) {			
			$loginValidator = new Hdi_Validate_NoRecordExists(
				array(
					'table' => $this->getModel()->get_table_name(),
					'field' => 'login'
				)
			);

			$this->_validators['login'][] = $loginValidator;
		}

		$emailValidator = new Zend_Validate_EmailAddress();
		$emailValidator->setMessage('Invalid Email Address', Zend_Validate_EmailAddress::INVALID_FORMAT);

		$this->_validators['email'] = array(new Zend_Validate_NotEmpty(), $emailValidator);
        $this->_validators['first_name'] = array(new Zend_Validate_NotEmpty());        
	}
}