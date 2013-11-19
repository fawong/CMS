<?php
require_once('functions.php');
if ($_SESSION['login'] == false) {
    $_SESSION['group'] = -1;
    $_SESSION['username'] = 'Guest';
    $_SESSION['theme'] = 'default';
};

redirect('posts.php');

// FOOTER
require('footer.php');
?>
