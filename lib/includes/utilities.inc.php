<?php

/* Turn on error reporting */
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
if (filter_input(INPUT_SERVER, 'SERVER_NAME', FILTER_SANITIZE_URL) == "localhost") {
    error_reporting(-1); // -1 = on || 0 = off
} else {
    error_reporting(0); // -1 = on || 0 = off
}
date_default_timezone_set('America/Detroit');
$seconds = 60;
$minutes = 60;
$hours = 24;
$days = 14;

/*
 * http://cyh.herokuapp.com/cyh
 */
header("Content-Type: text/html; charset=utf-8");
header('X-Frame-Options: SAMEORIGIN'); // Prevent Clickjacking:
header('X-Content-Type-Options: nosniff');
header('x-xss-protection: 1; mode=block');
header('Strict-Transport-Security: max-age=31536000; includeSubDomains');
//header("content-security-policy: default-src 'self'; report-uri /csp_report_parser");
header('X-Permitted-Cross-Domain-Policies: master-only');

session_set_cookie_params($seconds * $minutes * $hours * $days, "/", ".pepster.com", true, true);
session_start();
include_once 'functions.secret.token.php';

// Check for a user in the session:
$user = (isset($_SESSION["user"])) ? $_SESSION["user"] : NULL;
/* Autoloads classes using namespaces                       */
require_once "lib/website_project/website_project.inc.php";
include 'connect/connect.php'; // Connection Variables:

use website_project\database\Database as DB;

/*
 * Website Design & Development Rev 1.01 Alpha
 * Created by John R. Pepp
 * Created on February 11, 2016
 * Revised on February 13, 2016
 */
$db = DB::getInstance();
$pdo = $db->getConnection();
/* Get the current page */
$phpSelf = filter_input(INPUT_SERVER, 'PHP_SELF', FILTER_SANITIZE_URL);
$path_parts = pathinfo($phpSelf);
$basename = $path_parts['basename']; // Use this variable for action='':
$pageName = ucfirst($path_parts['filename']);
