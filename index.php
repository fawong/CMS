<?php
require_once('functions.php');

// ACT CONTROLS
if ($act == 'admin') {
    require_once('admin.php');
} else if ($act == 'wpcp') {
    require_once('wpcp.php');
} else if ($act == 'register') {
    require_once('register.php');
} else if ($act == 'manager') {
    require_once('filemanager.php');
} else if ($act == 'profile') {
    require_once('profile.php');
} else if ($act == 'options') {
    require_once('options.php');
} else if ($act == 'account') {
    require_once('account.php');
} else if ($act == 'login' || $act == 'logout') {
    require_once('loginout.php');
} else if ($act == 'dldb') {
    require_once('dldb.php');
} else if ($act == 'downloadscontrolpanel') {
    require_once('downloadscontrolpanel.php');
} else if ($act == 'calendar') {
    require_once('calendar.php');
} else if ($page != '') {
    require_once('webpage.php');
} else if ($act == 'forgot_username/password') {
    require_once('forgotuserpass.php');
} else if ($act == 'create_account') {
    require_once('register.php');
} else if ($act == 'inbox') {
    require_once('mail.php');
} else if ($act == 'comments') {
    require_once('comments.php');
} else {
    page_header('Nothing here right now');
?>
Coming soon
<?php
}
// FOOTER
require('footer.php');
?>
