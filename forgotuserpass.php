<?php
//FORGOT USERNAME AND/OR PASSWORD
if ($act == 'forgot_username/password'){
title("Retrieve Username/Password Error");
if($_SESSION['login'] == TRUE){
print '<center><h1>You Are Already Logged In</h1></center>
<hr width="100%" align="center" />
<table class="table" align="center">
<tr><td>
You are already logged in to the '.$website_name.' system.
</td></tr>
</table>';
}//if($_SESSION['login'] == TRUE)
else{
title("Username and/or Password Help");
print '<center><h1>Forgot Password</h1></center>
<hr width="100%" align="center" />
<center>Not enabled yet</center>';
/*<table class="table" align="center"><tr><td>Please enter your username and email address.</td></tr></table>
<form action="?act=submit_forgot_username/password" method="post">
<table class="table" align="center">
<tr><td><strong>Username:</strong></td><td><input type="text" name="username" size="60" /></td></tr>
<tr><td><strong>Email Address:</strong></td><td><input type="text" name="email" size="60" /></td></tr>
<tr><td><input type="submit" value="Submit" /></td></tr>
</table>
</form>';*/
};
};//if ($act == 'forgot_username/password')
if ($act == 'submit_forgot_username/password'){
$requestemail = $_POST[email];
$requestusername = $_POST[username];
$findmember = mysql_query("SELECT * FROM users WHERE `email` = '$requestemail' AND `username` = '$requestusername' LIMIT 1") or die (mysql_error());
$fetchmember = mysql_fetch_array($findmember) or die (mysql_error());
if ($row = $fetchmember){
//Formating for e-mail
//Headers
$replyemail = $settings['replyemail'];
$headers .= "Return-path: $replyemail\n";
$headers .= "Reply-to: $replyemail\n";
$headers .= "From: $replyemail\n";
$headers .= "Errors-to: $replyemail\n";
//For html mail un-comment the below line
$headers = "Content-Type: text/html; charset=iso-8859-1\n".$headers;
$body = "Username: $row[username]\n
Password: $row[password]";
//Mail function will return true if it is successful
$sendemail = mail($requestemail, 'Your request for login details to SUPER TESTING', $body, $headers);
if($sendemail){
title("Login Details Have Been Sent");
print '<center><h1>Login Details Have Been Sent</h1></center>
<hr width="100%" align="center" />
<center>
Your password has been sent to your email address. Please check your e-mail.
</center>';}
else{
title("Error Sending E-mail");
print '<center><h1>Error Sending E-mail</h1></center>
<hr width="100%" align="center" />
<center>
<font color="red">There is some system problem in sending login details to your address.<br />
Please contact the webmaster of this website.<br /><br />
<input type="button" value="Retry" onClick="history.go(-1)"></font>
</center>';};
}
else{
print 'Error: The email address is not found in our database.';
};
};//if ($act == 'submit_forgot_username/password')
?>
