<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// API routes
$route['api/events'] = 'calendar/api/event_controller/events';
$route['api/event'] = 'calendar/api/event_controller/event';
$route['api/event/id/(:num)'] = 'calendar/api/event_controller/event/id/$1';
$route['api/event_involved/id/(:num)'] = 'calendar/api/involved_controller/involved/id/$1';
// Frontend routes
$route['employee/calendar'] = 'calendar/employee_controller/index';