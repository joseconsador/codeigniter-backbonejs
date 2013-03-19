<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$nav = array('employee', 'immediate', 'hr', 'master');

$nav['employee'] = array(
	'label' => 'Employee',
	'link' => null,
	'children' => array(),
	'access' => 'PARENT_EMPLOYEE'
	);

$nav['immediate'] = array(
	'label' => 'Immediate',
	'link' => null,
	'children' => array(),
	'access' => 'PARENT_IMMEDIATE'
	);

$nav['hr'] = array(
	'label' => 'HR Admin',
	'link' => null,
	'children' => array(),
	'access' => 'PARENT_HR'
	);

$nav['master'] = array(
	'label' => 'Master',
	'link' => null,
	'children' => array(),
	'access' => 'PARENT_HR'
	);