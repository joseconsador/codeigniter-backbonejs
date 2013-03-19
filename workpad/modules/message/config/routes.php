<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// API URL
$route['api/message']  = 'message/api/message_controller/message';
$route['api/message/id/(:num)']  = 'message/api/message_controller/message/id/$1';
$route['api/messages']  = 'message/api/message_controller/messages';
$route['api/messages/sent']  = 'message/api/message_controller/sent';
$route['api/messages/recieved']  = 'message/api/message_controller/recieved';

$route['messages']  = 'message/message_controller';
$route['messages/(:any)']  = 'message/message_controller/$1';