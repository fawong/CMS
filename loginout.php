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
<p><a href="forgotuserpass.php">Forgot username and/or password?</a></p>
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
        if ($user = $db->get_row("SELECT * FROM users WHERE username = '$inputun'")) {
          var_dump($user);
          print_r($user);
            if (password_verify($inputp, $user->password)) {
                if (password_needs_rehash($user->password, PASSWORD_DEFAULT, [ 'cost' => 12 ])) {
                    $hashedpass = password2hash($inputp);
                    $db->query("UPDATE `users` SET `password` = '$hashedpass' WHERE `username` = '$inputun'");
                };
                $_SESSION['group_id'] = $user->group_id;
                $_SESSION['user_id'] = $user->id;
                $_SESSION['username'] = $user->username;
                $_SESSION['login'] = true;
                $db->query("UPDATE users SET ip = '" . ip2long($ip) . "', online = 1 WHERE username = '$user->username'");
                $db->debug();
                redirect("posts.php");
            } else {
                redirect("failed.php?id=1");
            };
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
