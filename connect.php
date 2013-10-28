<?php
// Connect to database
$connect = mysql_connect($db_host, $db_username, $db_password) or die(mysql_error());
$db = mysql_select_db($db_name) or die(mysql_error());

// Get CMS name
$get_cms_name = mysql_query("SELECT * FROM settings WHERE `setting` = 'cmsname'") or die (mysql_error());
$cms_name_fetch = mysql_fetch_array($get_cms_name);
$cms_name = $cms_name_fetch['value'];
?>
