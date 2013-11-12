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
<title><?php print $cms_name ?></title>
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
$active1 = '<li>';
$active2 = '<li>';
$active3 = '<li>';
if ($uri == '/cms/posts.php') {
    $active1 = '<li class="active">';
} else if ($get_page == 'contact') {
    $active2 = '<li class="active">';
} else if ($get_page == 'about') {
    $active3 = '<li class="active">';
}
?>
<?php print $active1 ?><a href="//<?php print $settings['url'] ?>/posts.php">Posts</a></li>
<?php print $active2 ?><a href="//<?php print $settings['url'] ?>/page.php?page=contact">Contact Us</a></li>
<?php print $active3 ?><a href="//<?php print $settings['url'] ?>/page.php?page=about">About <?php print $cms_name ?></a></li>
<?php
if ($_SESSION['login'] == true) {
?>
<li class="dropdown">
<a href="#" class="dropdown-toggle" data-toggle="dropdown">Options <b class="caret"></b></a>
<ul class="dropdown-menu">
<li><a href="//<?php print $settings['url'] ?>/members.php?action=view">View Members List</a></li>
<li><a href="//<?php print $settings['url'] ?>/admin/settings.php?action=options">Options</a></li>
<li><a href="wpcp.php?action=page">Web Page Control Panel</a></li>
<li><a href="pm.php">Personal Messages</a></li>
<?php
    if ($_SESSION['group'] == 'admin' || $_SESSION['access_file_manager'] == 1) {
?>
<li><a href="?act=manager">File Manager</a></li>
<?php
    };
    if ($_SESSION['group'] == 'admin') {
?>
<li class="divider"></li>
<li class="dropdown-header">Administrator Control Panel</li>
<li><a href="//<?php print $settings['url'] ?>/admin/overview.php"><?php print $cms_name ?> Overview</a></li>
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
if($_SESSION['login'] != true) {
$active4 = '<li>';
$active5 = '<li>';
if ($get_action == 'login') {
    $active4 = '<li class="active">';
} else if ($get_action == 'register') {
    $active5 = '<li class="active">';
}
?>
<?php print $active4 ?><a href="https://<?php print $settings['url'] ?>/loginout.php?action=login">Login</a></li>
<?php print $active5 ?><a href="register.php?action=register">Register</a></li>
<?php
    //<a href="?act=forgot_username/password">Forgot Username and/or Password?</a>';
}
else {
$active6 = '<li>';
$active7 = '<li>';
if ($get_action == 'view') {
    $active6 = '<li class="active">';
} else if ($get_action == 'logout') {
    $active7 = '<li class="active">';
}
?>
<?php print $active6?><a href="//<?php print $settings['url'] ?>/profile.php?action=view"><?php print $_SESSION['username']; ?></a></li>
<?php print $active7?><a href="//<?php print $settings['url'] ?>/loginout.php?action=logout">Logout</a></li>
<?php
};
?>
</ul>
</div><!--/.nav-collapse -->
</div>
</div>

<!-- Begin page content -->
<div class="container">
