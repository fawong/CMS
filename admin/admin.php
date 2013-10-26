<?php 
require_once('functions.php');

if($act == 'admin'){
    if($_SESSION['group'] != 'admin'){
        redirect("failed.php?amp;id=2");
    };
    //ADD NEW POST
    if($action == 'post'){
        title("Add New Post");
        if($set == 'submit'){
            if($_POST['post'] != ''){
                $insert_query = mysql_query("INSERT INTO `posts`(`title`, `username` , `date` , `post`) VALUES('$_POST[title]', '$username', '$current_date', '$_POST[post]')") or die(mysql_error());
                print '<strong>New Post Added.</strong>';
            };
        };
        print '<h1><center>Add New Post</center></h1>
            <hr width="100%"/>
            <table class="table"><tr><td>
            <form action="?act=admin&amp;action=post&amp;set=submit" method="post">
            Title: <input name="title" type="text" /><br />
            Date: '.$current_date.'<br />
            Poster: '.$_SESSION['username'].'<br />
            Post:<br />
            <textarea name="post" rows="10" cols="60">
            </textarea><br />
            <input type="submit" value="Submit" name="Submit" />
            </form>
            </td></tr></table>';
    };
    // EDIT POST
    if($action == 'edit_post'){
        title("Edit Post");
        if($id != ''){
            if($set == 'submit'){
                //`date` = '$_POST[date]', `username` = '$username',
                $update_post = mysql_query("UPDATE `posts` SET `title` = '$_POST[title]', `post` = '$_POST[post]' WHERE `id` ='$id'") or die(mysql_error());
                print '<strong>Post Edited and Saved.</strong>';
            };
            $post_select = mysql_query("SELECT * FROM posts WHERE id ='$id'");
            while($row = mysql_fetch_array($post_select)){
                print '<h1><center>Edit Post</center></h1>
                    <hr width="100%"/>
                    <table class="table">
                    <tr><td>
                    <form action="?act=admin&amp;action=edit_post&amp;set=submit&amp;id='.$id.'" method="post">
                    <strong>Title:</strong> <input name="title" type="text" value="'.$row[title].'" /><br />
                    <strong>Date:</strong> '.$row[date].'<br />
                    <strong>Poster:</strong> '.$row[username].'<br />
                    <strong>Post:</strong><br />
                    <textarea name="post" rows="10" cols="45">'.$row[post].'</textarea>
                    <br />
                    <input type="submit" value="Submit" name="Submit" />
                    </form>
                    </td></tr>
                    </table>';
            };
        }else {print 'NO ID';};
    };
    //DELETE POST
    if($action == 'delete_post'){
        title("Delete Post");
        if($id != ''){
            if($set == 'delete'){
                $delete_comments = mysql_query("DELETE FROM comments WHERE id = '$id'");
                $delete_query = mysql_query("DELETE FROM posts WHERE id = '$id'");
                print '<strong>Post Deleted.</strong>';
            };
            $post_select = mysql_query("SELECT * FROM posts WHERE id =$id");
            while($row = mysql_fetch_array($post_select)){
                print '<h1><center>Delete Post</center></h1>
                    <hr width="100%"/>
                    <table class="table">
                    <tr><td>
                    <div>
                    <font size="+2"><strong>'.$row[title].'</strong></font><br />
                    <font size="+1"><strong>Posted by: <a href="?act=profile&amp;action=view&amp;username='.$row[username].'">'.$row[username].'</a>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Date: '.$row[date].'</strong></font>
                    </div>
                    </td></tr>
                    <tr><td><div align="left">'.$row[post].'</div></td></tr>
                    </table>
                    <hr width="100%"/>
                    <table class="table">
                    <tr><td>
                    <strong>Are you sure you want to delete this post?</strong><br />
                    <form action="?act=admin&amp;action=delete_post&amp;set=delete&amp;id='.$row[id].'" method="post">
                    <input type="submit" value="Yes" /><input type="button" onclick="history.go(-1)" value="No" />
                    </form>
                    </table>';
            };
        }else{
            print 'YOU HAVE FAILED';
        };
    };
    if ($action == 'delete_comment') {
        if ($set == 'delete') {
            title("Comment Deleted");
            $delete_comment = mysql_query("DELETE FROM comments WHERE id = '$id'") or die(mysql_error());
            print 'Comment Sucessfully Deleted.';
        };
        title("Delete Comment");
        $post_select = mysql_query("SELECT * FROM comments WHERE id =$id");
        while($row = mysql_fetch_array($post_select)){
            print '<h1><center>Delete Comment</center></h1>
                <hr width="100%"/>
                <table class="table">
                <tr><td>
                <div>
                <font size="+2"><strong>'.$row[title].'</strong></font><br />
                <font size="+1"><strong>Posted by: <a href="?act=profile&amp;action=view&amp;username='.$row[username].'">'.$row[username].'</a>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Date: '.$row[date].'</strong></font>
                </div>
                </td></tr>
                <tr><td><div align="left">'.$row[comment].'</div></td></tr>
                </table>
                <hr width="100%"/>
                <table class="table">
                <tr><td>
                <strong>Are you sure you want to delete this comment?</strong><br />
                <form action="?act=admin&amp;action=delete_comment&amp;set=delete&amp;id='.$row[id].'" method="post">
                <input type="submit" value="Yes" /><input type="button" onclick="history.go(-1)" value="No" />
                </form>
                </table>';
        }
    };
    //EDIT MEMBERS LIST
    if($action == 'edit_users_list'){
        if($set == 'force_offline'){
            $find_people = mysql_query("SELECT * FROM users");
            while($row = mysql_fetch_array($find_people)){
                if($local_time > $row[last_logged_on]){
                    $force_offline = mysql_query("UPDATE users SET `online` = '0'");
                };
            };
            print 'All online members have been forced offline.';
        };
        title("Edit Members List");
        //SUBMIT SAVE MEMBER
        if($set == 'save_member'){
            $alphanumeric = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
            $activation_code = substr(str_shuffle($alphanumeric), 0, 15);
            $fixmysqldatabase = mysql_query("UPDATE `users` SET `first_name` = '$_POST[first_name]', `last_name` = '$_POST[last_name]', `group` = '$_POST[group]', `aim` = '$_POST[aim]', `about` = '$_POST[about]', `website` = '$_POST[website]', `signature` = '$_POST[signature]', `interests` = '$_POST[interests]', `activation_code` = '$activation_code', `activated_account` = '$_POST[activatedaccount]', `theme` = '$_POST[theme]', `access_file_manager` = '$_POST[access_file_manager]',  `username`='$_POST[username]', `date_of_birth`='$_POST[date_of_birth]', `email`='$_POST[email]', `avatar`='$_POST[avatar]' WHERE `users`.`user_id` = '$user_id' LIMIT 1") or die(mysql_error());
            print 'Member <strong>'.$requestusername.'</strong> has been updated.';
        };
        //SUBMIT DELETE MEMBER
        if($set == 'deletemember'){
            $del_mem = mysql_query("DELETE FROM `users` WHERE `username` = '$requestusername'");
            print 'Member <strong>'.$requestusername.'</strong> has been deleted.';
        };
        //SUBMIT ADD NEW MEMBER
        if($set == 'add'){
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
            $mysql_add_text = "INSERT INTO `users` (`first_name`, `last_name`, `user_id`, `group`, `username`, `password`, `activation_code`, `access_file_manager`, `date_of_birth` , `ip`, `activated_account`, `date_joined`, `email`, `about`, `website`, `interests`, `aim`, `signature`, `avatar`, `last_log_on`) VALUES ('$first_name', '$last_name', '$new_user_id', '$_POST[group]', '$_POST[username]', '$_POST[password]', '$activation_code', '$access_file_manager_yesorno', '$_POST[dateofbirth]' , '$ip', '$_POST[activatedaccount]', '$local_time', '$_POST[email]', '$_POST[about]', '$_POST[website]', '$_POST[interests]', '$_POST[aim]', '$_POST[signature]', '$_POST[avatar]', 'never')";
            //VALUES('$new_user_id', '$_POST[group]', '$_POST[username]', '$_POST[password]', '$date', '$_POST[date_of_birth]', '$_POST[email]', '$_POST[title]', '$ip', '0', '', '$_POST[activation_code]', '0', '$_POST[about]', '$_POST[website]', '$_POST[interest]', '$_POST[aim]', '$_POST[msn]', '$_POST[avatar]', '$_POST[img1]', '$_POST[img2]', '$_POST[img3]', '$_POST[signature]', '$_POST[theme]', '0', '0', '$_POST[access_file_manager]', '0', '0', '0')";
            $mysql_add_query_bu = mysql_query($mysql_add_text) or die(mysql_error()); 
            print 'Member <strong>'.$_POST[username].'</strong> has been added.';
            if($access_file_manager_yesorno == '1'){
                mkdir('/home/waf/public_html/st/files/'.$requestusername, 0755);
                print '<br />Member <strong>'.$requestusername.'\'s</strong> folder has been created.';
            };
        };
        print '<h1><center>Edit Members List</center></h1>
            <hr width="100%"/>
            <table class="table">
            <tr>
            <td>
            <a href="?act=admin&amp;action=add_member">Add a Member</a> |
            <a href="?act=admin&amp;action=edit_users_list&amp;set=force_offline">Force All Members Offline</a>
            </td>
            </tr>
            <tr>
            <td>
            Total Number of Members: ';
        $select_all_members = mysql_query("SELECT * FROM `users` ORDER BY `group` ASC, `username` ASC") or die (mysql_error());
        $totalnumberofmembers = mysql_num_rows($select_all_members) or die (mysql_error());
        print ''.$totalnumberofmembers.'</td>
            </tr>
            </table><br />
            <table class="table" width="100%">
            <tr>
            <td width="100"><strong>User ID</strong></td>
            <td width="200"><strong>Username</strong></td>
            <td width="100"><strong>Group</strong></td>
            <td width="100"><strong>Online</strong></td>
            <td width="100"><strong>Activated</strong></td>
            <td width="300"><strong>File Manager Access</strong></td>
            <td width="300"><strong>View | Edit | Delete</strong></td>
            </tr>';
        while($row = mysql_fetch_array($select_all_members)){
            print '<tr>
                <td width="100">'.sprintf('%05s', $row[user_id]).'</td>
                <td width="200">'.$row[username].'</td>
                <td width="100">';
            if($row[group] == "admin")
            {$g = "<strong>Administrator</strong>";};
            if($row[group] == "member")
            {$g = "Member";};
            if($row[group] == "basic")
            {$g = "Basic Member";};
            print ''.$g.'</td>
                <td width="100">';
            if($row[online] == 1)
            {$o = "Yes";};
            if($row[online] == 0)
            {$o = "No";};
            print ''.$o.'</td>
                <td width="100">';
            if($row[activated_account] == 1)
            {$aa = "Yes";};
            if($row[activated_account] == 0)
            {$aa = "No";};
            print ''.$aa.'</td>
                <td width="300">';
            if($row[access_file_manager] == 1)
            {$afm = "Yes";};
            if($row[access_file_manager] == 0)
            {$afm = "No";};
            print ''.$afm.'</td>
                <td width="300">
                <a href="?act=profile&amp;action=view&amp;username='.$row[username].'">View</a> | 
                <a href="?act=admin&amp;action=edit_user&amp;user_id='.$row[user_id].'">Edit</a> | 
                <a href="?act=admin&amp;action=delete_member&amp;username='.$row[username].'">Delete</a>
                </td>
                </tr>';
        };
        print '</table>';
    };
    //ADD NEW MEMBER
    if($action == 'add_member'){
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
    //EDIT MEMBER
    if($action == 'edit_user'){
        title("Edit Member");
        $edit_query = mysql_query("SELECT * FROM users WHERE user_id = '$user_id'");
        while($row = mysql_fetch_array($edit_query)){
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
            if($row[activated_account] == 1){
                $aa = "Yes";
            };
            if($row[activated_account] == 0){
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
            if($row[access_file_manager] == 1){
                $afm = "Yes";
            };
            if($row[access_file_manager] == 0){
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
    if($action == 'delete_member'){
        title("Delete Member");
        print '<h1><center>Delete Member</center></h1>
            <hr width="100%"/>
            <form action="?act=admin&amp;action=edit_users_list&amp;set=deletemember&amp;username='.$requestusername.'" method="post">
            <table class="table"><tr><td>
            <strong>Are you sure you want to delete user '.$requestusername.'?</strong>
            <br />
            <input type="submit" value="Yes" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" onclick="history.go(-1)" value="No" />
            </td></tr></table>
            </form>';
    };
    //WEBSITE SETTINGS
    if($action == 'website_settings'){
        $all_settings = mysql_query("SELECT * FROM settings") or die(mysql_error());
        //SAVE WEBSITE SETTINGS
        if($set == "save_website_settings"){
            $settings = mysql_query("SELECT * FROM settings") or die(mysql_error());
            $num_settings = mysql_num_rows($settings) or die(mysql_error());
            for($i = 1; $i <= $num_settings; $i++){
                $row = mysql_fetch_array($settings) or die(mysql_error());
                $posted_value = $row[setting];
                $save_settings = mysql_query("UPDATE settings SET `value` = '$_POST[$posted_value]' WHERE `setting` = '$row[setting]'") or die(mysql_error());
                $all_settings = mysql_query("SELECT * FROM settings") or die(mysql_error());
            }
            print ''.$cms_name.' settings have been saved';
        };
        title("$cms_name Website Settings");
        print '<h1><center>'.$cms_name.' Website Settings</center></h1>
            <hr width="100%"/>
            <a href="?act=admin&amp;action=change_website_settings">Change Settings</a>
            <table class="table" >';
        while($row = mysql_fetch_array($all_settings)){
            print'<tr><td>'.$row[displayname].'</td>
                <td>'.$row[value].'</td></tr>';
        };
        print '</table>';
    };
    //CHANGE WEBSITE SETTINGS
    if($action == 'change_website_settings'){
        title("Change $cms_name Website Setting");
        print '<h1><center>Change '.$cms_name.' Website Settings</center></h1>
            <hr width="100%"/>
            <form method="post" action="?act=admin&amp;action=website_settings&amp;set=save_website_settings">
            <table class="table" >';
        $settings = mysql_query("SELECT * FROM settings") or die(mysql_error());
        while($row = mysql_fetch_array($settings)){
            print '<tr><td><strong>'.$row[displayname].': </strong></td>
                <td><input type="text" name="'.$row[setting].'" size="25" value="'.$row[value].'" /></td></tr>';
        };
        print '</table><input type="submit" value="Submit" />
            </form>';
    };
    //WEB PAGE FUNCTIONS
    if($action == 'page'){
        //SAVE EDITED WEB PAGE
        if ($set == 'save_page'){
            $random_id = rand(000, 9999);
            $admincheckbox = '0';
            $membercheckbox = '0';
            $basicmembercheckbox = '0';
            $publiccheckbox = '0';
            if ($_POST['admin'] == 'admin') {
                $admincheckbox = '1';
            };
            if ($_POST['member'] == 'member') {
                $membercheckbox = '1';
            };
            if ($_POST['member'] == 'member') {
                $basicmembercheckbox = '1';
            };
            if ($_POST['public'] == 'public') {
                $publiccheckbox = '1';
            };
            if ($set2 == 'create_page'){
                $add_query = mysql_query("INSERT INTO `pages` (`id`, `page`, `page_title`, `header`, `body`, `footer`, `css`, `views`, `hidden`, `admin`, `member`, `basic`, `public`, `username`, `password`) VALUES ('$random_id', '$_POST[urlkey]', '$_POST[title]', '$_POST[head]', '$_POST[body]', '$_POST[footer]', '$_POST[css]', '0', '0', '$admincheckbox', '$membercheckbox', '$basicmembercheckbox', '$publiccheckbox', '$username', '$_POST[pass]')") or die(mysql_error());
                print '<strong>'.$_POST[title].'</strong> has been created successfully.';
            };
            //SAVE EDITED PAGE
            if($set2 == 'save_edited_page'){
                if($_SESSION['group'] == 'admin'){
                    $page_edit = mysql_query("UPDATE `pages` SET `page` = '$_POST[urlkey]', `page_title` = '$_POST[title]', `body` = '$_POST[body]', `admin` = '$admincheckbox', `member` = '$membercheckbox', `basic` = '$basicmembercheckbox', `public` = '$publiccheckbox', `password` = '$_POST[pass]', `css` = '$_POST[css]', `header` = '$_POST[head]', `footer` = '$_POST[footer]' WHERE `id` = '$id'") or die(mysql_error());
                };
                if($_SESSION['group'] != 'admin'){
                    $page_edit = mysql_query("UPDATE `pages` SET `page` = '$_POST[urlkey]', `page_title` = '$_POST[title]', `body` = '$_POST[body]', `admin` = '$admincheckbox', `member` = '$membercheckbox', `basic` = '$basicmembercheckbox', `public` = '$publiccheckbox', `password` = '$_POST[pass]', `css` = '$_POST[css]', `header` = '$_POST[head]', `footer` = '$_POST[footer]' WHERE `id` = '$id' AND `username` = '$username'") or die(mysql_error());
                };
                print '<strong>'.$_POST[title].'</strong> has been successfully saved.';
            };
        };//if ($set == 'save_page')
        //SUBMIT DELETE WEBPAGE
        if ($set == 'delete'){
            $requesttitle = mysql_query("SELECT * FROM `pages` WHERE `id` = '$id'");
            while ($row = mysql_fetch_array($requesttitle)){
                $printtitle = $row[page_title];
            };
            $delete_page = mysql_query("DELETE FROM `pages` WHERE `id` = '$id'") or die(mysql_error());
            print '<strong>'.$printtitle.'</strong> has been deleted.';
        };
        title("Web Page Control Panel");
        page_header('Web Page Control Panel');
?>
                <a href="?act=admin&amp;action=create_new_page">Add a New Web Page</a><br />

                <table class="table" width="100%" >
                <tr>
                <td><strong>ID</strong></td>
                <td><strong><center>Page Title</center></strong></td>
                <td><strong>URL Key</strong></td>
                <td><strong>Administrator Access</strong></td>
                <td><strong>Member Access</strong></td>
                <td><strong>Basic Member Access</strong></td>
                <td><strong>Public Access</strong></td>
                <td><strong>Views</strong></td>
                <td><strong>View | Edit | Delete</strong></td>
                </tr>
<?php
        $select_page_query = mysql_query("SELECT * FROM `pages` ORDER BY page_title ASC");
        while($row = mysql_fetch_array($select_page_query)){
            print '<tr>
                <td>'.sprintf('%04s', $row[id]).'</td>
                <td>'.$row[page_title].'</td>
                <td>'.$row[page].'</td>';
            if($row[admin] == 0)
            {$aa = "No";};
            if($row[admin] == 1)
            {$aa = "Yes";};
            print '<td><center>'.$aa.'</center></td>';
            if($row[member] == 0)
            {$ma = "No";};
            if($row[member] == 1)
            {$ma = "Yes";};
            print '<td><center>'.$ma.'</center></td>';
            if($row[basic] == 0)
            {$bma = "No";};
            if($row[basic] == 1)
            {$bma = "Yes";};
            print '<td><center>'.$bma.'</center></td>';
            if($row['public'] == 0)
            {$pa = "No";};
            if($row['public'] == 1)
            {$pa = "Yes";};
            print '<td><center>'.$pa.'</center></td>
                <td>'.$row[views].'</td>
                <td>
                <a href="?page='.$row[page].'" target="_blank">View</a> | 
                <a href="?act=admin&amp;action=edit_page&amp;id='.$row[id].'">Edit</a> | 
                <a href="?act=admin&amp;action=delete_page&amp;id='.$row[id].'">Delete</a>
                </td>
                </tr>';
        };
        print '</table>';
    };
    //CREATE NEW WEB PAGE
    if ($action == 'create_new_page'){
        title("Create New Web Page");
        print '<h1><center>Create New Web Page</center></h1>
            <hr width="100%"/>
            <table class="table"><tr><td>
            <form action="?act=admin&amp;action=page&amp;set=save_page&amp;set2=create_page" method="post">
            Page Title: <input type="text" name="title" />
            <br />
            URL Key (Page): <input type="text" name="urlkey" />
            <br />
            Head:
            <br />
            <textarea name="head" cols="80" rows="10"></textarea>
            <br />
            CSS:
            <br />
            <textarea name="css" cols="80" rows="10"></textarea>
            <br />
            Page Body:
            <br />
            <textarea name="body" cols="80" rows="10"></textarea>
            <br />
            Footer:
            <br />
            <textarea name="footer" cols="80" rows="10"></textarea>
            <br />
            Group Access List:<br />
            <input type="checkbox" name="admin" value="admin" />Administrators<br />
            <input type="checkbox" name="member" value="member" />Webmasters<br />
            <input type="checkbox" name="member" value="member" />Members<br />
            <input type="checkbox" name="public" value="public" />Public<br />
            <br />
            Password: <input type="text" name="password" value="'.$row[password].'"/><br />
            Leave blank for NO password<br />
            <input type="submit" value="Create Webpage" />
            </form>
            </td></tr></table>';
    };
    //EDIT WEB PAGE
    if ($action == 'edit_page'){
        title("Edit Web Page");
        if ($id != ''){
            $selectpage = mysql_query("SELECT * FROM `pages` WHERE `id` = '$id'") or die (mysql_error());
            while ($row = mysql_fetch_array($selectpage)){
                if($row[admin] == 1){
                    $admincheckboxchecked = 'checked="checked" /';};
                    if($row[admin] == 0){
                        $admincheckboxchecked = '/';};
                        if($row[member] == 1){
                            $membercheckboxchecked = 'checked="checked" /';};
                            if($row[member] == 0){
                                $membercheckboxchecked = '/';};
                                if($row[member] == 1){
                                    $basicmembercheckboxchecked = 'checked="checked" /';};
                                    if($row[member] == 0){
                                        $basicmembercheckboxchecked = '/';};
                                        if($row['public'] == 1){
                                            $publiccheckboxchecked = 'checked="checked"';};
                                            if($row['public'] == 0){
                                                $publiccheckboxchecked = '/';};
                                                page_header('Edit Web Page');
?>
<form class="form-horizontal" role="form" action="?act=admin&amp;action=page&amp;set=save_page&amp;set2=save_edited_page&amp;id=<?php print $row[id] ?>" method="post">
    <div class="form-group">
        <label>Page Title:</label>
        <input type="text" class="form-control" name="title" value="<?php print $row['page_title'] ?>" placeholder="<?php print $row['page_title'] ?>" />
    </div>
    <div class="form-group">
        <label>URL Key (Set):</label>
        <input type="text" name="urlkey" class="form-control" value="<?php print $row['page'] ?>" placeholder="<?php print $row['page'] ?>"/>
    </div>
    <div class="form-group">
        <label>Header:</label>
        <textarea name="head" class="form-control"><?php print $row[header] ?></textarea>
    </div>
    <div class="form-group">
        <label>CSS:</label>
        <textarea name="css" class="form-control"><?php print $row[css] ?></textarea>
    </div>
    <div class="form-group">
        <label>Page Body:</label>
        <textarea name="body" class="form-control"><?php print $row[body] ?></textarea>
    </div>
    <div class="form-group">
        <label>Footer:</label>
        <textarea name="footer" class="form-control"><?php print $row[footer] ?></textarea>
    </div>
    <div class="form-group">
        <label>Group Access List:</label>
        <div class="checkbox">
            <label>
                <input type="checkbox" name="admin" value="admin" <?php print $admincheckboxchecked ?>>
                Administrators
            </label>
            <label>
                <input type="checkbox" name="member" value="member" <?php print $basicmembercheckboxchecked ?>>
                Webmasters
            </label>
            <label>
                <input type="checkbox" name="member" value="member" <?php print $basicmembercheckboxchecked ?>>
                Members
            </label>
            <label>
                <input type="checkbox" name="public" value="public" <?php print $publiccheckboxchecked ?>>
                Public
            </label>
        </div>
    </div>
    <div class="form-group">
        <label>Password:</label>
        <input type="text" name="password" class="form-control" value="<?php print $row['password'] ?>" placeholder="<?php print $row['password'] ?>" />
        Leave blank for NO password
    </div>
    <button type="submit" class="btn">Edit Webpage</button>
</form>
<?php
            };//while ($row = mysql_fetch_array($selectpage))
        };//if ($id != '')
    };//if ($action == 'edit_page')
    //DELETE WEB PAGE
    if ($action== 'delete_page'){
        title("Delete Web Page");
        if ($id != ''){
            $select_kill = mysql_query("SELECT * FROM `pages` WHERE `id` = '$id'");
            while ($row = mysql_fetch_array($select_kill)){
                print '<h1><center>Delete Web Page</center></h1>
                    <hr width="100%"/>
                    <table class="table">
                    <tr><td>
                    <strong>Title:</strong> '.$row[page_title].'<br />
                    <strong>URL Key:</strong> '.$row[set].'<br />
                    <strong>Views:</strong> '.$row[views].'<br />
                    <strong>Header:</strong><br />
                    '.$row[header].'<br /><br />
                    <strong>CSS:</strong><br />
                    '.$row[css].'<br /><br />
                    <strong>Page Body:</strong><br />
                    '.$row[body].'<br /><br />
                    <strong>Footer:</strong><br />
                    '.$row[footer].'
                    </td></tr>
                    </table>
                    <table class="table">
                    <tr><td>
                    <strong>Are you sure you want to delete this page?</strong><br />
                    <form action="?act=admin&amp;action=page&amp;set=delete&amp;id='.$row[id].'" method="post">
                    <input type="submit" value="Yes" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <input type="button" onclick="history.go(-1)" value="No" />
                    </form>
                    </td></tr>
                    </table>';
            };
        }else{print 'WEB PAGE DOES NOT EXIST';};//if ($id != '')
    };
};
?>
