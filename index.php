<?php
session_start();
// GLOBAL VARIABLES
$currentusername = $_SESSION['username'];
$currentfirstname = $_SESSION['firstname'];
$currentlastname = $_SESSION['lastname'];
$requestusername = $_GET['username'];
$user_id = $_GET['user_id'];
$requestid = $_GET['id'];
$page = $_GET['page'];
$act = $_GET['act'];
$act2 = $_GET['act2'];
$set = $_GET['set'];
$set2 = $_GET['set2'];
$id = $_GET['id'];
$cmd = $_GET['cmd'];
$cpath = $_GET['cpath'];
$file_name = $_GET['filename'];
$dir = $_GET['dir'];
$file = $_GET['file'];
$ip = $_SERVER['REMOTE_ADDR'];
$tick = $_GET['tick'];
$timestamp = date("r");
$current_date = date('F j, Y');
$current_time = date('g:i:s A');
$local_timezone = date("O"); 
$time = time(); 
$local_time = date("l, F d, Y \a\\t h:i:s A");
global $pagetitle;
// REQUIRED PHP SCRIPTS
if (file_exists('settings.php')) {
    require_once('settings.php');
} else {
    die('Please copy the settings.php.sample file to settings.php and make changes.');
}
require('version.php');
require_once('connect.php');
require_once('functions.php');

// HEADER
require_once('header.php');
//
// BODY
require_once('body.php');

// ACT CONTROLS
if ($act == 'admin') {
    require_once('admin.php');
} else if ($act == 'wpcp') {
    require_once('wpcp.php');
} else if ($act == 'register') {
    require_once('register.php');
} else if ($act == 'manager') {
    require_once('filemanager.php');
} else if ($act == 'profile') {
    require_once('profile.php');
} else if ($act == 'options') {
    require_once('options.php');
} else if ($act == 'account') {
    require_once('account.php');
} else if ($act == 'login' || $act == 'logout') {
    require_once('loginout.php');
} else if ($act == 'dldb') {
    require_once('dldb.php');
} else if ($act == 'downloadscontrolpanel') {
    require_once('downloadscontrolpanel.php');
} else if ($act == 'calendar') {
    require_once('calendar.php');
} else if ($page != '') {
    require_once('webpage.php');
} else if ($act == 'forgot_username/password') {
    require_once('forgotuserpass.php');
} else if ($act == 'create_account') {
    require_once('register.php');
} else if ($act == 'inbox') {
    require_once('mail.php');
} else if ($act == 'failed') {
    require_once('failed.php');
} else if ($act == 'comments') {
    require_once('comments.php');
} /*else {
    page_header('Go away');
}*/
// FOOTER
require('footer.php');
?>
