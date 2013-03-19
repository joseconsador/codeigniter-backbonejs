<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config['employee_validation'] = array(
	'firstname' => array(
			'field' => 'firstname',
			'label' => 'First Name',
			'rules' => 'trim|required'
		),
	'lastname' => array(
			'field' => 'lastname',
			'label' => 'Last Name',
			'rules' => 'trim|required'
		)
	);