<?php 
require_once(dirname(dirname(__FILE__)) . '/functions.php');

if($group_id != 1) {
    redirect("failed.php?id=2");
} else {
    title("Downloads Control Panel");
    page_header("Downloads Control Panel");
?>
Nothing, yet.
<?php
};
require_once(dirname(dirname(__FILE__)) . '/footer.php');
?>
