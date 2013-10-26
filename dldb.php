<?php 
if ($act == 'dldb'){
if ($_SESSION['login'] != true){
$_SESSION[error] = 'Error: Not Enough Access';
redirect("failed.php");
};
if ($_SESSION['login'] == true){
$find_all = mysql_query("SELECT * FROM `files` ORDER BY `id` DESC");
title("Downloads Database");
print '<h1><center>Downloads Database</center></h1>
<hr width="100%" align="center"/>
<table class="table" align="center">
<tr><td>';
while($row = mysql_fetch_array($find_all)){
print '<a href="?act=dldb&action=view&id='.$row[id].'">'.$row[name].'</a><br />
Date Submitted: '.$row[date_submitted].'<br />
Author: '.$row[author].'<br />
Submited by: '.$row[submitted_by].'<br />
'.$row[description].'
<br /><br />';
//limit_text($row[description], 50);
//print '<a href="?act=dldb&action=view&id='.$row[id].'" class="read_more">Read More</a>';
};
print '</td></tr></table>';
};};
?>
