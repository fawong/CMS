<?php
//PAGE COMMAND
if ($act == '') {
    if ($act2 == '') {
        if ($cmd == '') {
            if ($page != '') {
                $find_page = mysql_query("SELECT * FROM `pages` WHERE `page` = '$page'");
                if (mysql_num_rows($find_page) == 1) {
                    while ($row = mysql_fetch_array($find_page)) {
                        title("$row[page_title]");
                        $password_protected = $row['password'];
                        $_SESSION['page_lock'] = false;
                        if ($row[$_SESSION['group']] == 1) {
                            if ($password_protected == '') {
                                mysql_query("UPDATE `pages` SET `views` = views + 1 WHERE `page` = '$page'") or die(mysql_error());
?>
<?php page_header($row['page_title']) ?>
<?php print $row['body'] ?>
<?php
                            };
                            if ($password_protected != '') {
                                if ($_SESSION['page_lock'] == false) {
                                    if ($tick == 'tock') {
                                        $password_find = mysql_query("SELECT * FROM `pages` WHERE `password` ='$_POST[pass]' AND `page` ='$page'");
                                        if (mysql_num_rows($password_find) == 1) {
                                            mysql_query("UPDATE `pages` SET views = views+1 WHERE `page` ='$page'") or die(mysql_error());
                                            page_header($row['page_title']);
                                            print $row['body'];
?>
<?php
                                            $_SESSION['page_lock'] = true;
                                        } else {
?>
                                            ERROR<br /><br />
<?php
                                        };
                                    };
                                };
                                if ($_SESSION['page_lock'] != true) {
                                    print '<form method="post" action="?page='.$page.'&amp;tick=tock">
                                        <font size = "+1">
                                        This page is password protected.
                                        <br />
                                        You must enter a password to proceed.
                                        </font>
                                        <br /><br />
                                        Password: <input type="password" name="pass" />
                                        <br />
                                        <input type="submit" value="Submit" />
                                        </form>';
                                };//if ($_SESSION['page_lock'] != true)
                            };//if ($password_protected != '')
                        } else {
                            page_header('Page Does Not Exist');
?>
                                The page you are looking for does not exist.
<?php
                        };//if ($row[$_SESSION[group]] == 1)
                    };//while ($row = mysql_fetch_array($find_page))
                } else {
                    redirect("index.php?act=failed&amp;id=3");
                };//if ($row = mysql_fetch_array($find_page))
            };//if ($page != '')
        };//if ($cmd == '')
    };//if ($act2 == '')
};//if ($act == '')
?>
