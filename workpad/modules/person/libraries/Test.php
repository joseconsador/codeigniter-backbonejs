<?php

require_once MODPATH . 'person/libraries/PersonAbstract.php';

/**
 * This class represents a Person's work experience.
 */
class Test extends PersonAbstract
{	
	private $_upload_options = array(
		'upload_path' => 'uploads/employee/test_profile/',
		'allowed_types' => 'gif|jpg|png|docx|csv|pdf|xls',
		'max_size'	=> '2000',
		'max_width' => '1024',
		'max_height' => '768',
		'field_name' => 'file_attachment',
		'encrypt_name' => TRUE
	);	

	// --------------------------------------------------------------------

	public function getModel()
	{
		$CI =& get_instance();
        $CI->load->model('test_model', '' ,true);
        
        return $CI->test_model;
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
				$log->user_id  = $this->getUser()->user_id;
				$log->upload   = $this->_upload_options['upload_path'] . $filedata['file_name'];

				$this->log_uploads_id = $log->save();				
			}
		}

		$cache = Cache::get_instance();
		$cache::delete('person' . $this->person_id);		

		return parent::save();
	}		
}