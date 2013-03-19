<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// API URL
$route['api/thankyou']  = 'thankyou/api/thankyou_controller/thankyou';
$route['api/user/id/(:num)/thankyous/recieved']  = 'thankyou/api/user_controller/recieved';
$route['api/thankyou/cansend']  = 'thankyou/api/user_controller/cansend';
$route['api/thankyous']  = 'thankyou/api/thankyou_controller/thankyous';