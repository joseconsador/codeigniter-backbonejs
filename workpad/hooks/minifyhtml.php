<?php
class Minifyhtml {
	function output()
	{
		$CI =& get_instance();
		$buffer = $CI->output->get_output();
		 
		$search = array(
		    '/97ed7d147627494968723a2bc9f346c699e2a004gt;[^\S ]+/s',    //strip whitespaces after tags, except space
		    '/[^\S ]+97ed7d147627494968723a2bc9f346c699e2a004lt;/s',    //strip whitespaces before tags, except space
		    '/(\s)+/s'    // shorten multiple whitespace sequences
		    );
		$replace = array(
		    '>',
		    '<',
		    '\1'
		    );
		$buffer = preg_replace($search, $replace, $buffer);
		 
		$CI->output->set_output($buffer);
		$CI->output->_display();
	}
}
?>