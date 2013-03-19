<?php

/**
 * This class represents a position.
 */
class Position extends Base
{
	public function getModel()
	{	
		$ci =& get_instance();
		$ci->load->model('position_model');
        return $ci->position_model;
	}	

	public function __toString()
	{
		return _p($this->getData(), 'position');
	}

	public function getType()
	{
		$ci =& get_instance();
		$ci->load->model('options_model');
		$t = $ci->options_model->get($this->default_type);

		return $t->option;
	}

	public function getData()
	{
		$data = parent::getData();
		$data['type'] = $this->getType();

		return $data;
	}
}