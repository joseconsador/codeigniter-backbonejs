<?php

class Modules
{
	public $modules;

	private $_resources;
	private $_navs;		

	function load_from_xml($path)
	{
		$modulexml = simplexml_load_file($path);

		$this->modules = $modulexml;
		$this->_resources = $modulexml->resources;
		$this->_navs = $modulexml->navs;
	}	

	function get_default_modules_xml()
	{
		return simplexml_load_file(MODULES_XML_PATH);
	}

	function get_resources()
	{
		$resources = array();

		foreach ($this->_resources as $resource) {
			$resource = $resource->resource;
			$_r = array();
			$_r['url'] 	  = (string) $resource->url;
			$_r['fields'] = array();

			if (isset($resource->fields)) {					
				foreach ($resource->fields->field as $field) {
					$_r['fields'][] = $field;
				}
			}

			$resources[(string) $resource['name']] = $_r;
		}

		return $resources;
	}
}