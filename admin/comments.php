<?php 
require_once(dirname(dirname(__FILE__)) . '/functions.php');

if($group != 'admin') {
    redirect("failed.php?id=2");
} else {
    if ($action == 'confirm_delete_comment') {
        title("Comment Deleted");
        $delete_comment = mysql_query("DELETE FROM comments WHERE id = '$id'") or die(mysql_error());
        page_header('Comment Successfully Deleted');
?>
Comment Successfully Deleted.
<?php
    };
    if ($action == 'delete_comment') {
        title("Delete Comment");
        $post_select = mysql_query("SELECT * FROM comments WHERE id =$id");
        page_header('Delete Comment');
        while($row = mysql_fetch_array($post_select)) {
?>
<p><strong>Posted by:</strong> <a href="?profile.php?action=view&amp;username=<?php print $row['post_author'] ?>"><?php print $row['post_author'] ?></a></p>
<p><strong>Date:</strong> <?php print $row['date'] ?></p>
<?php print $row['comment'] ?>
<h3>Are you sure you want to delete this comment?</h3>
<form action="//<?php print $settings['url'] ?>/admin/comments.php?action=confirm_delete_comment&amp;id=<?php print $row['id'] ?>" method="post">
<button type="submit" class="btn btn-lg btn-primary">Yes</button>
<button type="button" class="btn btn-lg" onclick="history.go(-1)">No</button>
</form>
<?php
        };
    };
    if ($action == 'edit_comment') {
        title("Edit Comment");
        page_header('Edit Comment');
?>
Coming soon
<?php
    };
};
require_once(dirname(dirname(__FILE__)) . '/footer.php');
?>
