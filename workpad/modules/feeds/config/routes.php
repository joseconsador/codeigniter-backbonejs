<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// API URL
$route['api/feed']  = 'feeds/api/feeds_controller/feed';
$route['api/feed/id/(:num)']  = 'feeds/api/feeds_controller/feed/id/$1';
$route['api/user/id/(:num)/feeds']  = 'feeds/api/feeds_controller/user';
$route['api/user/id/(:num)/activity']  = 'feeds/api/activity_controller/activity';
$route['api/user/activity']  = 'feeds/api/activity_controller/activity';
$route['api/group/feed'] = 'feeds/api/feeds_controller/group';

$route['feeds/feed_post'] = 'feeds/feeds_controller/feed_post';
$route['feeds/get_user_feeds'] = 'feeds/feeds_controller/get_user_feeds';
