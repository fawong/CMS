<?php
require_once("recaptcha/recaptchalib.php");
//CREATE ACCOUNT
if ($act == 'create_account') {
    $privatekey = "6LcDRr8SAAAAAEMroogFsKj7hFf-rodx2cCsMUVl"; 
    $resp = recaptcha_check_answer ($privatekey, $_SERVER["REMOTE_ADDR"], $_POST["recaptcha_challenge_field"], $_POST["recaptcha_response_field"]);
    if ($resp->is_valid) {
        if ($_SESSION['login'] == false || !isset($_SESSION['login'])) {
            $user_name = $_POST['username'];
            $username_check = mysql_query("SELECT * FROM users WHERE username = '$user_name'");
            if (mysql_num_rows($username_check) == 0) {
                //print 'debug: '.print_r(mysql_fetch_array($username_check)) or die("you failed").'';
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
                                            $date_of_birth = ''.$month.'-'.$day.'-'.$year.'';
                                            if ($date_of_birth != 'Month:-Day:-Year:' || $date_of_birth != 'Month:-Day:-'.$year.'' || $date_of_birth != ''.$month.'-Day:-Year:' || $date_of_birth != 'Month:-'.$day.'-Year:') {
                                                $agree = $_POST['agree'];
                                                if ($agree == 'agree') {
                                                    $email = $_POST['email'];
                                                    $ip = $_SERVER['REMOTE_ADDR'];
                                                    $date = date('m-j-y g:i:s A T');
                                                    $new_user_id = rand(00000,99999);
                                                    $alphanumeric = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
                                                    $activation_code = substr(str_shuffle($alphanumeric), 0, 20);
                                                    $hashedpass = sha1(md5($password));
                                                    $mysql_add_text = "INSERT INTO `users` (`first_name`, `last_name`, `user_id`, `group`, `username`, `password`, `date_joined`, `date_of_birth`, `email`, `ip`, `activation_code`, `access_file_manager`, `access_dlcp`) VALUES ('$first_name', '$last_name', '$new_user_id', 'member', '$user_name', '$hashedpass', '$local_time', '$date_of_birth', '$email', '$ip', '$activation_code', '0' ,'0')";
                                                    $mysql_add_query_bu = mysql_query($mysql_add_text) or die(mysql_error());
                                                    //"INSERT INTO `users` VALUES ('$new_user_id', 'member', 'member', '$requestusername', '$password', '$local_time', '$date_of_birth', '$email', '', '', '$ip', '0', '', '$activate_code', '0', '', '', '', '', '', '', '', '', '', '', 'default', '0', '0', '0', '0', '0', '0', '0')";
                                                    //$msysql_add = "INSERT INTO `users` ( `id`, `username`, `tag`, `password`, `date_joined`, `date_of_birth`, `email`, `activate_code`) VALUES ( `$new_user_id`, '$requestusername`, `$name_tag`, `$password`, `$date`, `$date_of_birth`, `$email`, `$activate_code`) ";
                                                    title("Successful Registration");
                                                    page_header('Successful Registration');
?>
                            You have successfully register for <?php print $cms_name ?>.
<?php
                                                } else {
                                                    print 'You did not agree to the Terms of Service.';
                                                };//if ($agree == 'agree')
                                            } else {
                                                print 'You did not provide a date of birth.';
                                            };//if ($date_of_birth != '')
                                        } else {
                                            print 'The email does not match.';
                                        };//if ($password == $confirm_password)
                                    } else {
                                        print 'You cannot have an empty email.';
                                    };//if ($password != '')
                                } else {
                                    print 'The password does not match.';
                                };//if ($password == $confirm_password)
                            } else {
                                print 'You cannot have an empty password.';
                            };//if ($password != '')
                        } else {
                            print 'You cannot have an empty username.';
                        };//if ($user_name != '')
                    } else {
                        print 'You cannot have an empty last name.';
                    };//if ($last_name != '')
                } else {
                    print 'You cannot have an empty first name.';
                };//if ($last_name != '')
            } else {
                print 'You cannot create the same username as someone else.';
            };//if (mysql_num_rows($requestusername_check) == 0)
        } else {
            print 'You are already logged in.';
        };//if ($_SESSION['login'] == false || !isset($_SESSION['login']))
    } else {

        title("Wrong Verification Code");
        print '<center><h1>Wrong Verification Code</h1></center>
            <hr width="100%" align="center" />
            <table align="center">

            You did not enter the correct verification code. Please go back and try again.<br />
            If you think this is an error, please contact the webmaster with the following error code:
                '.$resp->error.'

                </table>';
    };//if ($resp->is_valid)
};//if ($act == 'create_account')
//REGISTER
if ($act == 'register') {
    if($_SESSION['login'] == TRUE) {
        title("Registration Error");
        page_header('You Are Already Logged In');
?>
You are already logged in to <?php print $cms_name ?>.
<?php
    }//if($_SESSION['login'] == TRUE)
    else{
        title("Register for $cms_name");
?>
        <script type="text/javascript">
        var RecaptchaOptions = {
            theme : 'clean'
        };
        </script>
<?php page_header('Register') ?>
Please remember to read our Terms of Service.<br />
Please fill out the form below in order to sign up for <?php print $cms_name ?>.<br /><br />
* = Required Item
<form role="form" class="form-horizontal" method="post" action="index.php?act=create_account">
<div class="form-group">
<label>*First Name:</label>
<input type="text" class="form-control" name="first_name" size="65" />
</div>
<div class="form-group">
<label>*Last Name:</label>
<input type="text" class="form-control" name="last_name" size="65" />
</div>
<div class="form-group">
<label>*Username:</label>
<input type="text"  class="form-control" name="username" size="65" />
</div>
<div class="form-group">
<label>*Password:</label>
<input type="password"  class="form-control" name="password" size="65" />
</div>
<div class="form-group">
<label>*Comfirm Password:</label>
<input type="password"  class="form-control" name="confirm_password" size="65" />
</div>
<div class="form-group">
<label>*Email Address:</label>
<input type="text"  class="form-control" name="email" size="65" />
</div>
<div class="form-group">
<label>*Confirm Email Address:</label>
<input type="text"  class="form-control" name="confirm_email" size="65" />
</div>
<div class="form-group">
<label>*Date of Birth:</label>
<select name="month">
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
<select name="day">
<option value="Day:">Day:</option>
<?php
        for ($i = 1; $i <= 31; $i++) {
?>
<option value="<?php print $i ?>"><?php print $i ?></option>
<?php
        };
?>
</select>
<select name="year">
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
<div class="form-group">
<label>*I agree to and understand the <a href="index.php?page=tos" target="_blank">Terms of Service</a></label>.
<input type="checkbox" name="agree" value="agree" />
</div>
<div class="form-group">
<label>*Are you human?</label>
<?php
        $publickey = "6LcDRr8SAAAAAFxRSd_AIC-7H_qBikZMZ5u_9JBc";
        echo recaptcha_get_html($publickey, NULL, true);
?>
</div>
<input type="submit" value="Create My Account" />
</form>
<?php
    };
};
?>
