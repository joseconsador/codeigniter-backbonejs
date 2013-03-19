<?php
/**
 * This class represents an employee's units(accountabilities).
 */
class Unit extends Base
{	
	private $_employee = null;	
	private $_upload_options = array(
		'upload_path' => 'uploads/employee/unit/',
		'allowed_types' => 'gif|jpg|png|doc|csv|pdf|xls',
		'max_size'	=> '2000',
		'max_width' => '1024',
		'max_height' => '768',
		'field_name' => 'file_attachment',
		'encrypt_name' => TRUE
	);

	protected $_validators = array(		
        'equipment' => array('Zend_Validate_NotEmpty')
    );

	// --------------------------------------------------------------------

	public function getEmployee()
	{
		if (is_null($this->_employee)) {
			$CI =& get_instance();
			$CI->load->library('employee');

			$this->_employee = new Employee($this->employee_id);
		}

		return $this->_employee;
	}

	// --------------------------------------------------------------------	

	public function getAttachment()
	{
		if ($this->log_uploads_id > 0) {
			$file = new Hdi_UploadedFile($this->log_uploads_id);
			return $file;
		} else {
			return null;
		}
	}

	// --------------------------------------------------------------------

	public function getModel()
	{
		$CI =& get_instance();
        $CI->load->model('accountability_model', '' ,true);

        return $CI->accountability_model;
	}

	// --------------------------------------------------------------------

	public function save()
	{
		$id = FALSE;

		if (array_key_exists('file_attachment', $_FILES)) {
			$handle = new Hdi_UploadHandler($this->_upload_options);

			$id = parent::save();

			if ($id && !$handle->upload()) {
				$this->_validation_errors['file_attachment'] = $handle->get_errors();

				return FALSE;
			} else if ($id) {
				$filedata = $handle->get_data();

				if ($this->log_uploads_id > 0) {					
					$old = $this->getAttachment();
					$old->delete();
				}

				$log = new Hdi_UploadedFile();
				
				$log->filename = $filedata['orig_name'];
				$log->user_id  = $this->getEmployee()->user_id;
				$log->upload   = $this->_upload_options['upload_path'] . $filedata['file_name'];

				$this->log_uploads_id = $log->save();				
			}
		}

		$cache = Cache::get_instance();
		$cache::delete('employee' . $this->employee_id);

		return parent::save();
	}

	// --------------------------------------------------------------------
	
	public function delete()
	{		
		$cache = Cache::get_instance();
		$cache::delete('employee' . $this->employee_id);

		return $this->getAttachment()->delete() && parent::delete();
	}	
}