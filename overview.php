<?php 
require_once('functions.php');
print_r($_SESSION);
if($_SESSION['group'] != 'admin'){
    //redirect("failed.php?id=2");
};
title("Overview of SUPER TESTING");
page_header($cms_name . ' Overview');
?>
<center><strong>Dashboard Version <?php print $cms_version ?></strong></center>
<table class="table">
<tr>
<th><center><strong>Administrator Rights:</strong></center></th>
<th><center><strong>Regular Members Rights:</strong></center></th>
<th><center><strong>Basic Members Rights:</strong></center></th>
</tr>
<tr><td>
<strong>Website Settings:</strong>
<br />
<a href="?act=admin&amp;act2=website_settings">View Website Settings</a>
<br /><br />
<strong>News Posts:</strong>
<br />
<a href="?act=admin&amp;act2=post">Add New News Post</a>
<br />
<br />
<strong>Web Page:</strong>
<br />
<a href="?act=admin&amp;act2=page">Web Page Control Panel</a>
<br />
<a href="?act=admin&act2=create_new_webpage">Add New Web Page</a>
<br /><br />
<strong>Members:</strong>
<br />
<a href="?act=admin&amp;act2=edit_users_list">Edit Members List</a>
<br />
<a href="?act=admin&amp;act2=add_member">Add New Member</a>
<br /><br />
<strong>Download Database:</strong>
<br />
<a href="?act=downloadscontrolpanel&act2=overview">Download Database Control Panel</a>
<br />
<a href="?act=downloadscontrolpanel&amp;act2=overview">Overview</a>
<br />
<a href="?act=downloadscontrolpanel&amp;act2=new_file">Add a New File</a>
<br />
<a href="?act=downloadscontrolpanel&amp;act2=new_category">Add a New Category</a>
</td>
<td>
View and Download Files from Download Database
<br />
Basic Profile Functions
<br />
Personal File Manager
<br />
Inbox / Personal Messaging System
</td>
<td>
View and Download Files from Download Database
<br />
Basic Profile Functions
<br />
Inbox / Personal Messaging System
</td>
</tr>
</table>
<?php
require_once('footer.php');
?>
