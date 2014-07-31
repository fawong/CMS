<?php
require_once('functions.php');
require_once("includes/recaptcha/recaptchalib.php");

// CREATE ACCOUNT
if ($login == false) {
    if ($get_action == 'create_account') {
        $resp = recaptcha_check_answer($settings['recaptcha_private_key'], $_SERVER["REMOTE_ADDR"], $_POST["recaptcha_challenge_field"], $_POST["recaptcha_response_field"]) or die('ERROR');
        if ($resp->is_valid) {
            $user_name = $_POST['username'];
            if (! $db->get_row("SELECT * FROM users WHERE username = '$user_name'")) {
                $first_name = $_POST['first_name'];
                if ($first_name != '') {
                    $last_name = $_POST['last_name'];
                    if ($last_name != '') {
                        if ($user_name != '') {
                            $password = $_POST['password'];
                            if ($password != '') {
                                $confirm_password = $_POST['confirm_password'];
                                if ($password == $confirm_password) {
                                    $email_address = $_POST['email'];
                                    if ($email_address != '') {
                                        $confirm_email_address = $_POST['confirm_email'];
                                        if ($email_address == $confirm_email_address) {
                                            $month = $_POST['month'];
                                            $day = $_POST['day'];
                                            $year = $_POST['year'];
                                            $date_of_birth = ''.$year.'-'.$month.'-'.$day.'';
                                            if ($date_of_birth != 'Month:-Day:-Year:' || $date_of_birth != 'Month:-Day:-'.$year.'' || $date_of_birth != ''.$month.'-Day:-Year:' || $date_of_birth != 'Month:-'.$day.'-Year:') {
                                                $agree = $_POST['agree'];
                                                if ($agree == 'agree') {
                                                    $email = $_POST['email'];
                                                    $ip = ip2long($_SERVER['REMOTE_ADDR']);
                                                    $alphanumeric = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
                                                    $activation_code = substr(str_shuffle($alphanumeric), 0, 20);
                                                    $hashedpass = password2hash($password);
                                                    $db->query("INSERT INTO `users` (`first_name`, `last_name`, `username`, `password`, `date_of_birth`, `email`, `ip`, `activation_code`, `access_file_manager`, `access_dlcp`) VALUES ('$first_name', '$last_name', '$user_name', '$hashedpass', '$date_of_birth', '$email', '$ip', '$activation_code', '0' ,'0')");
                                                    title("Successful Registration");
                                                    page_header('Successful Registration');
?>
You have successfully register for <?php print $cms_name ?>.
<?php
                                                } else {
                                                    print 'You did not agree to the Terms of Service.';
                                                };
                                            } else {
                                                print 'You did not provide a date of birth.';
                                            };
                                        } else {
                                            print 'The email does not match.';
                                        };
                                    } else {
                                        print 'You cannot have an empty email.';
                                    };
                                } else {
                                    print 'The password does not match.';
                                };
                            } else {
                                print 'You cannot have an empty password.';
                            };
                        } else {
                            print 'You cannot have an empty username.';
                        };
                    } else {
                        print 'You cannot have an empty last name.';
                    };
                } else {
                    print 'You cannot have an empty first name.';
                };
            } else {
                print 'You cannot create the same username as someone else.';
            };
        } else {
            title("Wrong Verification Code");
            page_header('Wrong Verification Code');
?>
<p>You did not enter the correct verification code. Please go back and try again.</p>
<p>If you think this is an error, please contact the webmaster with the following error code: <?php print $resp->error ?></p>
<?php
        };
    };

    // REGISTER
    if ($get_action == 'register') {
        if($login == true) {
            title("Registration Error");
            page_header('You Are Already Logged In');
?>
You are already logged in to <?php print $cms_name ?>.
<?php
        } else {
            title("Register for $cms_name");
?>
            <script type="text/javascript">
            var RecaptchaOptions = {
                theme : 'clean'
            };
            </script>
<?php page_header('Register') ?>
<form role="form" class="form-signin form-horizontal" method="post" action="?action=create_account">
<p>* = Required Item</p>
<div class="form-group">
<label>*First Name:</label>
<input type="text" class="form-control" name="first_name" />
</div>
<div class="form-group">
<label>*Last Name:</label>
<input type="text" class="form-control" name="last_name" />
</div>
<div class="form-group">
<label>*Username:</label>
<input type="text" class="form-control" name="username" />
</div>
<div class="form-group">
<label>*Password:</label>
<input type="password" class="form-control" name="password" />
</div>
<div class="form-group">
<label>*Confirm Password:</label>
<input type="password" class="form-control" name="confirm_password" />
</div>
<div class="form-group">
<label>*Email Address:</label>
<input type="text" class="form-control" name="email" />
</div>
<div class="form-group">
<label>*Confirm Email Address:</label>
<input type="text" class="form-control" name="confirm_email" />
</div>
<div class="form-group">
<label>*Date of Birth:</label>
<br />
<div class="col-lg-4">
<select class="form-control" name="month">
<option value="Month:">Month:</option>
<option value="1">January</option>
<option value="2">February</option>
<option value="3">March</option>
<option value="4">April</option>
<option value="5">May</option>
<option value="6">June</option>
<option value="7">July</option>
<option value="8">August</option>
<option value="9">September</option>
<option value="10">October</option>
<option value="11">November</option>
<option value="12">December</option>
</select>
</div>
<div class="col-lg-4">
<select class="form-control" name="day">
<option value="Day:">Day:</option>
<?php
            for ($i = 1; $i <= 31; $i++) {
?>
<option value="<?php print $i ?>"><?php print $i ?></option>
<?php
            };
?>
</select>
</div>
<div class="col-lg-4">
<select class="form-control" name="year">
<option value="Year:">Year:</option>
<?php
            for ($i = 2008; $i >= 1920; $i--) {
?>
<option value="<?php print $i ?>"><?php print $i ?></option>
<?php
            };
?>
</select>
</div>
</div>
<div class="form-group">
<label>*I agree to and understand the <a href="page.php?page=tos" target="_blank">Terms of Service</a>.</label>
<input type="checkbox" name="agree" value="agree" />
</div>
<div class="form-group">
<label>*Are you human?</label>
<?php
            echo recaptcha_get_html($settings['recaptcha_public_key'], NULL, true);
?>
</div>
<button type="submit" class="btn btn-primary btn-lg">Create My Account</button>
</form>
<?php
        };
    };
} else {
    title("Registration Error");
    page_header('You Are Already Logged In');
?>
You are already logged in.
<?php
};
require_once('footer.php');
?>
