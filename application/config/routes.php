<?php
defined('BASEPATH') OR exit('No direct script access allowed');


$route['default_controller'] = 'Page/landing_page'; 

$route['page/landing_page'] = 'Page/landing_page';
$route['page/reserve'] = 'Page/reserve';
$route['page/view-reservation'] = 'Page/view_reservations'; 
$route['page/loginview'] = 'Page/login'; 
$route['page/register'] = 'Page/register'; 
$route['page/timetable'] = 'Page/timetable'; 
$route['Page/approve_reservation/(:any)'] = 'Page/approve_reservation/$1';
$route['Page/decline_reservation/(:any)'] = 'Page/decline_reservation/$1';



$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
