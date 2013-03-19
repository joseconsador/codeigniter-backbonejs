<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config['observers']['goal_item_assign'][] = array(
	'class' => 'Goal_Observer',
	'methods' => array('log_goal_item_assign')
	);

/*$config['observers']['goal_create'][] = array(
	'class' => 'Goal_Observer',
	'methods' => array('log_new_goal_feed')
	);*/

/*$config['observers']['goal_item_create'][] = array(
	'class' => 'Goal_Observer',
	'methods' => array('log_new_goal_item_feed')
	);*/