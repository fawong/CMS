<?php
include_once('functions.php');

// FORGOT USERNAME AND/OR PASSWORD
if($login == true) {
    title("Retrieve Username/Password Error");
    print '<center><h1>You Are Already Logged In</h1></center>
        <hr width="100%" align="center" />
        <table class="table" align="center">
        <tr><td>
        You are already logged in to the '.$website_name.' system.
        </td></tr>
        </table>';
} else {
    title("Username and/or Password Help");
    page_header('Forgot Username and/or Password');
?>
<p>Please enter the email address that you used to sign up for an account.</p>
<form class="form" role="form" method="post">
<!--
<div class="form-group">
<label>Username:</label>
<input type="text" name="username" class="form-control">
</div>
-->
<div class="form-group">
<label>Email Address:</label>
<input type="text" name="email" class="form-control">
</div>
<button type="submit" class="btn btn-lg btn-primary">Submit</button>
</form>
<?php
};

// SUBMIT FORGOT USERNAME AND/OR PASSWORD
if (isset($_POST['email'])) {
    if ($_POST['email'] != '') {
        $requestemail = $_POST['email'];
        if ($user = $db->get_row("SELECT * FROM `users` WHERE `email` = '$requestemail'")) {
            $replyemail = $settings['replyemail'];

            $headers .= "Return-Path: $replyemail\n";
            $headers .= "Reply-To: $replyemail\n";
            $headers .= "From: $replyemail\n";
            $headers .= "Errors-To: $replyemail\n";
            $headers .= "Content-Type: text/html; charset=UTF-8";

            $user = $db->get_row("SELECT * FROM users WHERE `email` = '$requestemail'");

            $body = "Username: $user->username";
            //Mail function will return true if it is successful
            $sendemail = mail($requestemail, "Your request for login details to $cms_name", $body, $headers);
            if($sendemail) {
                title("Login Details Have Been Sent");
?>
Your password has been sent to your email address. Please check your e-mail.
<?php
            } else {
                title("Error Sending E-mail");
?>
<center><h1>Error Sending E-mail</h1></center>
<hr width="100%" align="center" />
<center>
<font color="red">There is some system problem in sending login details to your address.<br />
Please contact the webmaster of this website.<br /><br />
<input type="button" value="Retry" onClick="history.go(-1)"></font>
</center>
<?php
            };
        } else {
?>
    <p>The email address is not found in our database.</p>
<?php
        };
    };
};

include_once('footer.php');
?>
