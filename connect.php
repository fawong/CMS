<?php
include_once('includes/ezSQL/shared/ez_sql_core.php');
include_once('includes/ezSQL/mysqli/ez_sql_mysqli.php');

function eh($errno, $errstr) {
    http_response_code(500);
    header("Not-A-CMS-Fail: $errstr");
    die("Failed to connect to MySQL database");
}
set_error_handler('eh');

// Connect to database
$db = new ezSQL_mysqli("$db_username", "$db_password", "$db_name", "$db_host");

// Get CMS name
$cms_name = $db->get_row("SELECT * FROM settings WHERE `setting` = 'cmsname'")->value;

// Get footer
$footer = $db->get_row("SELECT * FROM settings WHERE `setting` = 'footer'")->value;
?>
