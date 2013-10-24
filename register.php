<?php
require_once("recaptcha/recaptchalib.php");
//CREATE ACCOUNT
if ($act == 'create_account'){
  $privatekey = "6LcDRr8SAAAAAEMroogFsKj7hFf-rodx2cCsMUVl"; 
  $resp = recaptcha_check_answer ($privatekey, $_SERVER["REMOTE_ADDR"], $_POST["recaptcha_challenge_field"], $_POST["recaptcha_response_field"]);
  if ($resp->is_valid) {
    if ($_SESSION['login'] == false || !isset($_SESSION['login'])){
      $user_name = $_POST['username'];
      $username_check = mysql_query("SELECT * FROM users WHERE username = '$user_name'");
      if (mysql_num_rows($username_check) == 0){
        //print 'debug: '.print_r(mysql_fetch_array($username_check)) or die("you failed").'';
        $first_name = $_POST['first_name'];
        if ($first_name != ''){
          $last_name = $_POST['last_name'];
          if ($last_name != ''){
            if ($user_name != ''){
              $password = $_POST['password'];
              if ($password != ''){
                $confirm_password = $_POST['confirm_password'];
                if ($password == $confirm_password){
                  $email_address = $_POST['email'];
                  if ($email_address != ''){
                    $confirm_email_address = $_POST['confirm_email'];
                    if ($email_address == $confirm_email_address){
                      $month = $_POST['month'];
                      $day = $_POST['day'];
                      $year = $_POST['year'];
                      $date_of_birth = ''.$month.'-'.$day.'-'.$year.'';
                      if ($date_of_birth != 'Month:-Day:-Year:' || $date_of_birth != 'Month:-Day:-'.$year.'' || $date_of_birth != ''.$month.'-Day:-Year:' || $date_of_birth != 'Month:-'.$day.'-Year:'){
                        $agree = $_POST['agree'];
                        if ($agree == 'agree'){
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
                        }else{print 'You did not agree to the Terms of Service.';};//if ($agree == 'agree')
                      }else{print 'You did not provide a date of birth.';};//if ($date_of_birth != '')
                    }else{print 'The email does not match.';};//if ($password == $confirm_password)
                  }else{print 'You cannot have an empty email.';};//if ($password != '')
                }else{print 'The password does not match.';};//if ($password == $confirm_password)
              }else{print 'You cannot have an empty password.';};//if ($password != '')
            }else{print 'You cannot have an empty username.';};//if ($user_name != '')
          }else{print 'You cannot have an empty last name.';};//if ($last_name != '')
        }else{print 'You cannot have an empty first name.';};//if ($last_name != '')
      }else{print 'You cannot create the same username as someone else.';};//if (mysql_num_rows($requestusername_check) == 0)
    }else{print 'You are already logged in.';};//if ($_SESSION['login'] == false || !isset($_SESSION['login']))
  }else{
    title("Wrong Verification Code");
    print '<center><h1>Wrong Verification Code</h1></center>
      <hr width="100%" align="center" />
      <table align="center">
      <tr><td>
      You did not enter the correct verification code. Please go back and try again.<br />
      If you think this is an error, please contact the webmaster with the following error code:
        '.$resp->error.'
        </td></tr>
        </table>';
  };//if ($resp->is_valid)
};//if ($act == 'create_account')
//REGISTER
if ($act == 'register'){
  if($_SESSION['login'] == TRUE){
    title("Registration Error");
    page_header('You Are Already Logged In');
?>
You are already logged in to <?php print $cms_name ?>.
<?php
  }//if($_SESSION['login'] == TRUE)
  else{
    title("Register for $cms_name");
    print '<script type="text/javascript">
      var RecaptchaOptions = {
        theme : \'clean\'
  };
</script>
<center><h1>Register</h1></center>
<hr width="100%" align="center" />
<table align="center"><tr><td>
Please remember to read our Terms of Service.<br />
Please fill out the form below in order to sign up for '.$cms_name.'.<br /><br />
* = Required Item
</td></tr></table>
<form method="post" action="index.php?act=create_account">
<table align="center">
<tr><td><strong>*First Name:</strong></td><td><input type="text" name="first_name" size="65" /></td></tr>
<tr><td><strong>*Last Name:</strong></td><td><input type="text" name="last_name" size="65" /></td></tr>
<tr><td><strong>*Username:</strong></td><td><input type="text" name="username" size="65" /></td></tr>
<tr><td><strong>*Password:</strong></td><td><input type="password" name="password" size="65" /></td></tr>
<tr><td><strong>*Comfirm Password:</strong></td><td><input type="password" name="confirm_password" size="65" /></td></tr>
<tr><td><strong>*Email Address:</strong></td><td><input type="text" name="email" size="65" /></td></tr>
<tr><td><strong>*Confirm Email Address:</strong></td><td><input type="text" name="confirm_email" size="65" /></td></tr>
<tr><td><strong>*Date of Birth:</strong></td><td>
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
<option value="1">1</option>
<option value="2">2</option>
<option value="3">3</option>
<option value="4">4</option>
<option value="5">5</option>
<option value="6">6</option>
<option value="7">7</option>
<option value="8">8</option>
<option value="9">9</option>
<option value="10">10</option>
<option value="11">11</option>
<option value="12">12</option>
<option value="13">13</option>
<option value="14">14</option>
<option value="15">15</option>
<option value="16">16</option>
<option value="17">17</option>
<option value="18">18</option>
<option value="19">19</option>
<option value="20">20</option>
<option value="21">21</option>
<option value="22">22</option>
<option value="23">23</option>
<option value="24">24</option>
<option value="25">25</option>
<option value="26">26</option>
<option value="27">27</option>
<option value="28">28</option>
<option value="29">29</option>
<option value="30">30</option>
<option value="31">31</option>
</select>
<select name="year">
<option value="Year:">Year:</option>
<option value="2009">2009</option>
<option value="2008">2008</option>
<option value="2007">2007</option>
<option value="2006">2006</option>
<option value="2005">2005</option>
<option value="2004">2004</option>
<option value="2003">2003</option>
<option value="2002">2002</option>
<option value="2001">2001</option>
<option value="2000">2000</option>
<option value="1999">1999</option>
<option value="1998">1998</option>
<option value="1997">1997</option>
<option value="1996">1996</option>
<option value="1995">1995</option>
<option value="1994">1994</option>
<option value="1993">1993</option>
<option value="1992">1992</option>
<option value="1991">1991</option>
<option value="1990">1990</option>
<option value="1989">1989</option>
<option value="1988">1988</option>
<option value="1987">1987</option>
<option value="1986">1986</option>
<option value="1985">1985</option>
<option value="1984">1984</option>
<option value="1983">1983</option>
<option value="1982">1982</option>
<option value="1981">1981</option>
<option value="1980">1980</option>
<option value="1979">1979</option>
<option value="1978">1978</option>
<option value="1977">1977</option>
<option value="1976">1976</option>
<option value="1975">1975</option>
<option value="1974">1974</option>
<option value="1973">1973</option>
<option value="1972">1972</option>
<option value="1971">1971</option>
<option value="1970">1970</option>
<option value="1969">1969</option>
<option value="1968">1968</option>
<option value="1967">1967</option>
<option value="1966">1966</option>
<option value="1965">1965</option>
<option value="1964">1964</option>
<option value="1963">1963</option>
<option value="1962">1962</option>
<option value="1961">1961</option>
<option value="1960">1960</option>
<option value="1959">1959</option>
<option value="1958">1958</option>
<option value="1957">1957</option>
<option value="1956">1956</option>
<option value="1955">1955</option>
<option value="1954">1954</option>
<option value="1953">1953</option>
<option value="1952">1952</option>
<option value="1951">1951</option>
<option value="1950">1950</option>
<option value="1949">1949</option>
<option value="1948">1948</option>
<option value="1947">1947</option>
<option value="1946">1946</option>
<option value="1945">1945</option>
<option value="1944">1944</option>
<option value="1943">1943</option>
<option value="1942">1942</option>
<option value="1941">1941</option>
<option value="1940">1940</option>
<option value="1939">1939</option>
<option value="1938">1938</option>
<option value="1937">1937</option>
<option value="1936">1936</option>
<option value="1935">1935</option>
<option value="1934">1934</option>
<option value="1933">1933</option>
<option value="1932">1932</option>
<option value="1931">1931</option>
<option value="1930">1930</option>
<option value="1929">1929</option>
<option value="1928">1928</option>
<option value="1927">1927</option>
<option value="1926">1926</option>
<option value="1925">1925</option>
<option value="1924">1924</option>
<option value="1923">1923</option>
<option value="1922">1922</option>
<option value="1921">1921</option>
<option value="1920">1920</option>
</select>
</td></tr>
<tr><td>
<strong>*I agree to and understand the <a href="index.php?page=tos" target="_blank">Terms of Service</a></strong>.</td><td>
<input type="checkbox" name="agree" value="agree" /></td></tr>
<tr><td><strong>*Are you human?</strong></td><td>';
$publickey = "6LcDRr8SAAAAAFxRSd_AIC-7H_qBikZMZ5u_9JBc";
echo recaptcha_get_html($publickey, NULL, true);
print '</td></tr>
<tr><td><input type="submit" value="Create My Account" />
</td></tr>
</table>
</form>';
};
};
?>
