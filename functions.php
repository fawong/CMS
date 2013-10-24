<?php
//DISPLAY TITLE IN WINDOW
/*function title($title) {
//global $website_name;
//global $pagetitle;
//$pagetitle = $title . ' - ' . $website_name;
//$GLOBALS['pagetitle'] = $title . ' - ' . $website_name;
global $pagetitle;
$pagetitle = $title . ' - ' . $website_name;
//$_SESSION['pagetitle'] = $title . ' - ' . $website_name;
//$_SESSION['pagetitle'] = ''.$title.' - '.$website_name.'';
print '
<script type="text/javascript" language="JavaScript">
document.title = "'.$title.' - '.$GLOBALS['website_name'].'";
</script>
';
};
 */
//PRINT HEADER
function page_header($name) {
    print '<h1>' . $name . '</h1></div>';
}
//VALID URL
function valid_url($str){
    return preg_match('/^(http|https|ftp):\/\/([A-Z0-9][A-Z0-9_-]*(?:\.[A-Z0-9][A-Z0-9_-]*)+):?(\(com|org|net|us)+?\/?/i', $str);
    //return(!preg_match('/^(http|https|ftp):\/\/([A-Z0-9][A-Z0-9_-]*(?:\.[A-Z0-9][A-Z0-9_-]*)+):?(\d+)?\/?/i', $str)) ? FALSE : TRUE;
};
//REDIRECT FUNCTION
function redirect($url){
    // func: redirect($to,$code=307)
    // spec: http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html
/*function redirect($to,$code=301)
{
$location = null;
$sn = $_SERVER['SCRIPT_NAME'];
$cp = dirname($sn);
if (substr($to,0,4)=='http') $location = $to; // Absolute URL
else
{
$schema = $_SERVER['SERVER_PORT']=='443'?'https':'http';
$host = strlen($_SERVER['HTTP_HOST'])?$_SERVER['HTTP_HOST']:$_SERVER['SERVER_NAME'];
if (substr($to,0,1)=='/') $location = "$schema://$host$to";
elseif (substr($to,0,1)=='.') // Relative Path
{
$location = "$schema://$host/";
$pu = parse_url($to);
$cd = dirname($_SERVER['SCRIPT_FILENAME']).'/';
$np = realpath($cd.$pu['path']);
$np = str_replace($_SERVER['DOCUMENT_ROOT'],'',$np);
$location.= $np;
if ((isset($pu['query'])) && (strlen($pu['query'])>0)) $location.= '?'.$pu['query'];
}
}

$hs = headers_sent();
if ($hs==false)
{
if ($code==301) header("301 Moved Permanently HTTP/1.1"); // Convert to GET
elseif ($code==302) header("302 Found HTTP/1.1"); // Conform re-POST
elseif ($code==303) header("303 See Other HTTP/1.1"); // dont cache, always use GET
elseif ($code==304) header("304 Not Modified HTTP/1.1"); // use cache
elseif ($code==305) header("305 Use Proxy HTTP/1.1");
elseif ($code==306) header("306 Not Used HTTP/1.1");
elseif ($code==307) header("307 Temporary Redirect HTTP/1.1");
else trigger_error("Unhandled redirect() HTTP Code: $code",E_USER_ERROR);
header("Location: $location");
header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
}
elseif (($hs==true) || ($code==302) || ($code==303))
{
$cover_div_style = 'background-color: #ccc; height: 100%; left: 0px; position: absolute; top: 0px; width: 100%;'; 
echo "<div style='$cover_div_style'>\n";
$link_div_style = 'background-color: #fff; border: 2px solid #f00; left: 0px; margin: 5px; padding: 3px; ';
$link_div_style.= 'position: absolute; text-align: center; top: 0px; width: 95%; z-index: 99;';
echo "<div style='$link_div_style'>\n";
echo "<p>Please See: <a href='$to'>".htmlspecialchars($location)."</a></p>\n";
echo "</div>\n</div>\n";
}
exit(0);
};*/
    print '<meta http-equiv="refresh" content="0; url='.$url.'" />';
/*print '<script type="text/javascript" language="JavaScript">
window.location = "'.$url.'";
</script>';*/
};
//FIND TOTAL STORAGE SPACE
function total_message(){
    if($_SESSION[group] == 'admin'){
        $max = 'unlimited';
    };//if($_SESSION[group] == 'admin')
    if($_SESSION[group] != 'admin'){
        $max = '100';
    };//if($_SESSION[group] != 'admin')
    $find_total = mysql_query("SELECT * FROM `inbox` WHERE `to` = '$_SESSION[username]'") or die(mysql_error());
    $find_number = mysql_num_rows($find_total);
    print $find_number.'/'.$max;
};
//CHECK NEW MESSAGES IN "INBOX" AND NEW COMMENTS IN "USER_COMMENTS"
function check_inbox(){
    if ($_SESSION['login'] == true){
        $check_new_query = mysql_query("SELECT * FROM `inbox` WHERE `to` = '$_SESSION[username]' AND `read` = '0'") or die(mysql_error());
        $check_count = mysql_num_rows($check_new_query);
        $important = 'Nothing important right now.';
        if ($check_count > 0){
            $important = '<center><strong>
                <a href="index.php?act=inbox">NEW MESSAGE(S)</a>
                </strong></center>';
        };
        $check_import_query = mysql_query("SELECT * FROM `inbox` WHERE `to` = '$_SESSION[username]' AND `read` ='0' AND `important` ='1'");
        $check_count_import = mysql_num_rows($check_import_query);
        if ($check_count_import > 0){
            $important .= '<center><span class="important">
                <a href="index.php?act=inbox">IMPORTANT MESSAGE(S)</a>
                </span></center>';
        };
        $check_comment_query = mysql_query("SELECT * FROM `user_comments` WHERE `username` = '$_SESSION[username]' AND `read` = '0'");
        $check_count_comment = mysql_num_rows($check_comment_query);
        if ($check_count_comment > 0){
            $important .= '<center><span class="important">
                <a href="index.php?act=profile&act2=comment&set=view_comments">NEW COMMENT(S)</a>
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
