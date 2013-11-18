<?php
require_once('functions.php');

title("Posts");
page_header("Posts");
foreach ($db->get_results("SELECT * FROM posts ORDER BY id DESC") as $post) {
?>
<h2><?php print $post->title ?></h2>
Posted by: <a href="?act=profile&amp;action=view&amp;username=<?php print $post->post_author ?>"><?php print $post->username ?></a>
<br />
Post date: <?php print timestamp2date($post->timestamp) ?>
<p><?php print $post->post ?></p>
<?php
    if ($settings['comments'] == 1) {
?>
<a href="comments.php?action=view_comments&amp;id=<?php print $post->id ?>">View Comments</a>
<?php
        if ($_SESSION['group'] == 'admin' || $_SESSION['group'] == 'member') {
?>
<br />
<a href="comments.php?action=add_comments&amp;id=<?php print $post->id ?>">Add Comments</a>
<?php
        };
        if ($_SESSION['group'] == 'admin') {
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
