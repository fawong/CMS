<?php
session_start();

// GLOBAL VARIABLES
$username = $_SESSION['username'];
$user_id = $_SESSION['user_id'];
$ltname = $_SESSION['lastname'];
$group = $_SESSION['group_id'];
$login = $_SESSION['login'];

$get_id = $_GET['id'];
$get_page = $_GET['page'];
$get_action = $_GET['action'];
$get_path = $_GET['path'];
$get_file_name = $_GET['filename'];
$get_dir = $_GET['dir'];
$get_file = $_GET['file'];

$ip = $_SERVER['REMOTE_ADDR'];
$ruri = $_SERVER['REQUEST_URI'];
$full_uri = $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];

// REQUIRED PHP SCRIPTS
if (file_exists(dirname(__FILE__) . '/settings.php')) {
    require(dirname(__FILE__) . '/settings.php');
} else {
    die('Please copy the settings.php.sample file to settings.php and make changes.');
}
if ($settings['maintenance'] == true) {
    require_once('maintenance.php');
    die();
}

// Error handler
function eh($errno, $errstr) {
    http_response_code(500);
    header("Not-A-CMS-Fail: $errstr");
    error_log("Not A CMS: $errstr");
    die($errstr);
}
set_error_handler('eh');

require('version.php');
require_once('connect.php');

// HEADER
require_once('header.php');

// DISPLAY TITLE IN WINDOW
function title($title) {
    global $print_title;
    $print_title = $title;
};

// CONVERT TIMESTAMP TO PHP DATE
function timestamp2date($timestamp) {
    return date('F j, Y \a\t g:i A', strtotime($timestamp));
}

// CONVERT GROUP ID TO GROUP NAME
function id2group($id) {
    global $db;
    return $db->get_var("SELECT description FROM `groups` WHERE `id` = $id");
}

// CONVERT USERNAME TO USER ID
function username2id($username) {
    global $db;
    return $db->get_var("SELECT id FROM `users` WHERE `username` = '$username'");
}

// CONVERT USER ID TO USERNAME
function id2username($id) {
    global $db;
    return $db->get_var("SELECT username FROM `users` WHERE `id` = $id");
}

// PRINT HEADER
function page_header($name) {
?>
<div class="page-header">
<h1><?php print $name ?></h1>
</div>
<?php
}

// VALID URI
function valid_uri($str) {
    return preg_match('/^(http|https|ftp):\/\/([A-Z0-9][A-Z0-9_-]*(?:\.[A-Z0-9][A-Z0-9_-]*)+):?(\(com|org|net|us)+?\/?/i', $str);
};

// REDIRECT FUNCTION
function redirect($url) {
    global $settings;
    $host = $settings['url'];
    header("Location: https://$host/$url");
};

// PLAIN TEXT PASSWORD TO HASH
function password2hash($password) {
    return sha1(md5($password));
}

// FIND PM USAGE
function pm_usage() {
    global $db, $settings, $user_id;
    if ($group == 1) {
        $max = 'unlimited';
    } else {
        $max = $settings['inbox_limit_member'];
    };
?>
<?php print $db->get_var("SELECT COUNT(*) FROM `personal_messages` WHERE `to_user_id` = $user_id") ?> / <?php print $max ?>
<?php
};

// CHECK NEW MESSAGES IN PRIVATE MESSAGES INBOX
function check_inbox() {
    if ($login == true) {
        $important = 'Nothing important right now.';
        if ($check_count > 0) {
            $important = '<center><strong>
                <a href="?act=inbox">NEW MESSAGE(S)</a>
                </strong></center>';
        };
        if ($check_count_import > 0) {
            $important .= '<center><span class="important">
                <a href="?act=inbox">IMPORTANT MESSAGE(S)</a>
                </span></center>';
        };
        if ($check_count_comment > 0) {
            $important .= '<center><span class="important">
                <a href="?act=profile&action=comment&set=view_comments">NEW COMMENT(S)</a>
                </span></center>';
        };
        print ''.$important.'';
    };
};

function reflink($url, $name, $target) {
    if ($url != '') {
        if ($target == '') {
            print '<a href="'.$url.'" target="'.$target.'">'.$name.'</a>';
        };
        if ($target != '') {
            print '<a href="'.$url.'">'.$name.'</a>';
        };
    };
};
?>
