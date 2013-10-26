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
