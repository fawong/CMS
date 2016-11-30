<?php 
require_once('functions.php');

if ($login != true) {
    redirect("failed.php?id=2");
} else {
    // VIEW PROFILE
    if($get_action == 'view') {
        $ui = $user_id;
        if ($get_id) {
            $ui = $get_id;
        };
        if ($user = $db->get_row("SELECT * FROM `users` WHERE `id` = $ui")) {
            title("View Profile");
            page_header('View Profile');
            if ($user->avatar == '') {
                $avatar = 'themes/' . $theme . '/images/no_avatar.gif';
            } else {
                $avatar = $user->avatar;
            };
            if ($user->online == true) {
                $status = 'themes/' . $theme . '/images/online.gif';
            } else {
                $status = 'themes/' . $theme . '/images/offline.gif';
            };
?>
<p><img src="<?php print $avatar ?>"></p>
<p><strong>Member Username:</strong> <?php print $user->username ?></p>
<p><strong>Member First Name:</strong> <?php print $user->first_name ?></p>
<p><strong>Member Last Name:</strong> <?php print $user->last_name ?></p>
<p><strong>Member Group:</strong> <?php print id2group($user->group_id) ?></p>
<p><strong>Date Joined:</strong> <?php print timestamp2date($user->date_joined) ?></p>
<p><img src="<?php print $status ?>" /></p></p>

<h2>Statistics:</h2>
<p><strong>Profile Views:</strong> <?php print $user->views ?> </p>
<p><strong>Positive (+) Reputation:</strong> <?php print $user->kpos ?></p>
<p><strong>Negative (-) Reputation:</strong> <?php print $user->kneg ?></p>
<p><a href="profile.php?action=reputation&amp;username=<?php print $ui ?>">Change <?php print $user->username?>'s Reputation</a></p>
<p><a href="?act=inbox&amp;action=compose&amp;to=<?php print $user->username ?>">Compose New Message</a></p>
<p><strong>AIM User Name:</strong> <?php print $user->aim ?></p>
<p><strong>About:</strong> <?php print $user->about ?></p>
<p><strong>Interests:</strong> <?php print $user->interests ?></p>
<p><strong>Website:</strong> <a href="<?php print $user->website ?>" target="_blank"><?php print $user->website ?></a></p>
<p><strong>Email:</strong> <a href="mailto:<?php print $user->email ?>"><?php print $user->email ?></a></p>
<p><strong>Last Logon:</strong> <?php print timestamp2date($user->last_log_on) ?></p>
<p><strong>Last IP:</strong> <?php print long2ip($user->ip) ?></p>
<?php
        } else {
            title("Member Does Not Exist");
            page_header('Member Does Not Exist');
?>
<p>Member <strong><?php print id2username($get_id) ?></strong> does not exist.</p>
<?php
        };
    };

    // REPUTATION
    if ($get_action == 'reputation') {
        title("Reputation");
        page_header('Reputation');
?>
<h2>Would you like to add +rep or -rep?</h2>
<form action="?action=change_reputation&amp;id=<?php print $get_id ?>" method="post">
<select name="rep" class="form-control">
<option value="+rep">Add One (+1) to Reputation</option>
<option value="-rep">Subtract One (-1) to Reputation</option>
</select>
<button type="submit" class="btn btn-lg btn-primary">Submit Change in Reputation</button>
</form>
<?php
    };

    if ($get_action == 'change_reputation') {
        if ($_POST['rep'] == '+rep') {
            title("Positive (+1) Reputation Given");
            page_header('Positive (+1) Reputation Given');
?>
<p>Positive reputation has been given to <strong><?php print id2username($get_id) ?></strong>.</p>
<?php
        };
        if ($_POST['rep'] == '-rep') {
            title("Negative (-1) Reputation Given");
            page_header('Negative (-1) Reputation Given');
?>
<p>Negative reputation has been given to <strong><?php print id2username($get_id) ?></strong>.</p>
<?php
        };
?>
<a href="?action=view&amp;id=<?php print $get_id ?>">Back to <?php print id2username($get_id) ?>'s profile</a>
<?php
    };

    // SUBMIT EDIT PROFILE
    if ($get_action == 'submit_edit_profile') {
        print '<strong>Your profile has been updated.</strong>';
    };

    // EDIT PROFILE
    if ($get_action == 'edit_profile') {
        title("Edit Profile");
        page_header("Edit Profile");
        $user = $db->get_row("SELECT * FROM `users` WHERE `id` = $user_id");
?>
<form role="form" class="form-horizontal" method="post" action="?&amp;action=edit_profile&amp;set=edit">
<div class="form-group">
<label class="col-sm-2 control-label">Username:</label>
<div class="col-sm-6">
<?php print $user->username; ?>
</div>
</div>
<div class="form-group">
<label class="col-sm-2 control-label">First Name:</label>
<div class="col-sm-5">
<input class="form-control" type="text" name="fname" size="65" value="<?php print $user->first_name; ?>" placeholder="First Name" />
</div>
</div>
<div class="form-group">
<label class="col-sm-2 control-label">Last Name:</label>
<div class="col-sm-5">
<input class="form-control" type="text" name="lname" size="65" value="<?php print $user->last_name; ?>" placeholder="Last Name" />
</div>
</div>
<div class="form-group">
<label class="col-sm-2 control-label">Date Joined:</label>
<div class="col-sm-5">
<?php print $user->date_joined; ?> 
</div>
</div>
<div class="form-group">
<label class="col-sm-2 control-label">About:</label>
<textarea name="about" rows="10" cols="56"><?php print $user->about; ?></textarea> 
</div>
<div class="form-group">
<label class="col-sm-2 control-label">Interests:</label>
<textarea name="interests" rows="10" cols="56"><?php print $user->interests; ?></textarea>
</div>
<div class="form-group">
<label class="col-sm-2 control-label">Signature:</label>
<textarea name="signature" rows="10" cols="56"><?php print $user->signature; ?></textarea>
</div>
<div class="form-group">
<label class="col-sm-2 control-label">AIM:</label>
<input type="text" name="aim" size="65" value="<?php print $user->aim; ?>" /> 
</div>
<div class="form-group">
<label class="col-sm-2 control-label">Email:</label>
<input type="text" name="email" size="65" value="<?php print $user->email; ?>" />
</div>
<div class="form-group">
<label class="col-sm-2 control-label">Avatar:</label>
<input type="text" name="avatar" size="65" value="<?php print $user->avatar; ?>" />
</div>
<div class="form-group">
<label class="col-sm-2 control-label">Website:</label>
<input type="text" name="website" size="65" value="<?php print $user->website; ?>" /> 
</div>
<div class="form-group">
<label class="col-sm-2 control-label">Date of Birth:</label> <?php print $user->date_of_birth; ?>
</div>
<button type="submit" name="submit" class="btn btn-lg btn-primary">Save Edited Profile</button>
</form>
<?php
    };
    // CHANGE PASSWORD
    if ($get_action == 'change_password') {
        title("Change Password");
        page_header('Change Password');
?>
<form role="form" class="form-horizontal" action="?action=submit_change_password" method="post">
<div class="form-group">
<label class="col-sm-2 control-label">Current Password:</label>
<div class="col-sm-6">
<input type="password" name="current_password" class="form-control" placeholder="Current Password">
</div>
</div>
<div class="form-group">
<label class="col-sm-2 control-label">New Password:</label>
<div class="col-sm-6">
<input type="password" name="new_password" class="form-control" placeholder="New Password">
</div>
</div>
<div class="form-group">
<label class="col-sm-2 control-label">Confirm New Password:</label>
<div class="col-sm-6">
<input type="password" name="reenter_new_password" class="form-control" placeholder="Confirm New Password">
</div>
</div>
<button type="submit" class="btn btn-lg btn-primary">Change Password</button>
</form>
<?php
    };
    // SUBMIT CHANGE PASSWORD
    if ($get_action == 'submit_change_password') {
        $currentpass = password2hash($_POST[current_password]);
        if ($db->query("SELECT * FROM `users` WHERE `id` = $user_id AND `password` = '$currentpass'")) {
            if ($_POST[new_password] == $_POST[reenter_new_password]) {
                if ($_POST[new_password] != '' || $_POST[reenter_new_password] != '') {
                    $newpass = password2hash($_POST[new_password]);
                    session_destroy();
                    title("Successfully Changed Password");
                    page_header("Successfully Changed Password");
?>
<p>Your password has been changed.</p>
<p>You have been logged out of the system.</p>
<?php
                } else {
                    title("New Password Cannot be Blank");
                    page_header("New Password Cannot be Blank");
?>
Your new password cannot be blank.
<?php
                };
            } else {
                title("New Passwords Do Not Match");
                page_header("New Passwords Do Not Match");
?>
Your new passwords do not match.
<?php
            };
        } else {
            title("Current Password is Incorrect");
            page_header("Current Password is Incorrect");
?>
Your current password is incorrect.
<?php
        };
    };
};
require_once('footer.php');
?>
