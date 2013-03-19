<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// API routes
$route['api/201/employees'] = '201/api/employee_controller/employees';
$route['api/201/employee'] = '201/api/employee_controller/employee';
$route['api/201'] = '201/api/employee_controller/employee/id/$1';
$route['api/201/id/(:num)'] = '201/api/employee_controller/employee/id/$1';
$route['api/201/employee/id/(:num)'] = '201/api/employee_controller/employee';
$route['api/unit'] = '201/api/unit_controller/unit';
$route['api/unit/id/(:num)'] = '201/api/unit_controller/unit/id/$1';

// Frontend routes
$route['supervisor/listofemployee'] = '201/immediate_controller/index';
$route['supervisor/employee/(:any)'] = '201/immediate_controller/employee/$1';

$route['hr/employee'] = '201/hr_controller/index';
$route['hr/employee/(:any)'] = '201/hr_controller/employee/$1';