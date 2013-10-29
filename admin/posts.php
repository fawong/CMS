<?php 
require_once(dirname(dirname(__FILE__)) . '/functions.php');

if($_SESSION['group'] != 'admin') {
    redirect("failed.php?id=2");
} else {
    // SUBMIT NEW POST
    if($action == 'submit_new_post') {
        if($_POST['post'] != '') {
            $insert_query = mysql_query("INSERT INTO `posts`(`title`, `username`, `post`, `date`) VALUES('$_POST[title]', '$username', '$_POST[post]', '$timestamp')") or die(mysql_error());
            page_header('New Post Added');
?>
New Post Added.
<?php
        };
    };

    // ADD NEW POST
    if($action == 'new_post') {
        title("Add New Post");
        page_header('Add New Post');
?>
<form action="?action=submit_new_post" method="post">
<div class="form-group">
<label>Title:</label>
<input name="title" type="text" class="form-control" />
</div>
<div class="form-group">
<label>Date:</label>
<?php print $timestamp ?>
</div>
<div class="form-group">
<label>Poster:</label>
<?php print $username ?>
</div>
<div class="form-group">
<label>Post:</label>
<textarea name="post" class="form-control"></textarea>
</div>
<button type="submit" class="btn btn-lg btn-primary" name="Submit">Add New Post</button>
</form>
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

    // SUBMIT DELETE POST
    if($action == 'submit_delete_post') {
        if($id != '') {
            $delete_comments = mysql_query("DELETE FROM comments WHERE id = '$id'");
            $delete_query = mysql_query("DELETE FROM posts WHERE id = '$id'");
            page_header('Post Deleted');
?>
Post Deleted.
<?php
        } else {
            print 'YOU HAVE FAILED';
        };
    };

    // DELETE POST
    if($action == 'delete_post') {
        title("Delete Post");
        $post_select = mysql_query("SELECT * FROM posts WHERE id =$id");
        while($row = mysql_fetch_array($post_select)) {
            page_header('Delete Post');
?>
<h2><?php print $row['title'] ?></h2>
<p><strong>Posted by:</strong> <a href="?username=<?php print $row['username'] ?>"><?php print $row[username] ?></a>
<p><strong>Date:</strong> <?php print $row['date'] ?></p>
<p><?php print $row['post'] ?></p>
<h3>Are you sure you want to delete this post?</h3>
<form action="?action=submit_delete_post&amp;id=<?php print $row['id'] ?>" method="post">
<button type="submit" class="btn btn-lg btn-primary">Yes</button>
<button type="button" class="btn btn-lg" onclick="history.go(-1)">No</button>
</form>
<?php
        };
    };
};
require_once(dirname(dirname(__FILE__)) . '/footer.php');
?>
