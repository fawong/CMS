<?php
//VIEW COMMENTS
if ($act == 'comments') {
if ($act2 == 'view_comments'){
title("View Comments");
$select_story = mysql_query("SELECT * FROM `news_updates` WHERE `id` = '$id'") or die(mysql_error());
while ($row = mysql_fetch_array($select_story)){
print '<center><h1>View Comments</h1></center>
<hr width="100%" align="center" />
<table class="table" align="center">
<tr><td>
<div align="center">
<font size="+2"><strong>'.$row[title].'</strong></font><br />
<font size="+1"><strong>Posted by: <a href="index.php?act=profile&amp;act2=view&amp;username='.$row[username].'">'.$row[username].'</a>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Date: '.$row[date].'</strong></font>
</div>
</td></tr>
<tr><td><div align="center">'.$row[post].'</div></td></tr>
</table>';
};//while ($row = mysql_fetch_array($select_story))
print '<hr width="100%" align="center" />
<center><font size="+2"><strong>Comments</strong></font></center>
<hr width="100%" align="center" />';
$select_comment = mysql_query("SELECT * FROM news_comments WHERE `news_id` = '$id'") or die(mysql_error());;
$count = 1;
if(mysql_num_rows($select_comment) == 0){
print '<center><strong>There are no comments for this post.</strong></center>';
}//if(mysql_num_rows($select_comment) == 0)
else{
while($row = mysql_fetch_array($select_comment)){
$post = wordwrap($row[comment], "100%", "<br />\n", false);
if ($_SESSION['group'] == 'admin'){
$admin = '<div align="center">
<a href="index.php?act=admin&amp;act2=edit_comment&amp;id='.$row[id].'">Edit Comment</a> &mdash;
<a href="index.php?act=admin&amp;act2=delete_comment&amp;id='.$row[id].'">Delete Comment</a>
</div>';
};
print '
<table class="table" width="100%"><tr><td>
<div align="center"><div class="h1">
<strong>Comment # '.$count.'</strong>&nbsp;&nbsp;&nbsp;&nbsp;
<strong>Author Username:</strong> <a href="index.php?act=profile&amp;act2=view&amp;username='.$row[username].'">'.$row[username].'</a>
&nbsp;&nbsp;&nbsp;&nbsp;
<strong>Date:</strong> '.$row[date].'</div></div></td></tr>
<tr><td><div align="center">'.$post.'</div>'.$admin.'</td></tr>
</table><br />';
$count++;
};//while($row = mysql_fetch_array($select_comment))
};//else
};//if ($act2 == 'view_comments')
//ADD COMMENTS
if ($act2 == 'add_comments'){
// ADD POSTED COMMENT
if ($act22== 'post_comment'){
if ($_POST['comment'] != ''){
$insert_query = mysql_query("INSERT INTO `news_comments` (`news_id`, `username`, `date`, `comment`) VALUES ('$_POST[news_id]', '$_SESSION[username]', '$current_date', '$_POST[comment]')") or die (mysql_error());
print '<strong>Comment Edited and Saved.</strong>';
$id = $_POST['news_id'];
}
else{
redirect("index.php?act=failed&amp;id=1");
};
};
title("Add Comments");
$select_story = mysql_query("SELECT * FROM `news_updates` WHERE `id` = '$id'");
while ($row = mysql_fetch_array($select_story)){
print '<center><h1>Add New Comment</h1></center>
<hr width="100%" align="center" />
<table class="table" align="center">
<tr><td>
<div align="center">
<font size="+2"><strong>'.$row[title].'</strong></font><br />
<font size="+1"><strong>Posted by: <a href="index.php?act=profile&amp;act2=view&amp;username='.$row[username].'">'.$row[username].'</a>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Date: '.$row[date].'</strong></font>
</div>
</td></tr>
<tr><td>
<div align="center">'.$row[post].'</div>
</td></tr>
</table>';
};
print '<hr width="100%" align="center" />';
if ($_SESSION['login'] != true){
print '<strong>ERROR</strong>';
};
if ($_SESSION['login'] == true){
print '<table class="table" align="center">
<tr><td>
<form action="index.php?act=add_comments&amp;act2=post_comment" method="post">
<h1><div align="center">Add Comment</div></h1>
<input type="hidden" name="news_id" value="'.$id.'" />
<textarea name="comment" cols="50" rows="10"></textarea><br />
<input type="submit" value="Submit" /></form>
</td></tr>
</table>';
};
};
};
?>
