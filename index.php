<?php
require_once('functions.php');
if ($_SESSION['login'] == false) {
    $_SESSION['group'] = 'public';
    $_SESSION['rank'] = 'public';
    $_SESSION['username'] = 'Guest';
    $_SESSION['theme'] = 'default';
};

page_header('Nothing here right now');
?>
Coming soon
<?php
// FOOTER
require('footer.php');
?>
