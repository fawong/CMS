<?php 
require_once(dirname(dirname(__FILE__)) . '/functions.php');

if ($group != 1) {
    redirect('failed?id=2');
} else {
    if ($get_action == 'page') {
        title("Web Page Control Panel");
        page_header('Web Page Control Panel');
?>
<p><a href="?act=admin&amp;action=create_new_page">Add a New Web Page</a></p>

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
        foreach ($db->get_results("SELECT * from `pages` ORDER BY `page_name`") as $page) {
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
            $db->query("UPDATE `pages` SET `page_name` = '$_POST[urlkey]', `page_title` = '$_POST[title]', `body` = '$_POST[body]', `admin` = '$admincheckbox', `member` = '$membercheckbox', `public` = '$publiccheckbox', `password` = '$_POST[pass]', `css` = '$_POST[css]', `header` = '$_POST[head]', `footer` = '$_POST[footer]' WHERE `id` = '$get_id'");
?>
<strong><?php print $_POST['title'] ?></strong> has been successfully saved.
<?php
        };
    };

    // SUBMIT DELETE WEBPAGE
    if ($get_action == 'submit_delete_page') {
        while ($row = mysql_fetch_array($requesttitle)) {
            $printtitle = 'awejefkawgkoljawegklj';
        };
        print '<strong>'.$printtitle.'</strong> has been deleted.';
    };

    // CREATE NEW PAGE
    if ($get_action == 'create_page') {
        title("Create New Web Page");
?>
print '<h1><center>Create New Web Page</center></h1>
<hr width="100%"/>
<table class="table"><tr><td>
<form action="?act=admin&amp;action=page&amp;set=save_page&amp;action=submit_create_page" method="post">
Page Title: <input type="text" name="title" />
<br />
URL Key (Page): <input type="text" name="urlkey" />
<br />
Head:
<br />
<textarea name="head" cols="80" rows="10"></textarea>
<br />
CSS:
<br />
<textarea name="css" cols="80" rows="10"></textarea>
<br />
Page Body:
<br />
<textarea name="body" cols="80" rows="10"></textarea>
<br />
Footer:
<br />
<textarea name="footer" cols="80" rows="10"></textarea>
<br />
Group Access List:<br />
<input type="checkbox" name="admin" value="admin" />Administrators<br />
<input type="checkbox" name="member" value="member" />Webmasters<br />
<input type="checkbox" name="member" value="member" />Members<br />
<input type="checkbox" name="public" value="public" />Public<br />
<br />
Password: <input type="text" name="password" value="<?php print $page->password ?>"/><br />
Leave blank for NO password<br />
<input type="submit" value="Create Page" />
</form>
</td></tr></table>';
<?php
    };

    // EDIT PAGE
    if ($get_action == 'edit_page') {
        title("Edit Web Page");
        page_header('Edit Web Page');
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
<div class="checkbox">
<label>
<input type="checkbox" name="admin" value="admin" <?php print $page->admin ? 'checked="checked"' : '/' ?>>
Administrators
</label>
<label>
<input type="checkbox" name="member" value="member" <?php print $page->member ? 'checked="checked"' : '/' ?>>
Members
</label>
<label>
<input type="checkbox" name="public" value="public" <?php print $page->public ? 'checked="checked"' : '/' ?>>
Public
</label>
</div>
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

    // DELETE PAGE
    if ($get_action == 'delete_page') {
        title("Delete Web Page");
        if ($id != '') {
            while ($row = mysql_fetch_array($select_kill)) {
?>
print '<h1><center>Delete Web Page</center></h1>
<hr width="100%"/>
<table class="table">
<tr><td>
<strong>Title:</strong> '.$page->page_title.'<br />
<strong>URL Key:</strong> '.$page->set.'<br />
<strong>Views:</strong> '.$page->views.'<br />
<strong>Header:</strong><br />
'.$page->header.'<br /><br />
<strong>CSS:</strong><br />
'.$page->css.'<br /><br />
<strong>Page Body:</strong><br />
'.$page->body.'<br /><br />
<strong>Footer:</strong><br />
'.$page->footer.'
</td></tr>
</table>
<table class="table">
<tr><td>
<strong>Are you sure you want to delete this page?</strong><br />
<form action="?act=admin&amp;action=page&amp;set=delete&amp;id='.$page->id.'" method="post">
<input type="submit" value="Yes" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="button" onclick="history.go(-1)" value="No" />
</form>
</td></tr>
</table>';
<?php
            };
        } else {
            print 'PAGE DOES NOT EXIST';
        };
    };
};
require_once(dirname(dirname(__FILE__)) . '/footer.php');
?>
