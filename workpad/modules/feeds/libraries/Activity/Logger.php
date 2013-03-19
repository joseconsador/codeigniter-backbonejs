<?php

abstract class Activity_Logger
{
	private $_logger;
	private $_source;	

	public function __construct() 
	{
		$this->_logger = new Activity();
	}

	public function get_logger() { return $this->_logger; }
	public function get_source() { return $this->_source; }
	public function get_action() { return $this->_action; }
	public function set_source($source) { $this->_source = $source; return $this; } 	

	abstract function log($action);	
}