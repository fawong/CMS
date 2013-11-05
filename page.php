<?php
include_once('functions.php');

if ($action == '') {
    if ($page = $db->get_row("SELECT * FROM `pages` WHERE `page_name` = '$get_page'")) {
        title($page->page_title);
        $password = $page->password;
        if ($page->public == 1 || $page->$_SESSION['group'] == 1) {
            if ($password == '') {
                page_header($page->page_title)
?>
<?php print $page->body ?>
<?php
            };
            if ($password != '') {
?>
<form method="page" action="?page=<?php print $page ?>">
<p>This page is password protected.</p>
<p>You must enter a password to proceed.</p>
<br /><br />
Password: <input type="password" name="pass" />
<button type="submit" class="btn btn-lg btn-primary">Submit</button>
</form>
<?php
            };
        } else {
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
