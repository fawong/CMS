<?php
include_once('includes/ezSQL/shared/ez_sql_core.php');
include_once('includes/ezSQL/mysqli/ez_sql_mysqli.php');

// Connect to database
$db = new ezSQL_mysqli("$db_username", "$db_password", "$db_name", "$db_host");

// Get CMS name
$cms_name = $db->get_row("SELECT * FROM settings WHERE `setting` = 'cmsname'")->value;
?>
