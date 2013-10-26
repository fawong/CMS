<?php
session_start();

// GLOBAL VARIABLES
$currentusername = $_SESSION['username'];
$currentfirstname = $_SESSION['firstname'];
$currentlastname = $_SESSION['lastname'];
$requestusername = $_GET['username'];
$user_id = $_GET['user_id'];
$requestid = $_GET['id'];
$page = $_GET['page'];
$act = $_GET['act'];
$action = $_GET['action'];
$set = $_GET['set'];
$set2 = $_GET['set2'];
$id = $_GET['id'];
$cmd = $_GET['cmd'];
$cpath = $_GET['cpath'];
$file_name = $_GET['filename'];
$dir = $_GET['dir'];
$file = $_GET['file'];
$ip = $_SERVER['REMOTE_ADDR'];
$tick = $_GET['tick'];
$timestamp = date("r");
$current_date = date('F j, Y');
$current_time = date('g:i:s A');
$local_timezone = date("O"); 
$time = time(); 
$local_time = date("l, F d, Y \a\\t h:i:s A");

// REQUIRED PHP SCRIPTS
if (file_exists(dirname(__FILE__) . '/settings.php')) {
    require(dirname(__FILE__) . '/settings.php');
} else {
    die('Please copy the settings.php.sample file to settings.php and make changes.');
}
require('version.php');
require_once('connect.php');
require_once('functions.php');

// HEADER
require_once('header.php');

// BODY
require_once('body.php');

// DISPLAY TITLE IN WINDOW
function title($title) {
};
// PRINT HEADER
function page_header($name) {
    print '<h1>' . $name . '</h1>
        </div>
        ';
}
// VALID URL
function valid_url($str){
    return preg_match('/^(http|https|ftp):\/\/([A-Z0-9][A-Z0-9_-]*(?:\.[A-Z0-9][A-Z0-9_-]*)+):?(\(com|org|net|us)+?\/?/i', $str);
};
// REDIRECT FUNCTION
function redirect($url){
    print '<meta http-equiv="refresh" content="0; url='.$url.'" />';
};
// FIND TOTAL STORAGE SPACE
function total_message(){
    if($_SESSION[group] == 'admin'){
        $max = 'unlimited';
    }; // if($_SESSION[group] == 'admin')
    if($_SESSION[group] != 'admin'){
        $max = '100';
    }; // if($_SESSION[group] != 'admin')
    $find_total = mysql_query("SELECT * FROM `inbox` WHERE `to` = '$username'") or die(mysql_error());
    $find_number = mysql_num_rows($find_total);
    print $find_number.'/'.$max;
};
// CHECK NEW MESSAGES IN "INBOX" AND NEW COMMENTS IN "USER_COMMENTS"
function check_inbox(){
    if ($_SESSION['login'] == true){
        $check_new_query = mysql_query("SELECT * FROM `inbox` WHERE `to` = '$username' AND `read` = '0'") or die(mysql_error());
        $check_count = mysql_num_rows($check_new_query);
        $important = 'Nothing important right now.';
        if ($check_count > 0){
            $important = '<center><strong>
                <a href="?act=inbox">NEW MESSAGE(S)</a>
                </strong></center>';
        };
        $check_import_query = mysql_query("SELECT * FROM `inbox` WHERE `to` = '$username' AND `read` ='0' AND `important` ='1'");
        $check_count_import = mysql_num_rows($check_import_query);
        if ($check_count_import > 0){
            $important .= '<center><span class="important">
                <a href="?act=inbox">IMPORTANT MESSAGE(S)</a>
                </span></center>';
        };
        $check_comment_query = mysql_query("SELECT * FROM `user_comments` WHERE `username` = '$username' AND `read` = '0'");
        $check_count_comment = mysql_num_rows($check_comment_query);
        if ($check_count_comment > 0){
            $important .= '<center><span class="important">
                <a href="?act=profile&action=comment&set=view_comments">NEW COMMENT(S)</a>
                </span></center>';
        };
        print ''.$important.'';
    };
};
/*function img_comments($id){
$find = mysql_query("SELECT * FROM img_comment WHERE `img_id` ='$id'");
$count_comments = mysql_num_rows($find);
print $count_comments;
};
function relink($url, $name, $target){
if ($url != ''){
if ($target == ''){
print '<a href="'.$url.'" target="'.$target.'">'.$name.'</a>';
};
if ($target != ''){
print '<a href="'.$url.'">'.$name.'</a>';
};
};
};
if (!isset($_SESSION['dead_time'])){ $_SESSION['dead_time'] = time() + 1440;};
if ($curr_time >= $_SESSION[dead_time])
{
$find_people = mysql_query("SELECT * FROM members WHERE `online` = '1'");
while ($row = mysql_fetch_array($find_people))
{
$update_stats = mysql_query("UPDATE members SET `online` = '0' WHERE `username` ='$row[username]'");
};
};*/
?>
