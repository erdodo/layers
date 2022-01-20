<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'layers';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['update/(.+)']='update/$1';
$route['layers/(.+)'] = 'layers/getLayer/$1';    

