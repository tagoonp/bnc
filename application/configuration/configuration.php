<?php
header("Access-Control-Allow-Origin: *");
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$config = array(
    'date' => date('Y-m-d'),
    'datetime' => date('Y-m-d H:i:s'),
    'dateuniversal' => date('U'),
    'year' => date('Y'),
    'remote_ip' => $_SERVER['REMOTE_ADDR'],
    'timezone' => 'Asia/Bangkok',
    'app_title' => 'Bancha Clinic version 1.0'
);

date_default_timezone_set($config['timezone']);

$datetime = date('Y-m-d H:i:s');
$date = date('Y-m-d');
$dateu = date('U');
$year = date('Y');
$ip = $_SERVER['REMOTE_ADDR'];
$app_title = 'Bancha Clinic version 1.0';

$month_sh_th = array('', 'ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.');
