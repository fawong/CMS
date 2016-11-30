<?php
require_once('functions.php');

title("Posts");
page_header("Posts");

foreach ($db->get_results("SELECT * FROM posts ORDER BY id DESC") as $post) {
?>
<h2><?php print $post->title ?></h2>
<strong>Posted author:</strong> <a href="profile.php?action=view&amp;id=<?php print $post->author_id ?>"><?php print id2username($post->author_id) ?></a>
<br />
<strong>Post date:</strong> <?php print timestamp2date($post->timestamp) ?>
<p><?php print $post->post ?></p>
<?php
    if ($settings['comments'] == 1) {
?>
<a href="comments.php?action=view_comments&amp;id=<?php print $post->id ?>">View Comments</a>
<?php
        if ($group_id == 1 || $group_id == 2) {
?>
<br />
<a href="comments.php?action=add_comments&amp;id=<?php print $post->id ?>">Add Comments</a>
<?php
        };
        if ($group_id == 1) {
?>
<br /><br />
<a href="admin/posts.php?action=edit_post&amp;id=<?php print $post->id ?>">Edit Post</a>
<br />
<a href="admin/posts.php?action=delete_post&amp;id=<?php print $post->id ?>">Delete Post</a>
<?php
        };
    };
};
require_once('footer.php');
?>
