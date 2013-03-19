<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Field_controller extends HDI_rest_controller
{
	public function fields_get()
	{
		if ($this->get('resource') == '' || $this->get('module') == '') {
			$this->response(array('error' => 'Resource not specified.'));
		} else {
			$path = MODPATH . $this->get('module') . '/config/module.xml';

			if (file_exists($path)) {
				$modules = new Modules();
				$modules->load_from_xml($path);				
				$resources = $modules->get_resources();

				if (!isset($resources[$this->get('resource')])) {
					$this->response(array('error' => 'Resource not found.'));
				} else {
					$this->response($resources[$this->get('resource')]);
				}
			}
		}
	}
}