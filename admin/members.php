<?php 
require_once(dirname(dirname(__FILE__)) . '/functions.php');

if ($group != 1) {
    redirect('failed.php?id=2');
} else {
    if ($get_action == 'force_offline') {
        $force_offline = $db->query("UPDATE users SET `online` = '0'");
        page_header('Members forced offine');
?>
All online members have been forced offline.
<?php
    };

    // SUBMIT SAVE MEMBER
    if ($get_action == 'save_member') {
        page_header('Member Updated');
?>
Member <strong><?php print id2username($get_id) ?></strong> has been updated.
<?php
    };

    // SUBMIT ADD NEW MEMBER
    if ($get_action == 'submit_add_member') {
        if ($_REQUEST['yesno'] == 'access_file_manager_yes')
        {
            $access_file_manager_yesorno = 1;
        };
        if ($_REQUEST['yesno'] == 'access_file_manager_no')
        {
            $access_file_manager_yesorno = 0;
        };
        $alphanumeric = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $activation_code = substr(str_shuffle($alphanumeric), 0, 15);
        print 'Member <strong>'.$_POST[username].'</strong> has been added.';
        if ($access_file_manager_yesorno == '1') {
            //mkdir('/hfiles/'.$get_username, 0755);
            print '<br />Member <strong>'.$get_username.'\'s</strong> folder has been created.';
        };
    };

    // LIST MEMBERS
    if ($get_action == 'list_members') {
        if ($users = $db->get_results("SELECT * FROM `users` ORDER BY `group_id` ASC, `username` ASC")) {
            title("Members");
            page_header('Members');
?>
<p><a href="?action=add_member">Add a Member</a></p>
<p><a href="?action=force_offline">Force All Members Offline</a></p>
<p>Total Number of Members: <?php print $db->num_rows ?></p>
<table class="table">
<tr>
<td><strong>User ID</strong></td>
<td><strong>Username</strong></td>
<td><strong>Group</strong></td>
<td><strong>Online</strong></td>
<td><strong>Activated</strong></td>
<td><strong>File Manager Access</strong></td>
<td><strong>View | Edit | Delete</strong></td>
</tr>
<?php
            foreach ($users as $user) {
?>
<tr>
<td><?php print $user->id ?></td>
<td><?php print $user->username ?></td>
<td>
<?php print id2group($user->group_id) ?>
</td>
<td>
<?php print $user->online ? 'Yes' : 'No' ?>
</td>
<td>
<?php print $user->activated_account ? 'Yes' : 'No' ?>
</td>
<td>
<?php print $user->access_file_manager ? 'Yes' : 'No' ?>
</td>
<td>
<a href="//<?php print $settings['url'] ?>/profile.php?action=view&amp;id=<?php print $user->id ?>">View</a> | 
<a href="?action=edit_member&amp;id=<?php print $user->id ?>">Edit</a> | 
<a href="?action=delete_member&amp;id=<?php print $user->id ?>">Delete</a>
</td>
</tr>
<?php
            };
?>
</table>
<?php
        };
    };

    // ADD NEW MEMBER
    if ($get_action == 'add_member') {
        title("Add New Member");
        $alphanumeric = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $activation_code = substr(str_shuffle($alphanumeric), 0, 15);
?>
<h1><center>Add New Member</center></h1>
<hr width="100%"/>
<table class="table">
<tr><td>
<form method="post" action="?act=admin&amp;action=edit_users_list&amp;set=add">
<table class="table" width="100%">
<tr>
<td>
<strong>First Name:</strong><br />
<input type="text" name="first_name" size="65" /><br />
<strong>Last Name:</strong><br />
<input type="text" name="last_name" size="65" /><br />
<strong>Username:</strong><br />
<input type="text" name="username" size="65" /><br />
<strong>Password:</strong><br />
<input type="password" name="password" size="65" /><br />
<strong>Date Created:</strong><br />
<?php print $timestamp ?><br />
<strong>Group:</strong><br />
<select>
<option>oiklkjljdf</option>
<option>ljdf</option>
<option>egraergerjggerdregf</option>
<option>ajdf</option>
</select>
<input type="text" name="group" /><br /> 
<strong>Activation Code:</strong><br />
<input type="text" name="activationcode" value="<?php print $activation_code ?>" maxlength="15" readonly="readonly" /><br />
<strong>Activated Account:</strong><br />
<input type="text" name="activatedaccount" /><br />  
<strong>About:</strong><br />
<textarea name="about" rows="10" cols="50"></textarea><br /> 
<strong>Interests:</strong><br /> 
<textarea name="interests" rows="10" cols="50"></textarea><br />
<strong>Signature:</strong><br /> 
<textarea name="signature" rows="10" cols="50"></textarea><br />
<strong>AIM:</strong><br />
<input type="text" name="aim" size="65" /><br /> 
<strong>Email:</strong><br />
<input type="text" name="email" size="65"/><br />
<strong>Website:</strong><br />
<input type="text" name="website" size="65" /><br /> 
<strong>Avatar:</strong><br />
<input type="text" name="avatar" size="65" /><br />
<strong>Date of Birth (mm/dd/yyyy):</strong><br />
<input type="text" name="dateofbirth" maxlength="10" size="10"/><br />
<!--<strong>Website Theme:</strong><br />
<input type="text" name="theme" value="default" /> *DISABLED<br />-->
<strong>Access File Manager:</strong><br />
<input type="radio" name="yesno" value="access_file_manager_yes"/>Yes<br />
<input type="radio" name="yesno" value="access_file_manager_no"/>No<br />
IP: <?php print $ip ?><br />
<input type="submit" name="submit" value="Create Member" />
</td>
</tr>
</table>
</form>
</td></tr></table>';
<?php
    };

    // EDIT MEMBER
    if ($get_action == 'edit_member') {
        title("Edit Member");
        if ($user = $db->get_row("SELECT * FROM users WHERE id = '$get_id'")) {
            page_header('Edit Member');
?>
<form method="post" action="?action=save_member&amp;username=<?php print $user->username ?>&amp;id=<?php print $user->id ?>">
<div class="form-group">
<label>Username:</label>
<input type="text" name="username" class="form-control" value="<?php print $user->username ?>" disabled/>
</div>
<div class="form-group">
<label>First Name:</label>
<input type="text" name="first_name" class="form-control" value="<?php print $user->first_name ?>" />
</div>
<div class="form-group">
<label>Last Name:</label>
<input type="text" name="last_name" class="form-control" value="<?php print $user->last_name ?>" />
</div>
<div class="form-group">
<label>Date Joined:</label>
<?php print $user->date_joined ?> 
</div>
<div class="form-group">
<label>Group:</label>
<div class="checkbox">
<label>
<input name="group" type="radio" value="<?php print $user->group_id ?>" checked/> 
<?php print id2group($user->group_id) ?>
</label>
</div>
</div>
<div class="form-group">
<label>Activation Code:</label>
<?php print $user->activation_code ?>
</div>
<div class="form-group">
<label>Activated Account:</label>
<?php print $user->activated_account ?>
</div>
<div class="form-group">
<label>About:</label>
<textarea name="about" class="form-control"><?php print $user->about ?></textarea> 
</div>
<div class="form-group">
<label>Interests:</label>
<textarea name="interests" class="form-control"><?php print $user->interests ?></textarea>
</div>
<div class="form-group">
<label>Signature:</label>
<textarea name="signature" class="form-control"><?php print $user->signature ?></textarea>
</div>
<div class="form-group">
<label>AIM:</label>
<input type="text" name="aim" class="form-control" value="<?php print $user->aim ?>" /> 
</div>
<div class="form-group">
<label>Email:</label>
<input type="text" name="email" class="form-control" value="<?php print $user->email ?>" />
</div>
<div class="form-group">
<label>Website:</label>
<input type="text" name="website" class="form-control" value="<?php print $user->website ?>" /> 
</div>
<div class="form-group">
<label>Avatar:</label>
<input type="text" name="avatar" class="form-control" value="<?php print $user->avatar ?>" />
</div>
<div class="form-group">
<label>Date of Birth:</label>
<input type="text" name="date_of_birth" class="form-control" value="<?php print $user->date_of_birth ?>" />
</div>
<div class="form-group">
<label>Website Theme:</label>
<select class="form-control">
<option name="theme" value="<?php print $user->theme ?>"><?php print $user->theme ?></option>
</select>
</div>
<div class="form-group">
<label>Access File Manager:</label>
<?php print $user->access_file_manager ?>
</div>
<div class="form-group">
<label>Last Log On:</label>
<?php print $user->last_log_on ?>
</div>
<div class="form-group">
<label>IP:</label>
<?php print long2ip($user->ip) ?>
</div>
<button type="submit" name="submit" class="btn btn-lg btn-primary">Edit Member</button>
</div>
</form>
<?php
        };
    };

    // DELETE MEMBER
    if ($get_action == 'delete_member') {
        title("Delete Member");
        page_header('Delete Member');
?>
<form role="form" action="?action=submit_delete_member&amp;id=<?php print $get_id ?>" method="post">
<p><strong>Are you sure you want to delete user <?php print $get_id ?>?</strong></p>
<button type="submit" class="btn btn-lg btn-primary">Yes</button>
<button type="button" class="btn btn-lg" onclick="history.go(-1)">No</button>
</form>
<?php
    };

    // SUBMIT DELETE MEMBER
    if ($get_action == 'submit_delete_member') {
        $db->query("DELETE FROM `users` WHERE `id` = '$get_id'");
        page_header('Member deleted');
?>
Member <strong><?php print id2username($get_id) ?></strong> has been deleted.
<?php
    };
    require_once(dirname(dirname(__FILE__)) . '/footer.php');
};
?>
