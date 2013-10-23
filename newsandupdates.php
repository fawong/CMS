<?php
session_start();
//NEWS AND UPDATES
if ($act == ''){
    title("News and Updates");
    if ($set == ''){
        page_header("News and Updates");
        $news_sql = mysql_query("SELECT * FROM news_updates ORDER BY id DESC");
        while ($row = mysql_fetch_array($news_sql)) {
?>
<h2><?php print $row['title'] ?></h2>
Posted by: <a href="index.php?act=profile&amp;act2=view&amp;username=<?php print $row['username'] ?>"><?php print $row['username'] ?></a>
<br />
Date: <?php print $row['date'] ?>
<p><?php print $row['post'] ?></p>
<?php
            if ($_SESSION['group'] == 'admin') {
?>
<br />
<div align="center">
<a href="index.php?act=admin&amp;act2=edit_post&amp;id='.$row[id].'">Edit Post</a> &mdash;
<a href="index.php?act=admin&amp;act2=delete_post&amp;id='.$row[id].'">Delete Post
</a>
<?php
            };
            if ($settings['comments'] == 1){
                if ($_SESSION['group'] == 'public') {
?>
    <a href="index.php?act=comments&amp;act2=view_comments&amp;id=<?php print $row['id'] ?>">View Comments</a>
<?php
                };
                if ($_SESSION['group'] == 'admin' || $_SESSION['group'] == 'member' || $_SESSION['group'] == 'basic') {
                    print '<tr><td>
                        <div align="center"><a href="index.php?act=comments&amp;act2=add_comments&amp;id='.$row[id].'">Add Comments</a> &mdash;
                    <a href="index.php?act=comments&amp;act2=view_comments&amp;id='.$row[id].'">View Comments</a>
                        </div>
                        <br /><br />
                        </td></tr>';
                };
            };
        };
    };//if ($set == '')
};//if ($act == '')
?>
