<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// API routes
$route['api/timelogs']   = 'timekeeping/api/timelog_controller/timelogs';
$route['api/timelog']   = 'timekeeping/api/timelog_controller/timelog';
$route['api/timelog/id/(:num)']   = 'timekeeping/api/timelog_controller/timelog/id/$1';

$route['api/employee/id/(:num)/timelogs']   = 'timekeeping/api/employee_controller/timelogs/id/$1';
$route['api/employee/id/(:num)/shift']   = 'timekeeping/api/employee_controller/shift/id/$1';
$route['api/employee/id/(:num)/formtypes']   = 'timekeeping/api/employee_controller/formtypes/id/$id';
$route['api/employee/id/(:num)/leavetypes']   = 'timekeeping/api/employee_controller/leavetypes/id/$id';

$route['api/formtypes']   = 'timekeeping/api/formtype_controller/formtypes';
$route['api/formtype']   = 'timekeeping/api/formtype_controller/formtype';
$route['api/formtype/id/(:num)']   = 'timekeeping/api/formtype_controller/formtype/id/$1';
$route['api/forms']   = 'timekeeping/api/form_controller/forms';
$route['api/forms/for_approval']   = 'timekeeping/api/form_controller/forms_approval';
$route['api/form']   = 'timekeeping/api/form_controller/form';
$route['api/form/id/(:num)']   = 'timekeeping/api/form_controller/form/id/$1';
$route['api/form/id/(:num)/(:any)']   = 'timekeeping/api/form_controller/$2';

// Frontend routes
$route['supervisor/timesheet'] = 'timekeeping/immediate_controller/index';
$route['supervisor/form_applications'] = 'timekeeping/immediate_controller/form_applications';
$route['hr/timekeeping'] = 'timekeeping/hr_controller/index';
$route['hr/timekeeping/(:any)'] = 'timekeeping/hr_controller/$1';
$route['employee/timesheet'] = 'timekeeping/employee_controller/index';
$route['employee/timegraph'] = 'timekeeping/employee_controller/timegraph';