<?php 
require_once(dirname(dirname(__FILE__)) . '/functions.php');

if ($group != 1) {
    redirect('failed?id=2');
} else {
    if ($get_action == 'page') {
        title("Page Control Panel");
        page_header('Page Control Panel');
        $pages = $db->get_results("SELECT * from `pages` ORDER BY `page_name`");
?>
<p>Total number of pages: <?php print $db->num_rows ?></p>
<p><a href="?act=admin&amp;action=create_page">Add a New Page</a></p>

<table class="table" width="100%" >
<tr>
<td><strong>ID</strong></td>
<td><strong><center>Page Title</center></strong></td>
<td><strong>URL Key</strong></td>
<td><strong>Administrator Access</strong></td>
<td><strong>Member Access</strong></td>
<td><strong>Public Access</strong></td>
<td><strong>Views</strong></td>
<td><strong>View | Edit | Delete</strong></td>
</tr>
<?php
        foreach ($pages as $page) {
?>
<tr>
<td><?php print $page->id ?></td>
<td><?php print $page->page_title ?></td>
<td><?php print $page->page_name ?></td>
<td><center><?php print $page->admin ? 'Yes' : 'No' ?></center></td>
<td><center><?php print $page->member ? 'Yes' : 'No' ?></center></td>
<td><center><?php print $page->public ? 'Yes' : 'No' ?></center></td>
<td><?php print $page->views ?></td>
<td>
<a href="//<?php print $settings['url'] ?>/page.php?id=<?php print $page->id ?>" target="_blank">View</a> | 
<a href="?action=edit_page&amp;id=<?php print $page->id ?>">Edit</a> | 
<a href="?action=delete_page&amp;id=<?php print $page->id ?>">Delete</a>
</td>
</tr>
<?php
        };
?>
</table>
<?php
    };

    // SAVE EDITED PAGE
    if ($get_action == 'submit_create_page') {
        print '<strong>'.$_POST[title].'</strong> has been created successfully.';
    };

    // SUBMIT EDIT PAGE
    if ($get_action == 'submit_edit_page') {
        page_header('Successfully Edited Page');
        if ($get_id != '') {
            $admin = $_POST['admin'] ? true : false;
            $member = $_POST['member'] ? true : false;
            $public = $_POST['public'] ? true : false;
            $db->query("UPDATE `pages` SET `page_name` = '$_POST[urlkey]', `page_title` = '$_POST[title]', `body` = '$_POST[body]', `admin` = '$admin', `member` = '$member', `public` = '$public', `password` = '$_POST[pass]', `css` = '$_POST[css]', `header` = '$_POST[head]', `footer` = '$_POST[footer]' WHERE `id` = '$get_id'");
?>
<strong><?php print $_POST['title'] ?></strong> has been successfully saved.
<?php
        };
    };

    // CREATE NEW PAGE
    if ($get_action == 'create_page') {
        title("Create New Page");
        page_header("Create New Page");
?>
Coming Soon
<?php
    };

    // EDIT PAGE
    if ($get_action == 'edit_page') {
        title("Edit Page");
        page_header('Edit Page');
        if ($get_id != '') {
            $page = $db->get_row("SELECT * FROM `pages` WHERE `id` = $get_id");
?>
<form class="form-horizontal" role="form" action="?action=submit_edit_page&amp;id=<?php print $page->id ?>" method="post">
<div class="form-group">
<label>Page Title:</label>
<input type="text" class="form-control" name="title" value="<?php print $page->page_title ?>" placeholder="<?php print $page->page_title ?>" />
</div>
<div class="form-group">
<label>URL Key (Set):</label>
<input type="text" name="urlkey" class="form-control" value="<?php print $page->page_name ?>" placeholder="<?php print $page->page_name ?>"/>
</div>
<div class="form-group">
<label>Header:</label>
<textarea name="head" class="form-control"><?php print $page->header ?></textarea>
</div>
<div class="form-group">
<label>CSS:</label>
<textarea name="css" class="form-control"><?php print $page->css ?></textarea>
</div>
<div class="form-group">
<label>Page Body:</label>
<textarea name="body" class="form-control"><?php print $page->body ?></textarea>
</div>
<div class="form-group">
<label>Footer:</label>
<textarea name="footer" class="form-control"><?php print $page->footer ?></textarea>
</div>
<div class="form-group">
<label>Group Access List:</label>
<label class="checkbox-inline">
<input type="checkbox" name="admin" value="admin" <?php print $page->admin ? 'checked="checked"' : '' ?>>
Administrators
</label>
<label class="checkbox-inline">
<input type="checkbox" name="member" value="member" <?php print $page->member ? 'checked="checked"' : '' ?>>
Members
</label>
<label class="checkbox-inline">
<input type="checkbox" name="public" value="public" <?php print $page->public ? 'checked="checked"' : '' ?>>
Public
</label>
</div>
<div class="form-group">
<label>Password:</label>
<input type="text" name="password" class="form-control" value="<?php print $page->password ?>" placeholder="<?php print $page->password ?>" />
Leave blank for NO password
</div>
<button type="submit" class="btn btn-lg btn-primary">Edit Page</button>
</form>
<?php
        };
    };

    // SUBMIT DELETE PAGE
    if ($get_action == 'submit_delete_page') {
        if ($get_id != '') {
            $db->query("DELETE FROM `pages` WHERE `id` = $get_id");
            title("Page Successfully Deleted");
            page_header("Page Successfully Deleted");
?>
The requested page has been deleted successfully.
<?php
        } else {
            title("Invalid ID");
            page_header("Invalid ID");
        };
    };

    // DELETE PAGE
    if ($get_action == 'delete_page') {
        if ($get_id != '') {
            $page = $db->get_row("SELECT * FROM `pages` WHERE `id` = $get_id");
            title("Delete Page");
            page_header("Delete Page");
?>
<p><strong>Title:</strong> <?php print $page->page_title ?></p>
<p><strong>URL Key:</strong> <?php print $page->page_name ?></p>
<p><strong>Views:</strong> <?php print $page->views ?></p>
<p><strong>Header:</strong></p>
<p><?php print $page->header ?></p>
<p><strong>CSS:</strong></p>
<p><?php print $page->css ?></p>
<p><strong>Page Body:</strong></p>
<p><?php print $page->body ?></p>
<p><strong>Footer:</strong></p>
<p><?php print $page->footer ?></p>

<strong>Are you sure you want to delete this page?</strong>
<form action="?action=submit_delete_page&amp;id=<?php print $page->id ?>" method="post">
<button type="submit" class="btn btn-lg btn-primary">Yes</button>
<button type="button" class="btn btn-lg" onclick="history.go(-1)">No</button>
</form>
<?php
        } else {
            print 'PAGE DOES NOT EXIST';
        };
    };
};
require_once(dirname(dirname(__FILE__)) . '/footer.php');
?>
