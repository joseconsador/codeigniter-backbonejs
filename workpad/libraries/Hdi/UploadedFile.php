<?php

class Hdi_UploadedFile extends Base
{
	private $_model = null;

	// --------------------------------------------------------------------

	public function getModel()
	{
		if (is_null($this->_model)) {
			$this->_model = new DummyModel('log_uploads', 'upload_id');
		}

        return $this->_model;
	}

	public function delete()
	{
		unlink($this->upload);

		return parent::delete();
	}
}