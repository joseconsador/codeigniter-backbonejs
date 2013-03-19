<?php

class Activity_LoggerFactory
{
	private function __construct() {}

	static function get_logger(Activity_Logger $logger, $source) 
	{
		$logger->set_source($source);
		return $logger;		
	}
}