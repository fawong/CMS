<?php
session_start();

// GLOBAL VARIABLES
$username = $_SESSION['username'];
$firstname = $_SESSION['firstname'];
$lastname = $_SESSION['lastname'];
$group = $_SESSION['group'];

$username = $_GET['username'];
$user_id = $_GET['user_id'];
$id = $_GET['id'];
$page = $_GET['page'];
$action = $_GET['action'];
$id = $_GET['id'];
$path = $_GET['path'];
$file_name = $_GET['filename'];
$dir = $_GET['dir'];
$file = $_GET['file'];

$ip = $_SERVER['REMOTE_ADDR'];

$timestamp = time();

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
require('version.php');
require_once('connect.php');

// HEADER
require_once('header.php');

// DISPLAY TITLE IN WINDOW
function title($title) {
};

// PRINT HEADER
function page_header($name) {
    print '<div class="page-header">
        <h1>' . $name . '</h1>
        </div>
        ';
}
// VALID URL
function valid_url($str) {
    return preg_match('/^(http|https|ftp):\/\/([A-Z0-9][A-Z0-9_-]*(?:\.[A-Z0-9][A-Z0-9_-]*)+):?(\(com|org|net|us)+?\/?/i', $str);
};

// REDIRECT FUNCTION
function redirect($url) {
    header("$url");
};

// FIND TOTAL STORAGE SPACE
function total_message() {
    if($group == 'admin') {
        $max = 'unlimited';
    }; // if($group == 'admin')
    if($group != 'admin') {
        $max = '100';
    }; // if($group != 'admin')
    print $find_number.'/'.$max;
};

// CHECK NEW MESSAGES IN "INBOX" AND NEW COMMENTS IN "USER_COMMENTS"
function check_inbox() {
    if ($_SESSION['login'] == true) {
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

function relink($url, $name, $target) {
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
