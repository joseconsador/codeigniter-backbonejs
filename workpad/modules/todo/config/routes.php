<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// API routes
$route['api/todo'] = 'todo/api/todo_controller/todo/id/$1';
$route['api/todo/id/(:num)'] = 'todo/api/todo_controller/todo/id/$1';
$route['api/user/id/(:num)/todos'] = 'todo/api/user_controller/todo/id/$1';
$route['api/user/todos'] = 'todo/api/user_controller/todo';