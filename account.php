<?php 
if ($act == 'account'){
if ($_SESSION['login'] != true){
redirect("index.php?act=failed&amp;id=2");
};
if ($_SESSION['login'] == true){
//DISPLAY MEMBERS LIST
if ($act2 == 'members_list'){
title("Members List");
$select_all_members = mysql_query("SELECT * FROM `users`") or die (mysql_error());
$totalnumberofmembers = mysql_num_rows($select_all_members) or die (mysql_error());
print '<h1><center>SUPER TESTING Members List</center></h1>
<hr width="100%" align="center"/>
<center>Total Number of Members: '.$totalnumberofmembers.'</center>
<table class="table" align="center" cellpadding="5" cellspacing="3">
<tr>
<td><strong><center><div style="text-decoration: underline">Username</div></center></strong></td>
<td><strong><center><div style="text-decoration: underline">Group</div></center></strong></td>
</tr>';
$find_admin = mysql_query("SELECT * FROM users WHERE `group` = 'admin' ORDER BY username ASC");
while($row = mysql_fetch_array($find_admin)){
print '<tr>
<td>
<a href="index.php?act=profile&amp;act2=view&amp;username='.$row[username].'"><strong>'.$row[username].'</strong></a>
</td>
<td><strong>Administrator</strong></td>
</tr>';
};
$find_webmaster = mysql_query("SELECT * FROM users WHERE `group` = 'member' ORDER BY username ASC");
while($row = mysql_fetch_array($find_webmaster)){
print '<tr>
<td>
<a href="index.php?act=profile&amp;act2=view&amp;username='.$row[username].'">'.$row[username].'</a>
</td>
<td>Member</td>
</tr>';
};
$find_member = mysql_query("SELECT * FROM users WHERE `group` = 'basic' ORDER BY username ASC");
while($row = mysql_fetch_array($find_member)){
print '<tr>
<td>
<a href="index.php?act=profile&amp;act2=view&amp;username='.$row[username].'">'.$row[username].'</a>
</td>
<td>Basic Member</td>
</tr>';
};
print '</table>';
};//if ($act2 == 'users_list')
};//if ($_SESSION['login'] == true)
};//if ($act == 'account')
?>
