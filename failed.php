<?php
if ($_REQUEST['act'] == 'failed'){
    //No Error Occurred
    if ($id == '' || ($id != 1 && $id != 2)){
        $error_message_title = 'No Error Occurred';
        title($error_message_title);
        $error_message = '<img align="middle" src="themes/' . $_SESSION[theme] . '/images/noerroroccurred.jpg">';
    };
    //Wrong Username and/or Password
    if ($id == 1){
        $error_message_title = 'Wrong Username and/or Password';
        title($error_message_title);
        $error_message = 'You did not enter a correct username and/or password.<br />
            Please try again.';
    };
    //Access Denied
    if ($id == '2'){
        $error_message_title = 'Incorrect Authentication';
        title($error_message_title);
        $error_message = 'Your do not have the correct authentication to view this page.<br />
            Please login, or register if you have not already done so, to be able to view this page.';
    };
    //Page Does Not Exist
    if ($id == '3'){
        $error_message_title = 'Page Does Not Exist';
        title($error_message_title);
        $error_message = 'The page <u>' .$_GET['set']. '</u> does not exist.';
    };
    //Function Not Defined
    if (!isset($id)){
        $error_message_title = 'Function Not Defined';
        title($error_message_title);
        $error_message = 'This function is not defined.';
    };
    if($settings['force_block'] == 0 && ($error_message_title != '' || $error_message != '')){
        page_header($error_message_title);
        print $error_message;
    };
};
?>
