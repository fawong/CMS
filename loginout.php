<?php
require_once('functions.php');

// LOGIN
if ($login == false) {
    if ($get_action == 'login') {
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
} else {
    page_header('Already Logged In');
?>
You are already logged in.
<?php
}

if ($get_action == 'authenticate') {
    $inputun = $_POST['inputusername'];
    $inputp = $_POST['inputpassword'];
    if ($inputun != '' && $inputp != '') {
        $hashpass = password2hash($inputp);
        if ($user = $db->get_row("SELECT * FROM users WHERE username = '$inputun' AND password = '$hashpass'")) {
            $_SESSION['group_id'] = $user->group_id;
            $_SESSION['rank'] = $user->rank;
            $_SESSION['user_id'] = $user->id;
            $_SESSION['username'] = $user->username;
            $_SESSION['login'] = true;
            $db->query("UPDATE users SET ip = '".ip2long($ip)."', online = 1 WHERE username = '$username'");
            redirect("posts.php");
        } else {
            redirect("failed.php?id=1");
        };
    } else {
        redirect("failed.php?id=1");
    };
};

// LOGOUT
if ($get_action == 'logout') {
    $db->query("UPDATE users SET `online` = '0' WHERE `username` = '$username'");
    $_SESSION['login'] = false;
    session_destroy();
    redirect('index.php');
};
require_once('footer.php');
?>
