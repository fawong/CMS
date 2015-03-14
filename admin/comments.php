<?php 
require_once(dirname(dirname(__FILE__)) . '/functions.php');

if($group_id != 1) {
    redirect("failed.php?id=2");
} else {
    // CONFIRM DELETE COMMENT
    if ($get_action == 'confirm_delete_comment') {
        if ($get_id != '') {
            title("Comment Deleted");
            $db->query("DELETE FROM comments WHERE id = '$get_id'");
            page_header('Comment Successfully Deleted');
?>
Comment successfully deleted.
<?php
        } else {
            page_header('Comment Not Deleted');
            $db->debug();
        };
    };

    // DELETE COMMENT
    if ($get_action == 'delete_comment') {
        title("Delete Comment");
        page_header('Delete Comment');
        $comment = $db->get_row("SELECT * FROM comments WHERE id = $get_id");
?>
<p><strong>Comment author</strong> <a href="?profile.php?action=view&amp;username=<?php print $comment->post_author ?>"><?php print $comment->post_author ?></a></p>
<p><strong>Comment date:</strong> <?php print timestamp2date($comment->timestamp) ?></p>
<p><?php print $comment->comment ?></p>
<h3>Are you sure you want to delete this comment?</h3>
<form action="//<?php print $settings['url'] ?>/admin/comments.php?action=confirm_delete_comment&amp;id=<?php print $comment->id ?>" method="post">
<button type="submit" class="btn btn-lg btn-primary">Yes</button>
<button type="button" class="btn btn-lg" onclick="history.go(-1)">No</button>
</form>
<?php
    };

    // EDIT COMMENT
    if ($get_action == 'edit_comment') {
        title("Edit Comment");
        page_header('Edit Comment');
        $comment = $db->get_row("SELECT * FROM `comments` WHERE id = $get_id");
?>
<form action="?action=submit_edit_comment&amp;id=<?php print $comment->id ?>" method="post">
<div class="form-group">
<label>Comment date:</label>
<?php print timestamp2date($comment->timestamp) ?>
</div>
<div class="form-group">
<label>Comment author:</label>
<?php print $comment->post_author ?>
</div>
<div class="form-group">
<label>Comment content:</label>
<textarea name="comment" class="form-control"><?php print $comment->comment ?></textarea>
</div>
<button type="submit" class="btn btn-primary btn-lg">Submit</button>
</form>
<?php
    };

    // SUBMIT EDIT COMMENT
    if ($get_action == 'submit_edit_comment') {
        if ($get_id != '') {
            title("Comment Updated");
            $db->query("UPDATE `comments` SET `comment` = '$_POST[comment]' WHERE id = '$get_id'");
            page_header('Comment Successfully Updated');
?>
Comment successfully updated.
<?php
        } else {
            page_header('Comment Not Updated');
            $db->debug();
        };
        };
};
require_once(dirname(dirname(__FILE__)) . '/footer.php');
?>
