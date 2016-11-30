<?php

require_once('functions.php');

$id = $_GET['id'];

// No Error Occurred
if ($id == '' || ($id != 1 && $id != 2 && $id != 3)){
    $status_code = 200;
    $error_message_title = 'No Error Occurred';
    $error_message = '<img align="middle" src="themes/' . $theme . '/images/noerroroccurred.jpg">';
};

// Wrong Username and/or Password
if ($id == 1){
    $status_code = 200;
    $error_message_title = 'Wrong Username and/or Password';
    $error_message = 'You did not enter a correct username and/or password.<br />
        Please try again.';
};

// Access Denied
if ($id == '2'){
    $status_code = 401;
    $error_message_title = 'Incorrect Authentication';
    $error_message = 'Your do not have the correct authentication to view this page.<br />
        Please login, or register if you have not already done so, to be able to view this page.';
};

// Page Does Not Exist
if ($id == '3'){
    $status_code = 404;
    $error_message_title = 'Page Does Not Exist';
    $error_message = 'The page you are looking for does not exist.';
};

// Function Not Defined
if (!isset($id)){
    $error_message_title = 'Function Not Defined';
    $error_message = 'This function is not defined.';
};
if ($error_message_title != '' || $error_message != '') {
    title($error_message_title);
    page_header($error_message_title);
    http_response_code($status_code);
?>
<p>
<?php print $error_message ?>
</p>
<?php
};
require_once('footer.php');
?>
