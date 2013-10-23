<?php
//PAGE COMMAND
if ($act == ''){
if ($act2 == ''){
if ($cmd == ''){
if ($page != ''){
$find_page = mysql_query("SELECT * FROM `pages` WHERE `page` = '$page'");
if (mysql_num_rows($find_page) == 1){
while ($row = mysql_fetch_array($find_page)){
title("$row[page_title]");
$password_protected = $row[password];
$_SESSION['page_lock'] = false;
if ($row[$_SESSION[group]] == 1){
if ($password_protected == ''){
mysql_query("UPDATE `pages` SET `views` = views + 1 WHERE `page` = '$page'") or die(mysql_error());
print '<center><h1>'.$row[page_title].'</h1></center>
<hr width="100%" align="center" />
<table class="table" align="center">
<style type="text/css">
'.$row['css'].'
</style>
<tr>
<td>
'.$row[body].'
</td>
</tr>
</table>';
};
if ($password_protected != ''){
if ($_SESSION['page_lock'] == false){
if ($tick == 'tock'){
$password_find = mysql_query("SELECT * FROM `pages` WHERE `password` ='$_POST[pass]' AND `page` ='$page'");
if (mysql_num_rows($password_find) == 1){
mysql_query("UPDATE `pages` SET views = views+1 WHERE `page` ='$page'") or die(mysql_error());
print '<center><h1>'.$row[page_title].'</h1></center>
<hr width="100%" align="center" /><br/>';
print ''.$row[body].'';
$_SESSION['page_lock'] = true;
}else{
print 'ERROR<br /><br />';
};
};
};
if ($_SESSION['page_lock'] != true){
print '<form method="post" action="?page='.$page.'&amp;tick=tock">
<font size = "+1">
This page is password protected.
<br />
You must enter a password to proceed.
</font>
<br /><br />
Password: <input type="password" name="pass" />
<br />
<input type="submit" value="Submit" />
</form>';
};//if ($_SESSION['page_lock'] != true)
};//if ($password_protected != '')
}else{
print '<center><h1>Page Does Not Exist</h1></center>
<hr width="100%" align="center" />
<table class="table" align="center">
<tr><td>
The page you are looking for does not exist
</td></tr></table>';
};//if ($row[$_SESSION[group]] == 1)
};//while ($row = mysql_fetch_array($find_page))
}else{
redirect("index.php?act=failed&amp;id=3");
};//if ($row = mysql_fetch_array($find_page))
};//if ($page != '')
};//if ($cmd == '')
};//if ($act2 == '')
};//if ($act == '')
?>
