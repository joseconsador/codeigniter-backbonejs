<?php

abstract class Activity_Renderer
{
	private $_source;
	
	public function __construct($source)
	{
		$this->_source = $source;
	}

	public function get_source() { return $this->_source; }	
	public function get_data() { return unserialize($this->get_source()->data); }

	abstract function render();
}