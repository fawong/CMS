<?php 
require_once(dirname(dirname(__FILE__)) . '/functions.php');

if ($group != 1) {
    redirect("failed.php?id=2");
} else {
    // SUBMIT NEW POST
    if ($get_action == 'submit_new_post') {
        if ($_POST['post'] != '') {
            $db->query("INSERT INTO `posts`(`title`, `username`, `post`) VALUES ('$_POST[title]', '$username', '$_POST[post]')");
            page_header('New Post Added');
?>
New Post Added.
<?php
        };
    };

    // ADD NEW POST
    if ($get_action == 'new_post') {
        title("Add New Post");
        page_header('Add New Post');
?>
<form action="?action=submit_new_post" method="post">
<div class="form-group">
<label>Title:</label>
<input name="title" type="text" class="form-control" />
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
    if ($get_action == 'submit_edit_post') {
        if ($get_id != '') {
            $db->query("UPDATE `posts` SET `name` = '$_POST[title]', `post` = '$_POST[post]' WHERE `id` ='$get_id'");
            $db->debug();
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
    if ($get_action == 'edit_post') {
        title("Edit Post");
        $post = $db->get_row("SELECT * FROM posts WHERE id = '$get_id'");
        page_header('Edit Post');
?>
<form action="?action=submit_edit_post&amp;id=<?php print $post->id ?>" method="post">
<div class="form-group">
<label>Title:</label>
<input name="title" type="text" class="form-control" value="<?php print $post->name ?>" />
</div>
<div class="form-group">
<label>Post date:</label>
<?php print timestamp2date($post->timestamp) ?>
</div>
<div class="form-group">
<label>Post author:</label>
<?php print id2username($post->author_id) ?>
</div>
<div class="form-group">
<label>Post content:</label>
<textarea name="post" class="form-control"><?php print $post->post ?></textarea>
</div>
<button type="submit" class="btn btn-primary btn-lg">Submit</button>
</form>
<?php
    };

    // SUBMIT DELETE POST
    if ($get_action == 'submit_delete_post') {
        if ($get_id != '') {
            $db->query("DELETE FROM comments WHERE id = '$get_id'");
            $db->query("DELETE FROM posts WHERE id = '$get_id'");
            page_header('Post Deleted');
?>
Post Deleted.
<?php
        } else {
            page_header('Post Not Deleted');
            $db->debug();
        };
    };

    // DELETE POST
    if ($get_action == 'delete_post') {
        title("Delete Post");
        $post = $db->get_row("SELECT * FROM posts WHERE id = $get_id");
        page_header('Delete Post');
?>
<h2><?php print $post->title ?></h2>
<p><strong>Post author:</strong> <a href="?username=<?php print $post->username ?>"><?php print $post->username ?></a>
<p><strong>Post date:</strong> <?php print timestamp2date($post->timestamp) ?></p>
<p><?php print $post->post ?></p>
<h3>Are you sure you want to delete this post?</h3>
<form action="?action=submit_delete_post&amp;id=<?php print $post->id ?>" method="post">
<button type="submit" class="btn btn-lg btn-primary">Yes</button>
<button type="button" class="btn btn-lg" onclick="history.go(-1)">No</button>
</form>
<?php
    };
};
require_once(dirname(dirname(__FILE__)) . '/footer.php');
?>
