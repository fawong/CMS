<?php 
if ($act == 'profile'){
    if ($_SESSION['login'] != true){
        redirect("failed.php?id=2");
    };
    if ($_SESSION['login'] == true){
        //VIEW PROFILE
        if($action == 'view'){
            $count_comment = mysql_query("SELECT * FROM user_comments WHERE `username` = '$username'");
            $comment_count = mysql_num_rows($count_comment);
            if ($_GET['username'] == ''){
                title("View Own Profile");
                page_header('View Own Profile');
                $view_user_query = mysql_query("SELECT * FROM `users` WHERE `username` = '$currentusername' LIMIT 1") or die(mysql_error());
                while ($row = mysql_fetch_array($view_user_query)){
                    if ($row[online] == '1'){
                        $status = 'themes/'.$_SESSION[theme].'/images/online.gif';
                    }; //if ($row[online] == '1')
                    if ($row[online] == '0'){
                        $status = 'themes/'.$_SESSION[theme].'/images/offline.gif';
                    }; //if ($row[online] == '0')
                    $update_views = mysql_query("UPDATE users SET views = views+1 WHERE `username` = '$row[username]'");
                    if ($row[avatar] == ''){ //|| !valid_url($row[avatar])){
                        $avatar = 'themes/'.$_SESSION[theme].'/images/no_avatar.gif';
                    } //if ($row[avatar] == '')
                    else{
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
                }; //if ($_GET['username'] == '')
            };
            if ($_GET['username'] != '' && $username != 'Guest'){
                $view_user_query = mysql_query("SELECT * FROM `users` WHERE `username` = '$_GET[username]' LIMIT 1") or die(mysql_error());
                if(mysql_num_rows($view_user_query) == 0){
                    title("Member Does Not Exist");
                    print '<h1><center>Member Does Not Exist</center></h1>
                        <center><strong>This member does not exist.</strong></center>';
                } //if(mysql_num_rows($view_user_query) == 0)
                else{
                    title("View Profile");
                    page_header('View Profile');
                    while ($row = mysql_fetch_array($view_user_query)){
                        if ($row[online] == '1'){
                            $status = 'themes/'.$_SESSION[theme].'/images/online.gif';
                        }; //if ($row[online] == '1')
                        if ($row[online] == '0'){
                            $status = 'themes/'.$_SESSION[theme].'/images/offline.gif';
                        }; //if ($row[online] == '0')
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
                    }; //while ($row = mysql_fetch_array($view_user_query))
                };
            }; //if ($_GET[username] != '' && $username != 'Guest')
        }; //if($action == 'view')
        //ACCOUNT OVERVIEW
        if ($action == 'options'){
            title("Options");
            $count_comment = mysql_query("SELECT * FROM user_comments WHERE `username` = '$username'");
            $comment_count = mysql_num_rows($count_comment);
            $find_data = mysql_query("SELECT * FROM `users` WHERE `username` = '$username'");
            while ($row = mysql_fetch_array($find_data)){
                print '<h1><center>Options</center></h1>
                    <hr width="100%" align="center"/>
                    <table class="table" align="center">
                    <tr><td>
                    <strong>Profile Information:</strong><br />
                    Views: '.$row[views].' <br />
                    Comments: '.$comment_count.'<br />
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
/*<a href="?act=profile&amp;action=upload_photo">Upload Photo</a> |
<a href="?act=profile&amp;action=view_album&amp;username='.$username.'">View Photo Album</a> |*/
        //COMMENT FUNCTIONS
        if ($action == 'comment'){
            //ADD NEW COMMENT
            if ($set == 'add_new_comment'){
                if ($_POST[comment] != ''){
                    $save_comment = mysql_query("INSERT INTO user_comments (`id`, `username`, `post`, `date`, `time`, `read`) VALUES ('$user_id', '$currentusername', '$_POST[comment]', '$current_date', '$current_time', 0)") or die(mysql_error());
                    title("Comment Saved");
                    print '<h1><center>Comment Saved</center></h1>
                        <hr width="100%" align="center"/>
                        <table class="table" align="center">
                        <tr><td>
                        The comment has been saved.<br />
                        <a href="?act=profile&amp;action=view&amp;username='.$currentusername.'">Back to <strong>'.$currentusername.'\'s</strong> profile</a>
                        </td></tr>
                        </table>';
                }else{
                    print '<span class = "important">error</span>';
                };
            };
            //VIEW COMMENTS
            if ($set == 'view_comments'){
                title("View Comments");
                $find_new_comments = mysql_query("SELECT * FROM `user_comments` WHERE `username` = '$username' ORDER BY username DESC");
                //DELETE COMMENTS
                if($set2 == 'delete_comment'){
                    title("Delete Comment");
                    if($requestid != ''){
                        if($set3 == 'delete'){
                            $delete_query = mysql_query("DELETE FROM `user_comments` WHERE `id` = '$requestid'");
                            print '<strong>The comment has been deleted.</strong><br />';
                        };
                        $post_select = mysql_query("SELECT * FROM `user_comments` WHERE `id` = '$requestid'") or die(mysql_error());
                        while($row = mysql_fetch_array($post_select)){
                            print '<h1><center>Delete Comment</center></h1>
                                <hr width="100%" align="center"/>
                                <table class="table" align="center">
                                <tr><td>
                                <div align="center">
                                <font size="+1"><strong>Posted by: <a href="?act=profile&amp;action=view&amp;username='.$row[username].'">'.$row[username].'</a>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Date: '.$row[date].'</strong></font>
                                </div>
                                </td></tr>
                                <tr><td>
                                <div align="left">'.$row[post].'</div>
                                </td></tr>
                                </table>
                                <hr width="100%" align="center"/>
                                <table class="table" align="center">
                                <tr><td>
                                <strong>Are you sure you want to delete this comment?</strong><br />
                                <form action="?act=profile&amp;action=comment&amp;set=view_comments&amp;set2=delete_comment&amp;set3=delete&amp;id='.$row[id].'" method="post">
                                <input type="submit" value="Yes" /><input type="button" onclick="history.go(-1)" value="No" />
                                </form>
                                </td></tr>
                                </table>';
                        };
                    }else{print 'ID NUMBER';};
                };
                if(mysql_num_rows($find_new_comments) == 1){
                    if($id == ''){
                        $get_all_comment = mysql_query("SELECT * FROM user_comments WHERE `username` = '$username'");
                        $get_comment_count = mysql_num_rows($get_all_comment);
                        title("View Comments");
                        print '<h1><center>View Comments</center></h1>
                            <hr width="100%" align="center"/>
                            <table class="table" align="center">
                            <tr><td>
                            Viewing Comments '.$get_comment_count.' of '.$get_comment_count.'
                            </td></tr></table>';
                        $find_avatar = mysql_query("SELECT `avatar` FROM `users` WHERE `username` = '$username' LIMIT 1");
                        while($row = mysql_fetch_array($find_avatar)){
                            if ($row[avatar] == ''){  //|| !valid_url('$row[avatar]')){
                                $avatar = 'themes/'.$_SESSION[theme].'/images/no_avatar.gif';
                            }
                            else{
                                $avatar = $row[avatar];
                            };
                        }; //while($row = mysql_fetch_array($find_avatar))
                        while($row = mysql_fetch_array($find_new_comments)){
                            $set_read = mysql_query("UPDATE `user_comments` SET `read` = '1' WHERE `username` = '$username' AND `read` = '0'");
                            print '<table class="table" align="center"><tr>
                                <td><center>
                                <a href="?act=profile&amp;action=view&amp;username='.$row[username].'">'.$row[username].'<br />
                                <img src="'.$avatar.'" /></a>
                                </center></td></tr>
                                <tr><td>Posted on '.$row[date].' at '.$row[time].'</td>
                                <tr><td>'.$row[post].'</td></tr>
                                <tr><td><div align="right">
                                <a href="?act=profile&amp;action=comment&amp;set=edit_comment&amp;id='.$row[id].'">Edit Comment</a> –
                                <a href="?act=profile&amp;action=comment&amp;set=view_comments&amp;set2=delete_comment&amp;id='.$row[id].'">Delete Comment</a>
                                </div></td></tr>
                                </tr></table>';
                            $add_to_count = mysql_query("UPDATE `user_comments` SET count = count+1 WHERE `username` = '$username'") or die(mysql_error());
                        }; //while($row = mysql_fetch_array($find_new_comments))
                    }; //if($set3 == 'delete' || $id== '')
                } //if(mysql_num_rows($find_new_comments) == 0){
                else{
                    print '<h1><center>No Comments</center></h1>
                        <hr width="100%" align="center"/>
                        <center><strong>You have no comments.</strong></center>';
                }
            }; //if ($action == 'view_comments')
            //EDIT COMMENTS
            if($set == 'edit_comment'){
                title("Edit Comment");
                if($requestid != ''){
                    if($set2 == 'submit'){
                        $update_post = mysql_query("UPDATE `user_comments` SET `post` = '$_POST[comment]' WHERE `id` ='$requestid'") or die(mysql_error());
                        print '<strong>Comment Edited and Saved</strong>';
                    };
                    $post_select = mysql_query("SELECT * FROM user_comments WHERE id = $requestid");
                    while($row = mysql_fetch_array($post_select)){
                        print '<h1><center>Edit Comment</center></h1>
                            <hr width="100%" align="center"/>
                            <table class="table" align="center">
                            <tr><td>
                            <form action="?act=profile&amp;action=comment&amp;set=edit_comment&amp;set2=submit&amp;id='.$requestid.'" method="post">
                            Username: '.$row[username].'<br />
                            Date: '.$row[date].'<br />
                            Post:<br />
                            <textarea name="comment" rows="10" cols="45">'.$row[post].'</textarea><br />
                            <input type="submit" value="Submit" />
                            </form>
                            </td></tr>
                            </table>';};
                } else {print 'NO ID';};
            };
        };
        if ($action =='reputation'){
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
        if ($action == 'change_reputation'){
            if ($_POST['rep'] == '+rep'){
                $prep = mysql_query("UPDATE users SET `kpos` = kpos + 1 WHERE `username` = '$_GET[username]'");
                title("Positive (+1) Reputation Given");
                print '<h1><center>Positive (+1) Reputation Given</center></h1>
                    <hr width="100%" align="center"/>
                    <table class="table" align="center">
                    <tr><td>Positive reputation has been given to <strong>'.$_GET[username].'</strong>.<br />
                    <a href="?act=profile&amp;action=view&amp;username='.$_GET[username].'">Back to '.$_GET[username].'\'s profile</a>
                    </td></tr></table>';
            };
            if ($_POST['rep'] == '-rep'){
                $nrep = mysql_query("UPDATE users SET `kneg` = kneg + 1 WHERE `username` ='$_GET[username]'");
                title("Negative (-1) Reputation Given");
                print '<h1><center>Negative (-1) Reputation Given</center></h1>
                    <hr width="100%" align="center"/>
                    <table class="table" align="center">
                    <tr><td>Negative reputation has been given to <strong>'.$_GET[username].'</strong>.<br />
                    <a href="?act=profile&amp;action=view&amp;username='.$_GET[username].'">Back to '.$_GET[username].'\'s profile</a>
                    </td></tr></table>';
            };
        }; //if ($action == 'change_reputation')
        //EDIT PROFILE
        if ($action == 'edit_profile'){
            if ($set == 'fix'){
                $fix_query = mysql_query("UPDATE `users` SET `first_name` = '$_POST[fname]', `last_name` = '$_POST[lname]', `about` = '$_POST[about]', `website` = '$_POST[website]', `signature` = '$_POST[signature]', `interests` = '$_POST[interests]', `email`='$_POST[email]', `aim` = '$_POST[aim]', `avatar`= '$_POST[avatar]' WHERE `username` = '$currentusername' LIMIT 1") or die(mysql_error());
                $_SESSION['firstname'] = $_POST['fname'];
                $_SESSION['lastname'] = $_POST['lname'];
                print '<strong>Your profile has been updated.</strong>';
            }; //if ($action == 'fix')
            title("Edit Profile");
            print '<h1><center>Edit Profile</center></h1>
                <hr width="100%" align="center"/>';
            $edit_query = mysql_query("SELECT * FROM `users` WHERE `username` = '$username'");
            while ($row = mysql_fetch_array($edit_query)){
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
            }; //while ($row = mysql_fetch_array($edit_query))
        }; //if ($action == 'edit_profile')
        //CHANGE PASSWORD
        if ($action == 'change_password'){
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
        if ($action == 'submit_change_password'){
            $currentpass = sha1(md5($_POST[current_password]));
            $query = mysql_query("SELECT * FROM users WHERE `username` = '$username' AND `password` = '$currentpass' LIMIT 1");
            if (mysql_num_rows($query) == 1){
                if ($_POST[new_password] == $_POST[reenter_new_password]){
                    if ($_POST[new_password] != ''){
                        if ($_POST[reenter_new_password] != ''){
                            $newpass = sha1(md5($_POST[new_password]));
                            $sql = "UPDATE users SET online = 0, `password` = '$newpass' WHERE `username` = '$username'";
                            $result = mysql_query($sql) or die (mysql_error());
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
                        }else{
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
                    else{
                        title("New Password Cannot be Blank");
                        print '<h1><center>New Password Cannot be Blank</center></h1>
                            <hr width="100%" align="center"/>
                            <table class="table" align="center">
                            <tr><td>
                            Your new password cannot be blank.
                            </td></tr>
                            </table>';
                    };
                }else{
                    title("New Passwords Do Not Match");
                    print '<h1><center>New Passwords Do Not Match</center></h1>
                        <hr width="100%" align="center"/>
                        <table class="table" align="center">
                        <tr><td>
                        Your new passwords do not match.
                        </td></tr>
                        </table>';
                };
            } //if (mysql_num_rows($query) == 1)
            else{
                title("Current Password is Incorrect");
                print '<h1><center>Current Password is Incorrect</center></h1>
                    <hr width="100%" align="center"/>
                    <table class="table" align="center">
                    <tr><td>
                    Your current password is incorrect.
                    </td></tr>
                    </table>';
            };
        }; //if ($action == 'submit_change_password')
    };
};
?>
