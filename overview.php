<?php 
require_once('functions.php');
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
<a href="?act=admin&amp;action=website_settings">View Website Settings</a>
<br /><br />
<strong>News Posts:</strong>
<br />
<a href="?act=admin&amp;action=post">Add New News Post</a>
<br />
<br />
<strong>Web Page:</strong>
<br />
<a href="?act=admin&amp;action=page">Web Page Control Panel</a>
<br />
<a href="?act=admin&action=create_new_page">Add New Web Page</a>
<br /><br />
<strong>Members:</strong>
<br />
<a href="?act=admin&amp;action=edit_users_list">Edit Members List</a>
<br />
<a href="?act=admin&amp;action=add_member">Add New Member</a>
<br /><br />
<strong>Download Database:</strong>
<br />
<a href="?act=downloadscontrolpanel&action=overview">Download Database Control Panel</a>
<br />
<a href="?act=downloadscontrolpanel&amp;action=overview">Overview</a>
<br />
<a href="?act=downloadscontrolpanel&amp;action=new_file">Add a New File</a>
<br />
<a href="?act=downloadscontrolpanel&amp;action=new_category">Add a New Category</a>
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
