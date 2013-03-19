<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// API routes
$route['api/note'] = 'notes/api/note_controller/note/id/$1';
$route['api/note/id/(:num)'] = 'notes/api/note_controller/note/id/$1';
$route['api/user/id/(:num)/notes'] = 'notes/api/user_controller/note/id/$1';
$route['api/user/note'] = 'notes/api/user_controller/note';