<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$route['profile'] 		 = 'users/profile_controller';
$route['profile/(:any)'] = 'users/profile_controller/show/$1';

$route['user/about'] = 'users/user_controller/about';
$route['admin/users'] = 'users/admin/user_controller';

$route['api/users'] 	   = 'users/api/user_controller/users';
$route['api/user'] 		   = 'users/api/user_controller/user';
$route['api/user/id/(:num)']   = 'users/api/user_controller/user/user_id/$1';
$route['api/user/id/(:num)/about']   = 'users/api/about_controller/about/user_id/$1';
$route['api/user/about']   = 'users/api/about_controller/about';
$route['api/user/id/(:num)/contact'] = 'users/api/contact_controller/contact/user_id/$1';
$route['api/user/id/(:num)/photo']   = 'users/api/photo_controller/photo/user_id/$1';
$route['api/user/id/(:num)/ref']     = 'users/api/user_controller/ref/id/$1';
$route['api/user/id/(:num)/subordinates']     = 'users/api/user_controller/subordinates/id/$1';

$route['api/ref']     = 'users/api/ref_controller/ref';
$route['api/ref/id/(:num)']     = 'users/api/ref_controller/ref';

$route['api/contact'] 		    = 'users/api/contact_controller/contact';
$route['api/contact/id/(:num)'] = 'users/api/contact_controller/contact/id/$1';