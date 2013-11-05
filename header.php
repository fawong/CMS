<!DOCTYPE html>
<html xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="description" content="A very, very simple version of Facebook, MySpace, Gmail, Blogger, Blogspot, all shoved into one." />
<meta name="keywords" content="<?php print $cms_name ?>, <?php print $cms_name ?>.com, blog, forums, Super Testing, SUPER TESTING, SUPER, super, TESTING, testing" />
<meta name="author" content="<?php print $cms_name ?>.com, <?php print $cms_name ?>.com, <?php print $cms_name ?>, <?php print $cms_name ?>" />
<meta name="rating" content="general" />
<meta name="revisit-after" content="5 Days" />
<meta name="robots" content="all" />
<!--
<meta name="copyright" content="Copyright &copy; <?php print ''.date("Y").'-'.(date("Y") + 1).'' ?> <?php print $cms_name ?>. All Rights Reserved." />
<meta name="distribution" content="GLOBAL" />
<meta name="resource-type" content="document" />
-->
<title><?php print $cms_name ?></title>
<?php
if ($action == 'login' || $action == 'register') {
?>
<link rel="stylesheet" type="text/css" href="//<?php print $settings['url'] ?>/themes/default/css/signin.css" media="screen" />
<?php
};
?>
<style type="text/css">
<?php print $row['css'] ?>
</style>
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
<a class="navbar-brand" href="//<?php print $settings['url'] ?>"><img src="<?php print $settings['logo'] ?>" alt="Logo" /></a>
</div>
<div class="navbar-collapse collapse">
<ul class="nav navbar-nav">
<li class="active"><a href="//<?php print $settings['url'] ?>/posts.php">Posts</a></li>
<li><a href="//<?php print $settings['url'] ?>/page.php?page=contact">Contact Us</a></li>
<li><a href="//<?php print $settings['url'] ?>/page.php?page=about">About <?php print $cms_name ?></a></li>
<?php
if ($_SESSION['login'] == true) {
?>
<li class="dropdown">
<a href="#" class="dropdown-toggle" data-toggle="dropdown">Options <b class="caret"></b></a>
<ul class="dropdown-menu">
<li><a href="account.php?action=members_list">View Members List</a></li>
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
<li><a href="//<?php print $settings['url'] ?>/admin/members.php?action=edit_members">Edit Members List</a></li>
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
?>
<li><a href="loginout.php?action=login">Login</a></li>
<li><a href="register.php?action=register">Register</a></li>
<?php
    //<a href="?act=forgot_username/password">Forgot Username and/or Password?</a>';
}
else {
?>
<li><a href="//<?php print $settings['url'] ?>/profile.php?action=view"><?php print $_SESSION['username']; ?></a></li>
<li><a href="//<?php print $settings['url'] ?>/loginout.php?action=logout">Logout</a></li>
<?php
};
?>
</ul>
</div><!--/.nav-collapse -->
</div>
</div>

<!-- Begin page content -->
<div class="container">
