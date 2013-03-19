<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// API URL
$route['api/departments'] = 'department/api/department_controller/departments';

$route['api/department'] = 'department/api/department_controller/department';
$route['api/department/id/(:num)/users'] = 'department/api/department_controller/users/id/$1/';
$route['api/department/users/count'] = 'department/api/department_controller/users_count';