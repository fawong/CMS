<?php 
require_once(dirname(dirname(__FILE__)) . '/functions.php');

if($group_id != 1) {
    redirect("failed.php?id=2");
} else {
    title("$cms_name Settings");
    page_header("$cms_name Settings");
?>
Nothing, yet.
<?php
};
require_once(dirname(dirname(__FILE__)) . '/footer.php');
?>
