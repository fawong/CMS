<?php
require_once('functions.php');

// VIEW COMMENTS
if ($action == 'view_comments') {
    title("View Comments");
    $select_story = mysql_query("SELECT * FROM `posts` WHERE `id` = '$id'") or die(mysql_error());
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
    };
?>
            <h3>Comments</h3>
<?php
    $select_comment = mysql_query("SELECT * FROM comments WHERE `post_id` = '$id'") or die(mysql_error());;
    $count = 1;
    if(mysql_num_rows($select_comment) == 0) {
?>
            <strong>There are no comments for this post.</strong>
<?php
    }
    else{
        while($row = mysql_fetch_array($select_comment)) {
            $post = wordwrap($row['comment'], "100%", "<br />\n", false);
?>
<h4>Comment # <?php print $count ?></h4>
<p><strong>Post author:</strong> <a href="?act=profile&amp;action=view&amp;username=<?php print $row['post_author'] ?>"><?php print $row['post_author'] ?></a></p>
<p><strong>Date:</strong> <?php print $row[date] ?></p>
<p><?php print $post ?></p>
<?php
            if ($_SESSION['group'] == 'admin') {
?>
<a href="admin/comments.php?action=edit_comment&amp;id=<?php print $row['id'] ?>">Edit Comment</a>
<br />
<a href="admin/comments.php?action=delete_comment&amp;id=<?php print $row['id'] ?>">Delete Comment</a>
<?php
            };
            $count++;
        };
    };
};

if ($_SESSION['login'] != true && $action != 'view_comments') {
    redirect('failed.php?id=2');
} else {
    // ADD POSTED COMMENT
    if ($action == 'post_comment') {
        if ($_POST['comment'] != '') {
            $insert_query = mysql_query("INSERT INTO `comments` (`post_id`, `post_author`, `comment`) VALUES ('" . $_POST['id'] . "', '$username', '" . $_POST['comment'] . "')") or die (mysql_error());
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
    if ($action == 'add_comments') {
        title("Add Comments");
        $select_story = mysql_query("SELECT * FROM `posts` WHERE `id` = '$id'");
        page_header('Add New Comment');
        while ($row = mysql_fetch_array($select_story)) {
?>
<h2><?php print $row['title'] ?></h2>
<p><strong>Posted by:</strong> <a href="profile.php?action=view&amp;username=<?php print $row['username'] ?>"><?php print $row['username'] ?></a></p>
<p><strong>Date:</strong> <?php print $row['date'] ?></p>
<?php print $row['post'] ?>
<?php
        };
?>
<form action="?action=post_comment" method="post">
<input type="hidden" name="id" value="<?php print $id ?>" />
<textarea name="comment" class="form-control"></textarea>
<button type="submit" class="btn btn-lg btn-primary">Submit</button>
</form>
<?php
    };
};
require_once('footer.php');
?>
