<?php 
require_once(dirname(dirname(__FILE__)) . '/functions.php');

if ($group != 'admin') {
    redirect('failed.php?id=2');
} else {
    if($action == 'force_offline') {
        $find_people = mysql_query("SELECT * FROM users");
        while($row = mysql_fetch_array($find_people)) {
            if($local_time > $row['last_logged_on']) {
                $force_offline = mysql_query("UPDATE users SET `online` = '0'");
            };
        };
        print 'All online members have been forced offline.';
    };

    // SUBMIT SAVE MEMBER
    if($action == 'save_member') {
        $alphanumeric = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $activation_code = substr(str_shuffle($alphanumeric), 0, 15);
        $fixmysqldatabase = mysql_query("UPDATE `users` SET `first_name` = '$_POST[first_name]', `last_name` = '$_POST[last_name]', `user_group` = '$_POST[group]', `aim` = '$_POST[aim]', `about` = '$_POST[about]', `website` = '$_POST[website]', `signature` = '$_POST[signature]', `interests` = '$_POST[interests]', `activation_code` = '$activation_code', `activated_account` = '$_POST[activatedaccount]', `theme` = '$_POST[theme]', `access_file_manager` = '$_POST[access_file_manager]',  `username`='$_POST[username]', `date_of_birth`='$_POST[date_of_birth]', `email`='$_POST[email]', `avatar`='$_POST[avatar]' WHERE `users`.`user_id` = '$user_id' LIMIT 1") or die(mysql_error());
        print 'Member <strong>'.$requestusername.'</strong> has been updated.';
    };

    // SUBMIT ADD NEW MEMBER
    if($action == 'add') {
        if ($_REQUEST['yesno'] == 'access_file_manager_yes')
        {
            $access_file_manager_yesorno = 1;
        };
        if ($_REQUEST['yesno'] == 'access_file_manager_no')
        {
            $access_file_manager_yesorno = 0;
        };
        $new_user_id = rand(00000, 99999);
        $alphanumeric = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $activation_code = substr(str_shuffle($alphanumeric), 0, 15);
        $mysql_add_text = "INSERT INTO `users` (`first_name`, `last_name`, `user_id`, `user_group`, `username`, `password`, `activation_code`, `access_file_manager`, `date_of_birth` , `ip`, `activated_account`, `date_joined`, `email`, `about`, `website`, `interests`, `aim`, `signature`, `avatar`, `last_log_on`) VALUES ('$first_name', '$last_name', '$new_user_id', '$_POST[group]', '$_POST[username]', '$_POST[password]', '$activation_code', '$access_file_manager_yesorno', '$_POST[dateofbirth]' , '$ip', '$_POST[activatedaccount]', '$local_time', '$_POST[email]', '$_POST[about]', '$_POST[website]', '$_POST[interests]', '$_POST[aim]', '$_POST[signature]', '$_POST[avatar]', 'never')";
        $mysql_add_query_bu = mysql_query($mysql_add_text) or die(mysql_error()); 
        print 'Member <strong>'.$_POST[username].'</strong> has been added.';
        if($access_file_manager_yesorno == '1') {
            mkdir('/home/waf/public_html/st/files/'.$requestusername, 0755);
            print '<br />Member <strong>'.$requestusername.'\'s</strong> folder has been created.';
        };
    };

    // EDIT MEMBERS
    if($action == 'edit_members') {
        $select_all_members = mysql_query("SELECT * FROM `users` ORDER BY `user_group` ASC, `username` ASC") or die (mysql_error());
        $totalnumberofmembers = mysql_num_rows($select_all_members) or die (mysql_error());
        title("Edit Members");
        page_header('Edit Members');
?>
<p><a href="?act=admin&amp;action=add_member">Add a Member</a></p>
<p><a href="?act=admin&amp;action=edit_users_list&amp;set=force_offline">Force All Members Offline</a></p>
<p>Total Number of Members: <?php print $totalnumberofmembers ?></p>
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
        while($row = mysql_fetch_array($select_all_members)) {
?>
<tr>
<td><?php print sprintf('%05s', $row['user_id']) ?></td>
<td><?php print $row['username'] ?></td>
<td>
<?php print $row['user_group'] ?>
</td>
<td>
<?php print $row['online'] ?>
</td>
<td>
<?php print $row['activated_account'] ?>
</td>
<td>
<?php print $row['access_file_manager'] ?>
</td>
<td>
<a href="?act=profile&amp;action=view&amp;username=<?php print$row['username'] ?>">View</a> | 
<a href="?action=edit_user&amp;user_id=<?php print$row['user_id'] ?>">Edit</a> | 
<a href="?action=delete_member&amp;username=<?php print$row['username'] ?>">Delete</a>
</td>
</tr>
<?php
        };
?>
</table>
<?php
    };

    // ADD NEW MEMBER
    if($action == 'add_member') {
        title("Add New Member");
        $alphanumeric = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $activation_code = substr(str_shuffle($alphanumeric), 0, 15);
        print '<h1><center>Add New Member</center></h1>
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
            '.$current_date.'<br />
            <strong>Group:</strong><br />
            <select>
            <option>oiklkjljdf</option>
            <option>ljdf</option>
            <option>egraergerjggerdregf</option>
            <option>ajdf</option>
            </select>
            <input type="text" name="group" /><br /> 
            <strong>Activation Code:</strong><br />
            <input type="text" name="activationcode" value="'.$activation_code.'" maxlength="15" readonly="readonly" /><br />
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
            IP: '.$ip.'<br />
            <input type="submit" name="submit" value="Create Member" />
            </td>
            </tr>
            </table>
            </form>
            </td></tr></table>';
    };

    // EDIT MEMBER
    if($action == 'edit_user') {
        title("Edit Member");
        $edit_query = mysql_query("SELECT * FROM users WHERE user_id = '$user_id'");
        while($row = mysql_fetch_array($edit_query)) {
            print '<h1><center>Edit Member</center></h1>
                <hr width="100%"/>
                <table class="table">
                <tr><td>
                <form method="post" action="?act=admin&amp;action=edit_users_list&amp;set=save_member&amp;username='.$row[username].'&amp;user_id='.$user_id.'">
                <table class="table" width="100%">
                <tr>
                <td>
                <strong>First Name:</strong><br />
                <input type="text" name="first_name" size="65" value="'.$row[first_name].'" /><br />
                <strong>Last Name:</strong><br />
                <input type="text" name="last_name" size="65" value="'.$row[last_name].'" /><br />
                <strong>Username:</strong><br />
                <input type="text" name="username" size="65" value="'.$row[username].'" /><br />
                <strong>Date Joined:</strong><br />'.$row[date_joined].' <br />
                <strong>Group:</strong><br />
                <input type="text" name="group" value="'.$row[group].'" /><br /> 
                <strong>Activation Code:</strong><br />
                '.$row[activation_code].'<br />
                <strong>Activated Account:</strong> ';
            if($row[activated_account] == 1) {
                $aa = "Yes";
            };
            if($row[activated_account] == 0) {
                $aa = "No";
            };
            print ''.$aa.'<br />  
                <strong>About:</strong><br />
                <textarea name="about" rows="10" cols="50">'.$row[about].'</textarea><br /> 
                <strong>Interests:</strong><br />
                <textarea name="interests" rows="10" cols="50">'.$row[interests].'</textarea><br />
                <strong>Signature:</strong><br />
                <textarea name="signature" rows="10" cols="50">'.$row[signature].'</textarea><br />
                <strong>AIM:</strong><br />
                <input type="text" name="aim" size="65" value="'.$row[aim].'" /><br /> 
                <strong>Email:</strong><br />
                <input type="text" name="email" size="65" value="'.$row[email].'" /><br />
                <strong>Website:</strong><br />
                <input type="text" name="website" size="65" value="'.$row[website].'" /><br /> 
                <strong>Avatar:</strong><br />
                <input type="text" name="avatar" size="65" value="'.$row[avatar].'" /><br />
                <strong>Date of Birth:</strong><br />
                <input type="text" name="date_of_birth" maxlength="10" value="'.$row[date_of_birth].'" /><br />
                <strong>Website Theme:</strong><br />
                <input type="text" name="theme" value="'.$row[theme].'" /><br />
                <strong>Access File Manager:</strong> ';
            if($row[access_file_manager] == 1) {
                $afm = "Yes";
            };
            if($row[access_file_manager] == 0) {
                $afm = "No";
            };
            print ''.$afm.' <br />
                1 = Yes<br />
                0 = No<br />
                Last Log On: '.$row[last_log_on].'<br />
                IP: '.$row[ip].'<br />
                <input type="submit" name="submit" value="Edit Member"/>
                </td>
                </tr>
                </table>
                </form>
                </td></tr></table>';
        };
    };

    // DELETE MEMBER
    if($action == 'delete_member') {
        title("Delete Member");
        page_header('Delete Member');
?>
<form role="form" action="?action=submit_delete_member&amp;username=<?php print $requestusername ?>" method="post">
<p><strong>Are you sure you want to delete user <?php print $requestusername ?>?</strong></p>
<button type="submit" class="btn btn-lg btn-primary">Yes</button>
<button type="button" class="btn btn-lg" onclick="history.go(-1)">No</button>
</form>
<?php
    };

    // SUBMIT DELETE MEMBER
    if($action == 'submit_delete_member') {
        $query = mysql_query("DELETE FROM `users` WHERE `username` = '$requestusername'") or die(mysql_error());
        page_header('Member deleted');
?>
Member <strong><?php print $requestusername ?></strong> has been deleted.
<?php
    };
    require_once(dirname(dirname(__FILE__)) . '/footer.php');
};
?>
