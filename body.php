<?php
session_start();
global $error_message;
if($settings['force_block'] == 0) {
    if ($_SESSION['login'] == false) {
        $_SESSION['group'] = 'public';
        $_SESSION['rank'] = 'public';
        $_SESSION['username'] = 'Guest';
        $_SESSION['theme'] = 'default';
    };
?>
<body>
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
          <a class="navbar-brand" href=".">Not A CMS</a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="."><?php print $cms_name ?> Home</a></li>
            <li><a href="?page=contact">Contact Us</a></li>
            <li><a href="?page=about">About <?php print $cms_name ?></a></li>
<?php
    if ($_SESSION['login'] == true && $settings['force_block'] == 0) {
?>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Options <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="index.php?act=account&amp;act2=members_list">View Members List</a></li>
                <li><a href="index.php?act=profile&amp;act2=options">Options</a></li>
<?php
        if ($_SESSION['group'] == 'member') {
?>
                <li><a href="index.php?act=wpcp&amp;act2=page">Web Page Control Panel</a></li>
<?php
        };
        if ($_SESSION['group'] == 'admin' || ($_SESSION['access_file_manager'] == 1 && $settings['force_block'] == 0)) {
?>
                <li><a href="index.php?act=manager">File Manager</a></li>
<?php
        };
?>
                <li><a href="index.php?act=inbox">Inbox</a></li>
<?php
        if ($_SESSION['group'] == 'admin' && $settings['force_block'] == 0) {
?>
                <li class="divider"></li>
                <li class="dropdown-header">Administrator Control Panel</li>
                <li><a href="index.php?act=admin&amp;act2=overview"><?php print $cms_name ?> Overview</a></li>
                <li><a href="index.php?act=admin&amp;act2=post">Add New Post</a></li>
                <li><a href="index.php?act=admin&amp;act2=page">Web Page Control Panel</a></li>
                <li><a href="index.php?act=admin&amp;act2=edit_users_list">Edit Members List</a></li>
                <li><a href="index.php?act=downloadscontrolpanel&amp;act2=overview">Downloads Control Panel</a></li>
              </ul>
<?php
        };
    };
?>
          </ul>
          <ul class="nav navbar-nav navbar-right">
<?php
    if($_SESSION['login'] != true) {
?>
            <li><a href="?act=login">Login</a></li>
            <li><a href="?act=register">Register</a></li>
<?php
        //<a href="index.php?act=forgot_username/password">Forgot Username and/or Password?</a>';
    } //if($_SESSION['login'] != true)
    else {
?>
            <li><a href="?act=profile&act2=view"><?php print $_SESSION['username']; ?></a></li>
            <li><a href="index.php?act=logout">Logout</a></li>
<?php
    };
?>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>

    <!-- Begin page content -->
    <div class="container">
      <div class="page-header">

<?
};//if ($settings['force_block'] == 0)
if (($page == '') && ($settings['force_block'] == 0 || $_SESSION['group'] == 'admin')) {
    require_once('newsandupdates.php');
    check_inbox();
};
if ($_SESSION['group'] != 'admin' && $settings['force_block'] == 1){
    title("Website Under Maintainance");
    print '<h1><center>Website Under Maintainance</center></h1>
        <table class="table">
        <h3><center><strong>
        It will be back up as soon as the maintainance and/or upgrades are done.<br />
        <br />
        Thank you for your patience.</font>
        </strong></center></h3>
        </table>';
};
?>
