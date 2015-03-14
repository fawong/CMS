<?php
include_once('functions.php');

if ($get_action == '') {
    if ($get_id) {
        $page = $db->get_row("SELECT * FROM `pages` WHERE `id` = '$get_id'");
    } else {
        $page = $db->get_row("SELECT * FROM `pages` WHERE `page_name` = '$get_page'");
    }

    if ($page) {
        $db->query("UPDATE `pages` SET `views` = `views` + 1 WHERE `id` = $get_id");
        $password = $page->password;
        if ($page->public == 1 || $group_id == 1) {
            if ($password == '') {
                title($page->page_title);
                page_header($page->page_title);
?>
<p><?php print $page->header ?></p>
<p><?php print $page->body ?></p>
<p><?php print $page->footer ?></p>
<?php
                if ($group_id == 1) {
?>
<a href="//<?php print $settings['url'] ?>/admin/page.php?action=edit_page&amp;id=<?php print $page->id ?>">Edit</a>
<br />
<a href="//<?php print $settings['url'] ?>/admin/page.php?action=delete_page&amp;id=<?php print $page->id ?>">Delete</a>
<?php
                }
            } else {
?>
<form method="page" action="?page=<?php print $page ?>">
<p>This page is password protected.</p>
<p>You must enter a password to proceed.</p>
<div class="form-group">
<label>Password:</label>
<input type="password" name="pass" />
</div>
<button type="submit" class="btn btn-lg btn-primary">Submit</button>
</form>
<?php
            };
        } else {
            http_response_code(404);
            page_header('Page Does Not Exist');
?>
The page you are looking for does not exist.
<?php
        };
    } else {
        redirect("failed.php?id=3");
    };
};
include_once('footer.php');
?>
