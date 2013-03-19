<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// API URL
$route['api/admin_options/options']  = 'admin_options/api/options_controller/options';
$route['api/options']  = 'admin_options/api/options_controller/options';
$route['api/moptions']  = 'admin_options/api/options_controller/moptions';

$route['api/admin_options/masters']  = 'admin_options/api/options_controller/masters';
$route['api/admin_options/id/(:num)'] = 'admin_options/api/options_controller/master/id/$1';

// Frontend routes
$route['admin/employee'] = 'admin_options/options_controller/index';