<?php

define('BASE_URL',   'http://localhost/payroll/registration/');

define('DB_SERVER', 	'localhost');
define('DB_USER', 		'root');
define('DB_PASSWORD', '');
define('DB_NAME', 		'payroll_mdb');
define('DB_PREFIX', 	'wy_');

error_reporting(1);

date_default_timezone_set("Asia/Kolkata");

$db = mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD, DB_NAME);
if ( mysqli_connect_errno() ) {
  die("Failed to connect to MySQL: " . mysqli_connect_error());
}

session_start();
