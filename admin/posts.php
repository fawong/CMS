<?php 
require_once(dirname(dirname(__FILE__)) . '/functions.php');

if($_SESSION['group'] != 'admin') {
    redirect("failed.php?id=2");
} else {
    // ADD NEW POST
    if($action == 'post') {
        title("Add New Post");
        if($set == 'submit') {
            if($_POST['post'] != '') {
                $insert_query = mysql_query("INSERT INTO `posts`(`title`, `username` , `date` , `post`) VALUES('$_POST[title]', '$username', '$current_date', '$_POST[post]')") or die(mysql_error());
                print '<strong>New Post Added.</strong>';
            };
        };
?>
        print '<h1><center>Add New Post</center></h1>
            <hr width="100%"/>
            <table class="table"><tr><td>
            <form action="?act=admin&amp;action=post&amp;set=submit" method="post">
            Title: <input name="title" type="text" /><br />
            Date: <?php print $current_date ?><br />
            Poster: <?php print $_SESSION['username'] ?><br />
            Post:<br />
            <textarea name="post" rows="10" cols="60">
            </textarea><br />
            <input type="submit" value="Submit" name="Submit" />
            </form>
            </td></tr></table>';
<?php
    };

    // SUBMIT EDIT POST
    if($action == 'submit_edit_post') {
        if($id != '') {
            $update_post = mysql_query("UPDATE `posts` SET `title` = '$_POST[title]', `post` = '$_POST[post]' WHERE `id` ='$id'") or die(mysql_error());
            page_header('Post Saved');
?>
Post edited and saved.
<?php
        } else {
            page_header('No Post ID given');
?>
No post ID given.
<?php
        };
    };

    // EDIT POST
    if($action == 'edit_post') {
        title("Edit Post");
        $post_select = mysql_query("SELECT * FROM posts WHERE id ='$id'");
        while($row = mysql_fetch_array($post_select)) {
            page_header('Edit Post');
?>
<form action="?action=submit_edit_post&amp;id=<?php print $id ?>" method="post">
<div class="form-group">
<label>Title:</label>
<input name="title" type="text" class="form-control" value="<?php print $row['title'] ?>" />
</div>
<div class="form-group">
<label>Date:</label>
<?php print $row['date'] ?>
</div>
<div class="form-group">
<label>Poster:</label>
<?php print $row['username'] ?>
</div>
<div class="form-group">
<label>Post:</label>
<textarea name="post" class="form-control"><?php print $row[post] ?></textarea>
</div>
<button type="submit" class="btn btn-primary btn-lg">Submit</button>
</form>
<?php
        };
    };

    //DELETE POST
    if($action == 'delete_post') {
        title("Delete Post");
        if($id != '') {
            if($set == 'delete') {
                $delete_comments = mysql_query("DELETE FROM comments WHERE id = '$id'");
                $delete_query = mysql_query("DELETE FROM posts WHERE id = '$id'");
                print '<strong>Post Deleted.</strong>';
            };
            $post_select = mysql_query("SELECT * FROM posts WHERE id =$id");
            while($row = mysql_fetch_array($post_select)) {
                print '<h1><center>Delete Post</center></h1>
                    <hr width="100%"/>
                    <table class="table">
                    <tr><td>
                    <div>
                    <font size="+2"><strong><?php print $row[title] ?></strong></font><br />
                    <font size="+1"><strong>Posted by: <a href="?act=profile&amp;action=view&amp;username=<?php print $row[username] ?>"><?php print $row[username] ?></a>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Date: <?php print $row[date] ?></strong></font>
                    </div>
                    </td></tr>
                    <tr><td><div align="left"><?php print $row[post] ?></div></td></tr>
                    </table>
                    <hr width="100%"/>
                    <table class="table">
                    <tr><td>
                    <strong>Are you sure you want to delete this post?</strong><br />
                    <form action="?act=admin&amp;action=delete_post&amp;set=delete&amp;id=<?php print $row[id] ?>" method="post">
                    <input type="submit" value="Yes" /><input type="button" onclick="history.go(-1)" value="No" />
                    </form>
                    </table>';
            };
        } else {
            print 'YOU HAVE FAILED';
        };
    };
};
require_once(dirname(dirname(__FILE__)) . '/footer.php');
?>
