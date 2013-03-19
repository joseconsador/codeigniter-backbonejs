<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config['observers']['event_participant_add'][] = array(
	'class' => 'Calendar_Event_Participant_Observer',
	'methods' => array('notify_participant')
	);