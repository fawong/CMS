<?php
require_once('functions.php');

if ($action == 'login') {
    title("Login to $cms_name");
    page_header("Sign in to $cms_name");
?>
<form class="form-signin" method="post" action="?action=authenticate" name="login">
    <h2 class="form-signin-heading">Please sign in</h2>
    <input type="text" class="form-control" placeholder="Username" name="inputusername" autofocus>
    <input type="password" class="form-control" placeholder="Password" name="inputpassword">
<!-- 
     <label class="checkbox">
         <input type="checkbox" value="remember-me"> Remember me
     </label>
-->
    <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
</form>

<?php
};

if ($action == 'authenticate') {
    $iun = $_POST['inputusername'];
    $inputp = $_POST['inputpassword'];
    if ($iun != '' || $inputp != '') {
        $hashpass = sha1(md5($inputp));
        $check_sql = mysql_query("SELECT * FROM users WHERE username = '$iun' AND password = '$hashpass'");
        $check_row = mysql_num_rows($check_sql);
        if ($check_row == 1) {
            $select = mysql_query("SELECT * FROM users WHERE username = '$iun'");
            while ($row = mysql_fetch_array($select)) {
                $_SESSION['group'] = $row['group'];
                $_SESSION['rank'] = $row['rank'];
                $_SESSION['user_id'] = $row['user_id'];
                $_SESSION['username'] = $row['username'];
                $_SESSION['firstname'] = $row['first_name'];
                $_SESSION['lastname'] = $row['last_name'];
                $_SESSION['theme_name'] = $row['theme'];
                $_SESSION['access_file_manager'] = $row['access_file_manager'];
                $_SESSION['choice'] = 'agree';
            };
            $_SESSION['login'] = true;
            $sql = "UPDATE users SET last_log_on = '$local_time', ip = '$ip' WHERE username = '$username'";
            $result = mysql_query($sql) or die (mysql_error());
            $sql = "UPDATE users SET online = '1' WHERE username = '$username'";
            $result = mysql_query($sql) or die (mysql_error());
?>
Logged in successfully. No redirect yet.
<?php
        } else {
            redirect("failed.php?id=1");
        };
    } else {
        redirect("failed.php?id=1");
    };
};

//LOGOUT SCRIPT
if ($action == 'logout') {
    $result = mysql_query("UPDATE users SET `online` = '0' WHERE `username` = '$username'") or die (mysql_error());
    $_SESSION['login'] = false;
    session_destroy();
?>
Logged out successfully. No redirect yet.
<?php
}; //if ($act == 'logout')
require_once('footer.php');
?>
