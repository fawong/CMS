<?php 
require_once('functions.php');

if ($_SESSION['login'] != true) {
    redirect("failed.php?id=2");
} else {
    // VIEW PROFILE
    if($action == 'view') {
        $comment_count = mysql_num_rows($count_comment);
        if ($_GET['username'] == '') {
            title("View Own Profile");
            page_header('View Own Profile');
            while ($row = mysql_fetch_array($view_user_query)) {
                if ($row[online] == '1') {
                    $status = 'themes/'.$_SESSION[theme].'/images/online.gif';
                };
                if ($row[online] == '0') {
                    $status = 'themes/'.$_SESSION[theme].'/images/offline.gif';
                };
                if ($row[avatar] == '') { //|| !valid_url($row[avatar])) {
                    $avatar = 'themes/'.$_SESSION[theme].'/images/no_avatar.gif';
                } else {
                    $avatar = ''.$row[avatar].'';
                };
?>
<center><img src="<?php print $avatar ?>"></center><br />
<strong>Member User Name:</strong> <?php print $currentusername ?><br />
<strong>Member First Name:</strong> <?php print $currentfirstname ?><br />
<strong>Member Last Name:</strong> <?php print $currentlastname ?><br />
<strong>Member Group:</strong> <?php print $row['group'] ?><br />
<strong>Date Joined:</strong> <?php print $row['date_joined'] ?><br />
<strong>Online Status: </strong><img src="<?php print $status ?>" /><br /><br />
<h2>Statistics:</h2>
<strong>Views:</strong> <?php print $row['views'] ?> <br />
<strong>Comments:</strong> <?php print $comment_count ?><br />
<strong>Positive (+) Reputation:</strong> <?php print $row['kpos'] ?><br />
<strong>Negative (-) Reputation:</strong> <?php print $row['kneg'] ?><br />
<a href="?act=profile&amp;action=reputation&amp;username=<?php print $row['username'] ?>">Change <?php print $currentusername ?>'s Reputation</a><br />
<a href="?act=inbox&amp;action=compose&amp;to=<?php print $row['username'] ?>">Compose New Message</a><br />
<strong>AIM User Name:</strong> <?php print $row['aim'] ?><br />
<strong>About:</strong> <?php print $row['about'] ?><br />
<strong>Interests:</strong> <?php print $row['interests'] ?><br />
<strong>Website:</strong> <a href="<?php print $row['website'] ?>" target="_blank"><?php print $row['website'] ?></a><br />
<strong>Email:</strong> <a href="mailto:<?php print $row['email'] ?>"><?php print $row['email'] ?></a>
<?php
            };
        };
        if ($_GET['username'] != '' && $username != 'Guest') {
            if(mysql_num_rows($view_user_query) == 0) {
                title("Member Does Not Exist");
                print '<h1><center>Member Does Not Exist</center></h1>
                    <center><strong>This member does not exist.</strong></center>';
            } else {
                title("View Profile");
                page_header('View Profile');
                while ($row = mysql_fetch_array($view_user_query)) {
                    if ($row[online] == '1') {
                        $status = 'themes/'.$_SESSION[theme].'/images/online.gif';
                    };
                    if ($row[online] == '0') {
                        $status = 'themes/'.$_SESSION[theme].'/images/offline.gif';
                    };
?>
<center><img src="<?php print $avatar ?>"></center><br />
<strong>Member Username:</strong> <?php print $row[username] ?><br />
<strong>Member First Name:</strong> <?php print $row[first_name] ?><br />
<strong>Member Last Name:</strong> <?php print $row[last_name] ?><br />
<strong>Member Rank:</strong> <?php print $row[rank] ?><br />
<strong>Member Group:</strong> <?php print $row[group] ?><br />
<strong>Date Joined:</strong> <?php print $row[date_joined] ?><br />
<img src="<?php print $status ?>"  /><br /><br />
<h2>Statistics:</h2>
<strong>Profile Views:</strong> <?php print $row[views] ?> <br />
<strong>Number of Comments:</strong> <?php print $comment_count ?><br />
<strong>Positive (+) Reputation:</strong> <?php print $row[kpos] ?><br />
<strong>Negative (-) Reputation:</strong> <?php print $row[kneg] ?><br />
<a href="?act=profile&amp;action=reputation&amp;username=<?php print $_GET[username] ?>">Change <?php print $_GET[username] ?>'s Reputation</a><br />
<a href="?act=inbox&amp;action=compose&amp;to=<?php print $row[username] ?>">Compose New Message</a><br />
<strong>AIM User Name:</strong> <?php print $row[aim] ?><br />
<strong>About:</strong> <?php print $row[about] ?><br />
<strong>Interests:</strong> <?php print $row[interests] ?><br />
<strong>Website:</strong> <a href="<?php print $row[website] ?>" target="_blank"><?php print $row[website] ?></a><br />
<strong>Email:</strong> <a href="mailto:<?php print $row[email] ?>"><?php print $row[email] ?></a><br /><br />
<h2>Add a New Comment:</h2>
<form role="form" class="form-horizontal" action="?act=profile&amp;action=comment&amp;set=add_new_comment&amp;username=<?php print $_GET[username] ?>" method="post">
<textarea name="comment" class="form-control"></textarea><br />
<button type="submit" class="btn">Submit New Comment</button>
</form>
<?php
                };
            };
        };
    };
    //ACCOUNT OVERVIEW
    if ($action == 'options') {
        title("Options");
        while ($row = mysql_fetch_array($find_data)) {
            print '<h1><center>Options</center></h1>
                <hr width="100%" align="center"/>
                <table class="table" align="center">
                <tr><td>
                <strong>Profile Information:</strong><br />
                Views: '.$row[views].' <br />
                Reputation: +'.$row[kpos].'/-'.$row[kneg].'<br /><br />
                Local Time: '.$local_time.'<br />
                Last Logon: '.$row[last_log_on].'<br />
                IP: '.$ip.'<br />
                </td>
                </tr>
                <tr><td>
                <strong>Profile Settings:</strong><br />
                <a href="?act=profile&amp;action=view">View My Profile </a> |
                <a href="?act=profile&amp;action=comment&amp;set=view_comments&amp;username='.$username.'">View Comments</a> |
                <a href="?act=profile&amp;action=edit_profile">Edit Profile</a> |
                <a href="?act=profile&amp;action=change_password">Change Password</a>
                </td></tr>
                </table> ';
        };
    };
    if ($action =='reputation') {
        title("Reputation");
        print '<h1><center>Reputation</center></h1>
            <hr width="100%" align="center"/>
            <table class="table" align="center">
            <tr><td>Would you like to add +rep or -rep?
            <form action="?act=profile&amp;action=change_reputation&amp;username='.$_GET[username].'" method="post">
            <select name="rep"><option value="+rep">Add One (+1) to Reputation</option><option value="-rep">Subtract One (-1) to Reputation</option></select>
            <input type="submit" value="Submit Change in Reputation" />
            </form></td></tr></table>';
    };
    if ($action == 'change_reputation') {
        if ($_POST['rep'] == '+rep') {
            title("Positive (+1) Reputation Given");
            print '<h1><center>Positive (+1) Reputation Given</center></h1>
                <hr width="100%" align="center"/>
                <table class="table" align="center">
                <tr><td>Positive reputation has been given to <strong>'.$_GET[username].'</strong>.<br />
                <a href="?act=profile&amp;action=view&amp;username='.$_GET[username].'">Back to '.$_GET[username].'\'s profile</a>
                </td></tr></table>';
        };
        if ($_POST['rep'] == '-rep') {
            title("Negative (-1) Reputation Given");
            print '<h1><center>Negative (-1) Reputation Given</center></h1>
                <hr width="100%" align="center"/>
                <table class="table" align="center">
                <tr><td>Negative reputation has been given to <strong>'.$_GET[username].'</strong>.<br />
                <a href="?act=profile&amp;action=view&amp;username='.$_GET[username].'">Back to '.$_GET[username].'\'s profile</a>
                </td></tr></table>';
        };
    };
    //EDIT PROFILE
    if ($action == 'edit_profile') {
        if ($set == 'fix') {
            $_SESSION['firstname'] = $_POST['fname'];
            $_SESSION['lastname'] = $_POST['lname'];
            print '<strong>Your profile has been updated.</strong>';
        };
        title("Edit Profile");
        print '<h1><center>Edit Profile</center></h1>
            <hr width="100%" align="center"/>';
        while ($row = mysql_fetch_array($edit_query)) {
            print '<table class="table" align="center">
                <tr><td>
                <form method="post" action="?act=profile&amp;action=edit_profile&amp;set=fix">
                <strong>Username:</strong> '.$row[username].'<br />
                <strong>First Name:</strong><br />
                <input type="text" name="fname" size="65" value="'.$row[first_name].'" /><br />
                <strong>Last Name:</strong><br />
                <input type="text" name="lname" size="65" value="'.$row[last_name].'" /><br />
                <strong>Date Joined:</strong> '.$row[date_joined].' <br />
                <strong>About:</strong><br />
                <textarea name="about" rows="10" cols="56">'.$row[about].'</textarea><br /> 
                <strong>Interests:</strong><br />
                <textarea name="interests" rows="10" cols="56">'.$row[interests].'</textarea><br />
                <strong>Signature:</strong><br />
                <textarea name="signature" rows="10" cols="56">'.$row[signature].'</textarea><br />
                <strong>AIM:</strong><br />
                <input type="text" name="aim" size="65" value="'.$row[aim].'" /><br /> 
                <strong>Email:</strong><br />
                <input type="text" name="email" size="65" value="'.$row[email].'" /><br />
                <strong>Avatar:</strong><br />
                <input type="text" name="avatar" size="65" value="'.$row[avatar].'" /><br />
                <strong>Website:</strong><br />
                <input type="text" name="website" size="65" value="'.$row[website].'" /><br /> 
                <strong>Date of Birth:</strong> '.$row[date_of_birth].'<br />
                <input type="submit" name="submit" value="Save Edited Profile" />
                </form>
                </td></tr>
                </table>';
        };
    };
    //CHANGE PASSWORD
    if ($action == 'change_password') {
        title("Change Password");
        print '<h1><center>Change Password</center></h1>
            <hr width="100%" align="center"/>
            <table class="table" align="center">
            <tr><td>
            <form action="?act=profile&amp;action=submit_change_password" method="post">
            Current Password: <input type="password" name="current_password" value="" /><br />
            New Password: <input type="password" name="new_password" value="" /><br />
            Re-Enter New Password: <input type="password" name="reenter_new_password" value="" /><br />
            <input type="submit" value="Change Password" />
            </form>
            </td></tr></table>';
    };
    //SUBMIT CHANGE PASSWORD
    if ($action == 'submit_change_password') {
        $currentpass = sha1(md5($_POST[current_password]));
        if (mysql_num_rows($query) == 1) {
            if ($_POST[new_password] == $_POST[reenter_new_password]) {
                if ($_POST[new_password] != '') {
                    if ($_POST[reenter_new_password] != '') {
                        $newpass = sha1(md5($_POST[new_password]));
                        $_SESSION['group'] = 'public';
                        $_SESSION['rank'] = 'member';
                        $_SESSION['user_id'] = '0';
                        $_SESSION['username'] = 'guest';
                        $_SESSION['theme'] = 'default';
                        $_SESSION['login'] = false;
                        title("Successfully Changed Password");
                        print '<h1><center>Successfully Changed Password</center></h1>
                            <hr width="100%" align="center"/>
                            <table class="table" align="center">
                            <tr><td>
                            Your password has been changed.<br />
                            You have been logged out of the system.
                            </td></tr>
                            </table>';
                    } else {
                        title("New Password Cannot be Blank");
                        print '<h1><center>New Password Cannot be Blank</center></h1>
                            <hr width="100%" align="center"/>
                            <table class="table" align="center">
                            <tr><td>
                            Your new password cannot be blank.
                            </td></tr>
                            </table>';
                    };
                } //if ($_POST[new_password] != '')
                else {
                    title("New Password Cannot be Blank");
                    print '<h1><center>New Password Cannot be Blank</center></h1>
                        <hr width="100%" align="center"/>
                        <table class="table" align="center">
                        <tr><td>
                        Your new password cannot be blank.
                        </td></tr>
                        </table>';
                };
            } else {
                title("New Passwords Do Not Match");
                print '<h1><center>New Passwords Do Not Match</center></h1>
                    <hr width="100%" align="center"/>
                    <table class="table" align="center">
                    <tr><td>
                    Your new passwords do not match.
                    </td></tr>
                    </table>';
            };
        } else {
            title("Current Password is Incorrect");
            print '<h1><center>Current Password is Incorrect</center></h1>
                <hr width="100%" align="center"/>
                <table class="table" align="center">
                <tr><td>
                Your current password is incorrect.
                </td></tr>
                </table>';
        };
    };
};
require_once('footer.php');
?>
