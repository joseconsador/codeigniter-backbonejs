<?php

class Hdi_UploadHandler
{
	private $_errors = array();
	private $_data   = array();
	private $_options = array();
	private $CI;

	public function __construct($options)
	{
		$this->_options = $options;

		$this->CI =& get_instance();
		$this->CI->load->library('upload', $options);

		if (!array_key_exists('field_name', $options)) {
			throw new Exception("Field name not set.", 1);			
		}
	}

	// --------------------------------------------------------------------
	// 
	public function upload()
	{
		if ( ! $this->CI->upload->do_upload($this->_options['field_name']))
		{
			$this->_errors = $this->CI->upload->error_msg;

			return FALSE;
		}
		else
		{
			$this->_data = $this->CI->upload->data();

			return TRUE;
		}
	}

	// --------------------------------------------------------------------

	public function get_data()
	{
		return $this->_data;
	}

	// --------------------------------------------------------------------

	public function get_errors()
	{
		return $this->_errors;
	}
}