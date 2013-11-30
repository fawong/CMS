<?php 
require_once('functions.php');

$current_folder = 'inbox';
// INBOX
if ($login != true) {
redirect('failed.php?id=3');
} else {
if ($get_action == 'inbox' || $get_action == '') {
title("Inbox");
page_header('Inbox');
?>
<form method="post" action="?act=inbox&amp;action=change_folder">
<p>Current Folder: <?php print $current_folder ?></p>
<p>Total Usage: <?php print total_message() ?> (Used/Maximum)</p>
<p><a href="?act=inbox&amp;action=compose">Compose</a></p>
Change Folder: 
<select name="folder" size="1"> 
<option value="inbox" selected="selected">Inbox</option>
<option value="outbox">Outbox</option>
<option value="drafts">Drafts</option>
<option value="sent">Sent</option>
<option value="trash">Trash</option>
<option value="spam">Spam</option>
</select>
<input type="submit" value="Go!" />
</form>

<table class="table">
<tr>
<td>Number</td>
<td>From</td>
<td>Subject</td>
<td>Date</td>
<td>Options</td>
</tr>
<?php
$count = 1;
foreach ($db->get_results("SELECT * FROM `personal_messages` WHERE `to_user_id` = $user_id") as $message) {
?>
<tr>
<td><?php print $count ?></td>
<?php
foreach (Array('from_user_id', 'subject', 'timestamp') as $field) {
?>
<td><?php $message->mark_read ? '<strong>' : ''?><?php $message->important ? '<strong>' : '' ?><?php print $message->$field ?><?php $message->mark_read ? '<strong>' : ''?><?php $message->important ? '<strong>' : '' ?></td>
<?php
}
?>
<td><a href="?act=inbox&amp;action=read&amp;id='.$message->id].'">Read</a> | <a href="index.php?act=inbox&amp;action=reply&amp;id='.$message->id].'">Reply</a> | <a href="index.php?act=inbox&amp;action=move&amp;id='.$message->id].'">Move</a> | <a href="index.php?act=inbox&amp;action=delete&amp;id='.$message->id].'">Delete</a></td>
</tr>
<?php
$count++;
};
};
print '</table>';
};
if ($get_action == 'read') {
if ($id != '') {
print '<table class="table" align="center"><tr><td>';
while ($row = mysql_fetch_array($read_msg)) {
if ($message->important == '1') {
$priority = '<span class="important">Important</span>';
};
if ($message->important == '0') {
$priority = '<strong>Normal</strong>';
};
print '<strong>Subject:</strong> '.$message->subject.'<br />
<strong>From:</strong> '.$message->from.' <strong>To:</strong> '.$message->to.'<br />
<strong>Date:</strong> '.$message->date.'<br />
<strong>Priority:</strong> '.$priority.'<br />
&nbsp;&nbsp;<a href="?act=inbox&amp;action=reply&amp;id='.$message->id.'">Reply</a> | <a href="index.php?act=inbox&amp;action=move&amp;id='.$message->id.'">Move</a> | <a href="index.php?act=inbox&amp;action=delete&amp;id='.$message->id.'">Delete</a><br /><br /></td>
</tr>
<tr><td>'.$message->text.'</td>';
};
print '</tr></table>';
};
};
if ($get_action == 'reply') {
if ($id != '') {
if ($group == 1) {
$admin_check = 'Important: <input type="text" value="0" name="admin"><br />';
};
print '<table class="table" width="100%"><tr><td>';
while ($row = mysql_fetch_array($find_un_msg)) {
print '<form method="post" action="?act=inbox&amp;action=reply_to">
To: <input type="text" name="to" value="'.$message->username.'" /><br />
Subject: <input type="text" name="subject" value="RE: '.$message->subject.' " /><br />
Body:<br />
<textarea name="body" rows="10" cols="50"><quote>'.$message->text.'</quote></textarea><br /><br /><br />
'.$admin_check.'
<input type="submit" value="Send Message" name="submit" />
</form>';
};
print '</td></tr></table>';
};
};
if ($get_action == 'reply_to') {
if ($group == 1) {
if ($_POST['admin'] == '1') {
$admin = 1;
};
if ($_POST['admin'] == '0') {
$admin = 0;
};
};
if ($group != 1) {
$admin = 0; 
};
print '<strong><center>Message Sent!</center></strong>';
};
if ($get_action == 'compose') {
if ($group == 1) {
$admin_check = 'Important: <input type="text" value="0" name="admin"><br />';
};
print '<table class="table" align="center"><tr><td>
<form method="post" action="?act=inbox&amp;action=reply_to">
To: <input type="text" name="to" value="" /><br />
Subject: <input type="text" name="subject" value="" /><br />
Body:<br />
<textarea name="body" rows="10" cols="50"></textarea><br />
'.$admin_check.' <input type="hidden" value="100" name="set">
<input type="submit" value="Send Message" name="submit" />
</form>
</td></tr></table>';
};
if ($get_action == 'delete') {
if ($id != '') {
if ($_POST[set] == 'delete') {
print '<strong>Message has been deleted.</strong></table>';
};
if (!isset($_POST[set])) {
print '<strong>Are you sure you want to delete this message?</strong>';
print '<table class="table" align="center"><tr><td>';
while ($row = mysql_fetch_array($read_msg)) {
if ($message->important == '1') {
$priority = '<span class="important">Important</span>';
};
if ($message->important == '0') {
$priority = 'Normal';
};
print '<strong>Subject:</strong> '.$message->subject.'<br />
<strong>From:</strong> '.$message->from.'<br />
<strong>To:</strong> '.$message->to.'<br />
<strong>Date:</strong> '.$message->date.'<br />
<strong>Priority:</strong> '.$priority.'<br />
<strong>Message:</strong> '.$message->text.'';
};
print '<form action="?act=inbox&amp;action=delete&amp;id='.$id.'" method="post">
<input type="hidden" name="set" value="delete">
<input type="submit" value="Yes, Delete this message" />
</form>
</td></tr></table>';
};
};
};
if($get_action == 'change_folder') {
print '<center>not implemented yet</center>';
};
require_once('footer.php');
?>
