<?php
require_once('functions.php');

if ($action == 'view_comments') {
    title("View Comments");
    $select_story = mysql_query("SELECT * FROM `news_updates` WHERE `id` = '$id'") or die(mysql_error());
    while ($row = mysql_fetch_array($select_story)) {
        page_header('View Comments');
?>
                <h2><?php print $row['title'] ?></h2>
                <br />
                <strong>Posted by: <a href="?act=profile&amp;action=view&amp;username=<?php print $row['username'] ?>"><?php print $row['username'] ?></a>
                <br />
                Date: <?php print $row[date] ?></strong>
                <p><?php print $row[post] ?></p>
<?php
    }; //while ($row = mysql_fetch_array($select_story))
?>
            <h3>Comments</h3>
<?php
    $select_comment = mysql_query("SELECT * FROM news_comments WHERE `news_id` = '$id'") or die(mysql_error());;
    $count = 1;
    if(mysql_num_rows($select_comment) == 0) {
?>
            <strong>There are no comments for this post.</strong>
<?php
    } //if(mysql_num_rows($select_comment) == 0)
    else{
        while($row = mysql_fetch_array($select_comment)) {
            $post = wordwrap($row['comment'], "100%", "<br />\n", false);
?>
<h4>Comment # <?php print $count ?></h4>
<p><strong>Post author:</strong> <a href="?act=profile&amp;action=view&amp;username=<?php print $row['username'] ?>"><?php print $row['username'] ?></a></p>
<p><strong>Date:</strong> <?php print $row[date] ?></p>
<p><?php print $post ?></p>
<?php
            if ($_SESSION['group'] == 'admin') {
?>
                    <a href="?act=admin&amp;action=edit_comment&amp;id=<?php print $row['id'] ?>">Edit Comment</a> &mdash;
                    <a href="?act=admin&amp;action=delete_comment&amp;id=<?php print $row['id'] ?>">Delete Comment</a>
<?php
            };
            $count++;
        }; //while($row = mysql_fetch_array($select_comment))
    }; //else
}; //if ($action == 'view_comments')
//ADD COMMENTS
if ($action == 'add_comments') {
    // ADD POSTED COMMENT
    if ($action == 'post_comment') {
        if ($_POST['comment'] != '') {
            $insert_query = mysql_query("INSERT INTO `news_comments` (`news_id`, `username`, `date`, `comment`) VALUES ('$_POST[news_id]', '$username', '$current_date', '$_POST[comment]')") or die (mysql_error());
            print '<strong>Comment Edited and Saved.</strong>';
            $id = $_POST['news_id'];
        }
        else{
            redirect("failed.php?amp;id=1");
        };
    };
    title("Add Comments");
    $select_story = mysql_query("SELECT * FROM `news_updates` WHERE `id` = '$id'");
    while ($row = mysql_fetch_array($select_story)) {
        print '<center><h1>Add New Comment</h1></center>
            <hr width="100%" align="center" />
            <table class="table" align="center">
            <tr><td>
            <div align="center">
            <font size="+2"><strong>'.$row[title].'</strong></font><br />
            <font size="+1"><strong>Posted by: <a href="?act=profile&amp;action=view&amp;username='.$row['username'].'">'.$row['username'].'</a>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Date: '.$row[date].'</strong></font>
            </div>
            </td></tr>
            <tr><td>
            <div align="center">'.$row[post].'</div>
            </td></tr>
            </table>';
    };
    print '<hr width="100%" align="center" />';
    if ($_SESSION['login'] != true) {
        print '<strong>ERROR</strong>';
    };
    if ($_SESSION['login'] == true) {
        print '<table class="table" align="center">
            <tr><td>
            <form ="?action=?act=add_comments&amp;action=post_comment" method="post">
            <h1><div align="center">Add Comment</div></h1>
            <input type="hidden" name="news_id" value="'.$id.'" />
            <textarea name="comment" cols="50" rows="10"></textarea><br />
            <input type="submit" value="Submit" /></form>
            </td></tr>
            </table>';
    };
};
require_once('footer.php');
?>
