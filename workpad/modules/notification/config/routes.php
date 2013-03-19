<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
// Frontend routes
$route['notifications/get'] = 'notification/notification_controller/get';

// API
$route['api/user/id/(:num)/notifications'] = 'notification/api/user_controller/notifications/user_id/$1';
$route['api/notifications'] = 'notification/api/notification_controller/notifications';
$route['api/notification'] = 'notification/api/notification_controller/notification';
$route['api/notification/id/(:num)'] = 'notification/api/notification_controller/notification';