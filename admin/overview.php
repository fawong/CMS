<?php 
require_once(dirname(dirname(__FILE__)) . '/functions.php');

if($group != 1) {
    redirect("failed.php?id=2");
} else {
    title("Overview of SUPER TESTING");
    page_header($cms_name . ' Overview');
?>
<div class="row">
<div class="col-md-6">
<h3>Administrator Rights</h3>
<p>View cms settings</p>
<p>Add new post</p>
<p>page control panel</p>
<p>Add new page</p>
<p>Edit members list</p>
<p>Add new member</p>
<p>Download database control panel</p>
<p>Overview</p>
<p>Add a new file</p>
<p>Add a new category</p>
<p>Category</p>
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
