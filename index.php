<?php
require_once('functions.php');
if (!isset($_SESSION['login'])) {
    $_SESSION['group_id'] = -1;
    $_SESSION['username'] = 'Guest';
    $_SESSION['user_id'] = -1;
    $_SESSION['theme'] = 'default';
};

redirect('posts.php');

// FOOTER
require('footer.php');
?>
