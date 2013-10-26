<?php 
if ($act == 'wpcp'){
$check_sql = mysql_query("SELECT * FROM users WHERE username = '$username'");
$check_row = mysql_num_rows($check_sql);
if ($check_row == 1){
$select = mysql_query("SELECT * FROM users WHERE username = '$username'");
while ($row = mysql_fetch_array($select)){
$_SESSION['is_online'] = $row[online];
};};
if($_SESSION[is_online] == 1){
if ($_SESSION['group'] != 'member'){
redirect("failed.php?id=2");
};
if ($_SESSION['group'] == 'member'){
//WEB PAGE FUNCTIONS
if ($action == 'page'){
//SAVE EDITED WEB PAGE
if ($set == 'save_page'){
$admincheckbox = '1';
$membercheckbox = '0';
$basicmembercheckbox = '0';
$publiccheckbox = '0';
if (isset($_POST['admin'])) {
$admincheckbox = $_POST['admin'];
if ($admincheckbox == 'admin') {
$admincheckbox = '1';
};
};
if (isset($_POST['member'])) {
$membercheckbox = $_POST['member'];
if ($membercheckbox == 'member') {
$membercheckbox = '1';
};
};
if (isset($_POST['member'])) {
$basicmembercheckbox = $_POST['member'];
if ($basicmembercheckbox == 'member') {
$basicmembercheckbox = '1';
};
};
if (isset($_POST['public'])) {
$publiccheckbox = $_POST['public'];
if ($publiccheckbox == 'public') {
$publiccheckbox = '1';
};
};
if ($set2 == 'create_page'){
$random_id = rand(000, 9999);
$add_query = mysql_query("INSERT INTO `pages` (`id`, `page`, `page_title`, `header`, `body`, `footer`, `css`, `views`, `hidden`, `admin`, `member`, `basic`, `public`, `username`, `password`) VALUES ($random_id, '$_POST[urlkey]', '$_POST[title]', '$_POST[head]', '$_POST[body]', '$_POST[footer]', '$_POST[css]', '0', '0', '$admincheckbox', '$membercheckbox', '$basicmembercheckbox', '$publiccheckbox', '$username', '$_POST[password]')") or die(mysql_error());
print '<strong>'.$_POST[title].'</strong> has been created successfully.';
};
if($set2 == 'save_edited_page'){
$page_edit = mysql_query("UPDATE `pages` SET `page` = '$_POST[urlkey]', `page_title` = '$_POST[title]', `body` = '$_POST[body]', `admin` = '$admincheckbox', `member` = '$membercheckbox', `basic` = '$basicmembercheckbox', `public` = '$publiccheckbox', `password` = '$_POST[password]', `css` = '$_POST[css]', `header` = '$_POST[head]', `footer` = '$_POST[footer]' WHERE `id` = '$id' AND `username` = '$username'") or die(mysql_error());
print '<strong>'.$_POST[title].'</strong> has been successfully saved.';
};
};
if ($set == 'delete'){
$requesttitle = mysql_query("SELECT * FROM `pages` WHERE `id` = '$id'");
while ($row = mysql_fetch_array($requesttitle)){
$printtitle = $row[page_title];
};
$delete_page = mysql_query("DELETE FROM `pages` WHERE `id` = '$id'") or die(mysql_error());
print '<strong>'.$printtitle.'</strong> has been deleted.';
};
title("Web Page Control Panel");
print '<h1><center>Web Page Control Panel</center></h1>
<hr width="100%" align="center"/>
<table class="table" align="center">
<tr><td>
<a href="?act=wpcp&action=create_new_page">Add a New Web Page</a><br />
</td></tr>
</table><br />
<table class="table" width="100%">
<tr>
<td align="center" width="1"><strong>ID</strong></td>
<td align="center"><strong>Page Title</strong></td>
<td align="center" width="1"><strong>URL Key</strong></td>
<td align="center" width="1"><strong>Administrator Access</strong></td>
<td align="center" width="1"><strong>Member Access</strong></td>
<td align="center" width="1"><strong>Basic Member Access</strong></td>
<td align="center" width="1"><strong>Public Access</strong></td>
<td align="center" width="1"><strong>Views</strong></td>
<td align="center" width="129"><strong>View | Edit | Delete</strong></td>
</tr>';
$select_page_query = mysql_query("SELECT * FROM `pages` WHERE `username` = '$username'");
while($row = mysql_fetch_array($select_page_query)){
print '<tr>
<td align="center">'.sprintf('%04s', $row[id]).'</td>
<td>'.$row[page_title].'</td>
<td align="center">'.$row[page].'</td>';
if($row[admin] == 0)
{$aa = "No";};
if($row[admin] == 1)
{$aa = "Yes";};
print '<td><center>'.$aa.'</center></td>';
if($row[member] == 0)
{$ma = "No";};
if($row[member] == 1)
{$ma = "Yes";};
print '<td><center>'.$ma.'</center></td>';
if($row[basic] == 0)
{$bma = "No";};
if($row[basic] == 1)
{$bma = "Yes";};
print '<td><center>'.$bma.'</center></td>';
if($row['public'] == 0)
{$pa = "No";};
if($row['public'] == 1)
{$pa = "Yes";};
print '<td><center>'.$pa.'</center></td>
<td align="center">'.$row[views].'</td>
<td align="center">
<a href="?page='.$row[page].'" target="_blank">View</a> | 
<a href="?act=wpcp&action=edit_page&id='.$row[id].'">Edit</a> | 
<a href="?act=wpcp&action=delete_page&id='.$row[id].'">Delete</a>
</td>
</tr>';
};
print '</table>';
};
//CREATE NEW WEB PAGE
if ($action == 'create_new_page'){
title("Create New Web Page");
print '<h1><center>Create New Web Page</center></h1>
<hr width="100%" align="center"/>
<table class="table" align="center"><tr><td>
<form action="?act=wpcp&action=page&set=save_page&set2=create_page" method="post">
Page Title: <input type="text" name="title" />
<br />
URL Key (Set): <input type="text" name="urlkey" />
<br />
Head:
<br />
<textarea name="head" cols="80" rows="10"></textarea>
<br />
CSS:
<br />
<textarea name="css" cols="80" rows="10"></textarea>
<br />
Page Body:
<br />
<textarea name="body" cols="80" rows="10"></textarea>
<br />
Footer:
<br />
<textarea name="footer" cols="80" rows="10"></textarea>
<br />
Group Access List:<br />
<input type="checkbox" name="admin" value="admin" checked=checked disabled=disabled />Administrators<br />
<input type="checkbox" name="member" value="member" />Webmasters<br />
<input type="checkbox" name="member" value="member" />users<br />
<input type="checkbox" name="public" value="public" />Public<br />
<br />
Password: <input type="text" name="password" value="'.$row[password].'"/><br />
Leave blank for NO password<br />
<input type="submit" value="Create New Page" />
</form>
</td></tr></table>';
};
//EDIT WEB PAGE
if ($action == 'edit_page'){
title("Edit Web Page");
if ($id != ''){
$selectpage = mysql_query("SELECT * FROM `pages` WHERE `id` = '$id' AND `username` = '$username'") or die (mysql_error());
while ($row = mysql_fetch_array($selectpage)){
if($row[member] == 1){
$membercheckboxchecked = 'checked="checked" /';};
if($row[member] == 0){
$membercheckboxchecked = '/';};
if($row[basic] == 1){
$basicmembercheckboxchecked = 'checked="checked" /';};
if($row[basic] == 0){
$basicmembercheckboxchecked = '/';};
if($row['public'] == 1){
$publiccheckboxchecked = 'checked="checked"';};
if($row['public'] == 0){
$publiccheckboxchecked = '/';};
print '<h1><center>Edit Web Page</center></h1>
<hr width="100%" align="center"/>
<table class="table" align="center"><tr><td>
<form action="?act=wpcp&action=page&set=save_page&set2=save_edited_page&id='.$row[id].'" method="post">
Page Title: <input type="text" name="title" value="'.$row[page_title].'"/>
<br />
URL Key (Set): <input type="text" name="urlkey" value="'.$row[page].'"/>
<br />
Header:
<br />
<textarea name="head" cols="80" rows="10">'.$row[header].'</textarea>
<br />
CSS:
<br />
<textarea name="css" cols="80" rows="10">'.$row[css].'</textarea>
<br />
Page Body:
<br />
<textarea name="body" cols="80" rows="10">'.$row[body].'</textarea>
<br />
Footer:
<br />
<textarea name="footer" cols="80" rows="10">'.$row[footer].'</textarea>
<br />
Group Access List:<br />
<input type="checkbox" name="admin" value="admin" checked=true disabled=true />Administrators<br />
<input type="checkbox" name="member" value="member" '.$membercheckboxchecked.'>Members<br />
<input type="checkbox" name="member" value="member" '.$basicmembercheckboxchecked.'>Basic Members<br />
<input type="checkbox" name="public" value="public" '.$publiccheckboxchecked.'>Public<br />
<br />
Password: <input type="text" name="password" value="'.$row[password].'"/><br />
Leave blank for NO password<br />
<input type="submit" value="Submit Edited Page" />
</form>
</td></tr></table>';
};};};
//DELETE WEB PAGE
if ($action== 'delete_page'){
title("Delete Web Page");
if ($id != ''){
$select_kill = mysql_query("SELECT * FROM `pages` WHERE `id` = '$id' AND username = '$username'");
while ($row = mysql_fetch_array($select_kill)){
print '<h1><center>Delete Web Page</center></h1>
<hr width="100%" align="center"/>
<table class="table" align="center">
<tr><td>
<strong>Title:</strong> '.$row['page_title'].'<br />
<strong>URL Key:</strong> '.$row['set'].'<br />
<strong>Views:</strong> '.$row['views'].'<br />
<strong>Header:</strong><br />
'.$row['header'].'<br /><br />
<strong>CSS:</strong><br />
'.$row['css'].'<br /><br />
<strong>Page Body:</strong><br />
'.$row['body'].'<br /><br />
<strong>Footer:</strong><br />
'.$row['footer'].'
</td></tr>
</table>
<table class="table" align="center">
<tr><td>
<strong>Are you sure you want to delete this page?</strong><br />
<form action="?act=wpcp&action=page&set=delete&id='.$row[id].'" method="post">
<input type="submit" value="Yes" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="button" onclick="history.go(-1)" value="No" />
</form>
</td></tr>
</table>';
};
}else{print 'DOES NOT EXIST';};//if ($id != '')
};
};
}//if($_SESSION[is_online] == 1)
else{
redirect("?act=logout");
};
};
?>
