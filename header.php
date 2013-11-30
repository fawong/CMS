<!DOCTYPE html>
<html xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="description" content="Not A CMS is not a CMS" />
<meta name="keywords" content="<?php print $cms_name ?>, blog, forums, posts, comments" />
<meta name="author" content="<?php print $cms_name ?>" />
<meta name="rating" content="general" />
<meta name="revisit-after" content="5 Days" />
<meta name="robots" content="all" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!--
<meta name="copyright" content="Copyright &copy; <?php print ''.date("Y").'-'.(date("Y") + 1).'' ?> <?php print $cms_name ?>. All Rights Reserved." />
<meta name="distribution" content="GLOBAL" />
<meta name="resource-type" content="document" />
-->
<title><?php print $cms_name ?> - <?php global $print_title; print $print_title ?></title>
<?php
if ($get_action == 'login' || $get_action == 'register') {
?>
<link rel="stylesheet" type="text/css" href="//<?php print $settings['url'] ?>/themes/default/css/signin.css" media="screen" />
<?php
};
?>
<link href="//<?php print $settings['url'] ?>/themes/default/css/bootstrap.min.css" media="screen" rel="stylesheet" type="text/css" />
<link href="//<?php print $settings['url'] ?>/themes/default/css/navbar.css" media="screen" rel="stylesheet" type="text/css" />
<link rel="shortcut icon" href="/favicon.ico" />
<link rel="icon" type="image/ico" href="/favicon.ico" />
<link rel="shortcut icon" href="/favicon.ico" type="image/x-ico" />
</head>
<body>
<?php
check_inbox();
?>
<div id="wrap">

<!-- Fixed navbar -->
<div class="navbar navbar-default navbar-fixed-top">
<div class="container">
<div class="navbar-header">
<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
<span class="icon-bar"></span>
<span class="icon-bar"></span>
<span class="icon-bar"></span>
</button>
<a class="navbar-brand" href="//<?php print $settings['url'] ?>"><img src="//<?php print $settings['logo'] ?>" alt="Logo" /></a>
</div>
<div class="navbar-collapse collapse">
<ul class="nav navbar-nav">
<?php
$active = '<li>';
if ($ruri == '/cms/posts.php') {
    $active = '<li class="active">';
}
?>
<?php print $active ?><a href="//<?php print $settings['url'] ?>/posts.php">Posts</a></li>
<?php
$links = $db->get_results("SELECT * FROM links");
foreach ($links as $link) {
?>
<li<?php if ($full_uri == preg_replace('@https?://@', '', $link->url)) { print ' class="active"'; } ?>><a href="<?php print $link->url ?>"<?php if ($link->target) { print ' target="'.$link->target.'"'; } ?>><?php print $link->name ?></a></li>
<?php
};
if ($login == true) {
?>
<li class="dropdown">
<a href="#" class="dropdown-toggle" data-toggle="dropdown">Options <b class="caret"></b></a>
<ul class="dropdown-menu">
<li><a href="//<?php print $settings['url'] ?>/members.php">View Members List</a></li>
<li><a href="pm.php">Personal Messages</a></li>
<?php
    if ($group == 1 || $access_file_manager == 1) {
?>
<li><a href="?act=manager">File Manager</a></li>
<?php
    };
    if ($group == 1) {
?>
<li class="divider"></li>
<li class="dropdown-header">Administrator Control Panel</li>
<li><a href="//<?php print $settings['url'] ?>/admin/overview.php"><?php print $cms_name ?> Overview</a></li>
<li><a href="//<?php print $settings['url'] ?>/admin/settings.php">Settings</a></li>
<li><a href="//<?php print $settings['url'] ?>/admin/posts.php?action=new_post">Add New Post</a></li>
<li><a href="//<?php print $settings['url'] ?>/admin/page.php?action=page">Web Page Control Panel</a></li>
<li><a href="//<?php print $settings['url'] ?>/admin/members.php?action=list_members">Edit Members List</a></li>
<li><a href="//<?php print $settings['url'] ?>/admin/dcp.php?action=overview">Downloads Control Panel</a></li>
<?php
    };
?>
</ul>
<?php
};
?>
</ul>
<ul class="nav navbar-nav navbar-right">
<?php
if($login != true) {
    $active2 = '<li>';
    $active3 = '<li>';
    if ($get_action == 'login') {
        $active2 = '<li class="active">';
    } else if ($get_action == 'register') {
        $active3 = '<li class="active">';
    }
?>
<?php print $active2 ?><a href="https://<?php print $settings['url'] ?>/loginout.php?action=login">Login</a></li>
<?php print $active3 ?><a href="register.php?action=register">Register</a></li>
<?php
    //<a href="?act=forgot_username/password">Forgot Username and/or Password?</a>';
    //<li><a href="page.php?action=page">Web Page Control Panel</a></li>
}
else {
    $active4 = '<li>';
    $active5 = '<li>';
    if ($get_action == 'view') {
        $active4 = '<li class="active">';
    } else if ($get_action == 'logout') {
        $active5 = '<li class="active">';
    }
?>
<?php print $active4?><a href="//<?php print $settings['url'] ?>/profile.php?action=view"><?php print $username; ?></a></li>
<?php print $active5?><a href="//<?php print $settings['url'] ?>/loginout.php?action=logout">Logout</a></li>
<?php
};
?>
</ul>
</div><!--/.nav-collapse -->
</div>
</div>

<!-- Begin page content -->
<div class="container">
