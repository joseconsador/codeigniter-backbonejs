<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config['observers']['form_application_create'][] = array(
	'class' => 'Form_Application_Observer',
	'methods' => array('send_new_notification', 'log_new_feed')
);

$config['observers']['form_application_update_status'][] = array(
	'class' => 'Form_Application_Observer',
	'methods' => array('send_status_update_notification', 'log_update_feed')
);