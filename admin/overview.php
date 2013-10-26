<?php 
require_once(dirname(dirname(__FILE__)) . '/functions.php');

if($_SESSION['group'] != 'admin') {
    redirect("failed.php?id=2");
} else {
    title("Overview of SUPER TESTING");
    page_header($cms_name . ' Overview');
?>
<div class="row">
<div class="col-md-6">
<h3>Administrator Rights</h3>
<p>View Website Settings</p>
<p>Add New News Post</p>
<p>Web Page Control Panel</p>
<p>Add New Web Page</p>
<p>Edit Members List</p>
<p>Add New Member</p>
<p>Download Database Control Panel</p>
<p>Overview</p>
<p>Add a New File</p>
<p>Add a New Category</p>
</div>
<div class="col-md-6">
<h3>Regular Members Rights</h3>
<p>View and Download Files from Download Database</p>
<p>Basic Profile Functions</p>
<p>Personal File Manager</p>
<p>Inbox / Personal Messaging System</p>
</div>
</div>
<?php
};
require_once(dirname(dirname(__FILE__)) . '/footer.php');
?>
