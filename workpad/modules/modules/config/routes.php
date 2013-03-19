<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// API routes
$route['api/modules'] = 'modules/api/module_controller/modules';
$route['api/module/id/(:any)'] = 'modules/api/module_controller/module/id/$1';

// Frontend
$route['admin/modules'] = 'modules/module_controller';