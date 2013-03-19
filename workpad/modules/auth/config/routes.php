<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$route['api/auth/login']  = 'auth/api/auth_controller/login';
$route['api/auth/access']  = 'auth/api/auth_controller/access';

// --------------------------------------------------------------------

$route['auth/login']  = 'auth/auth_controller/login';
$route['auth/get_redirect_url']  = 'auth/auth_controller/get_redirect_url';
$route['logout']  = 'auth/auth_controller/logout';
$route['auth/client_login']  = 'auth/auth_controller/client_login';
