<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// API routes
$route['api/employee/id/(:num)/goals'] = 'goals/api/employee_controller/assigned';
$route['api/employee/id/(:num)/goals/created'] = 'goals/api/employee_controller/created';
$route['api/employee/id/(:num)/goals/assigned'] = 'goals/api/employee_controller/assigned';

$route['api/employee/goals'] = 'goals/api/employee_controller/goals';
$route['api/employee/goals/created'] = 'goals/api/employee_controller/created';
$route['api/employee/goals/assigned'] = 'goals/api/employee_controller/assigned';

$route['api/goals'] = 'goals/api/goals_controller/goals';
$route['api/goal'] = 'goals/api/goals_controller/goal';
$route['api/goal/id/(:num)'] = 'goals/api/goals_controller/goal/id/$1';
$route['api/goal/id/(:num)/objectives'] = 'goals/api/goals_controller/objectives/id/$1/';

$route['api/goal_objective'] = 'goals/api/goal_objective_controller/goal_item';
$route['api/goal_objective/id/(:num)'] = 'goals/api/goal_objective_controller/goal_item/id/$1';

$route['api/goal_objective_employee/id/(:num)'] = 'goals/api/goal_objective_employee_controller/employee/id/$1';

// Frontend routes
$route['employee/goals'] = 'goals/employee_controller/index';
$route['supervisor/goals'] = 'goals/immediate_controller/goals';
$route['supervisor/goals/employee/(:num)'] = 'goals/immediate_controller/employee/$1';