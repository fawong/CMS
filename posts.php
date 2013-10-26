<?php
require_once('functions.php');

title("News and Updates");
page_header("News and Updates");
$sql = mysql_query("SELECT * FROM posts ORDER BY id DESC");
while ($row = mysql_fetch_array($sql)) {
?>
<h2><?php print $row['title'] ?></h2>
Posted by: <a href="?act=profile&amp;action=view&amp;username=<?php print $row['post_author'] ?>"><?php print $row['username'] ?></a>
<br />
Date: <?php print $row['date'] ?>
<p><?php print $row['post'] ?></p>
<?php
    if ($settings['comments'] == 1) {
?>
<a href="comments.php?action=view_comments&amp;id=<?php print $row['id'] ?>">View Comments</a>
<?php
        if ($_SESSION['group'] == 'admin' || $_SESSION['group'] == 'member') {
?>
<br />
<a href="comments.php?action=add_comments&amp;id=<?php print $row['id'] ?>">Add Comments</a>
<?php
        };
        if ($_SESSION['group'] == 'admin') {
?>
<br /><br />
<a href="?act=admin&amp;action=edit_post&amp;id=<?php print $row['id'] ?>">Edit Post</a>
<br />
<a href="?act=admin&amp;action=delete_post&amp;id=<?php print $row['id'] ?>">Delete Post</a>
<?php
        };
    };
};
require_once('footer.php');
?>
