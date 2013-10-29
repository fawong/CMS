<?php
include_once('functions.php');

if ($action == '') {
    $find_page = mysql_query("SELECT * FROM `pages` WHERE `page_name` = '$page'");
    if (mysql_num_rows($find_page) == 1) {
        while ($row = mysql_fetch_array($find_page)) {
            title("$row[page_title]");
            $password = $row['password'];
            $_SESSION['page_lock'] = false;
            if ($row[$_SESSION['group']] == 1 || $row['public'] == 1) {
                if ($password == '') {
?>
<?php page_header($row['page_title']) ?>
<?php print $row['body'] ?>
<?php
                };
                if ($password != '') {
?>
<form method="post" action="?page=<?php print $page ?>">
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
        };
    } else {
        redirect("failed.php?id=3");
    };
};
include_once('footer.php');
?>
