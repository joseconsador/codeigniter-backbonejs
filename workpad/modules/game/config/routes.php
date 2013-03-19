<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// API routes
$route['api/rewards'] 		   		  = 'game/api/rewards_controller/rewards/id/$1';
$route['api/reward'] 		   		  = 'game/api/rewards_controller/reward';
$route['api/reward/id/(:num)'] 		  = 'game/api/rewards_controller/reward/id/$1';
$route['api/reward/id/(:num)/redeem'] = 'game/api/rewards_controller/redeem/id/$1';

// Frontend routes
$route['employee/rewards'] 		= 'game/employee_controller/index';
$route['employee/rewards_shop'] = 'game/employee_controller/index';
$route['hr/rewards_shop'] 		= 'game/hr_controller/index';