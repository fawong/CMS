<?php
require_once('functions.php');

// VIEW COMMENTS
if ($get_action == 'view_comments') {
    title("View Comments");
    if ($post = $db->get_row("SELECT * FROM `posts` WHERE `id` = '$get_id'")) {
        page_header('View Comments');
?>
<h2><?php print $post->title ?></h2>
<br />
<strong>Post author:</strong> <a href="?act=profile&amp;action=view&amp;username=<?php print $post->username ?>"><?php print $post->username ?></a>
<br />
<strong>Post date:</strong> <?php print timestamp2date($post->timestamp) ?>
<p><?php print $post->post ?></p>
<?php
    };
?>
<h3>Comments</h3>
<?php
    $count = 1;
    if ($comments = $db->get_results("SELECT * FROM comments WHERE `post_id` = '$get_id'")) {
        foreach ($comments as $comment) {
?>
<h4>Comment # <?php print $count ?></h4>
<p><strong>Comment author:</strong> <a href="?act=profile&amp;action=view&amp;username=<?php print $comment->post_author ?>"><?php print $comment->post_author ?></a></p>
<p><strong>Comment date:</strong> <?php print timestamp2date($comment->timestamp) ?></p>
<p><?php print $comment->comment ?></p>
<?php
            if ($group == 1) {
?>
<a href="admin/comments.php?action=edit_comment&amp;id=<?php print $comment->id ?>">Edit Comment</a>
<br />
<a href="admin/comments.php?action=delete_comment&amp;id=<?php print $comment->id ?>">Delete Comment</a>
<?php
            };
            $count++;
        };
    } else {
?>
<strong>There are no comments for this post.</strong>
<?php
    };
};

if ($login != true && $get_action != 'view_comments') {
    redirect('failed.php?id=2');
} else {
    // ADD POSTED COMMENT
    if ($get_action == 'post_comment') {
        if ($_POST['comment'] != '') {
            $db->query("INSERT INTO `comments` (`post_id`, `post_author`, `comment`) VALUES ('" . $_POST['id'] . "', '$username', '" . $_POST['comment'] . "')");
            page_header('Comment Saved');
?>
Comment Edited and Saved.
<?php
        } else {
            page_header('Comment Empty');
?>
Comment is empty.
<?php
        };
    };

    // ADD COMMENTS
    if ($get_action == 'add_comments') {
        title("Add Comments");
        page_header('Add New Comment');
        if ($post = $db->get_row("SELECT * FROM `posts` WHERE `id` = '$get_id'")) {
?>
<h2><?php print $post->title ?></h2>
<p><strong>Posted by:</strong> <a href="profile.php?action=view&amp;username=<?php print $post->username ?>"><?php print $post->username ?></a></p>
<p><strong>Date:</strong> <?php print $post->date ?></p>
<p><?php print $post->post ?></p>

<form action="?action=post_comment" method="post">
<input type="hidden" name="id" value="<?php print $get_id ?>" />
<textarea name="comment" class="form-control"></textarea>
<button type="submit" class="btn btn-lg btn-primary">Submit</button>
</form>
<?php
        };
    };
};
require_once('footer.php');
?>
