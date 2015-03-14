<?php 
if ($act == 'downloadscontrolpanel') {
    if ($group_id != 1 || $access['downloadscontrolpanel'] = '0') {
        redirect("failed.php?amp;id=2");
    };
    if ($group_id == 1 || $access['downloadscontrolpanel'] == '1') {
        if ($action == 'overview') {
            title("Downloads Control Panel");
            print '<h1><center>Downloads Control Panel</center></h1>
                <hr width="100%" align="center"/>
                <table class="table" align="center"><tr><td><a href="?act=downloadscontrolpanel&amp;action=new_file">Add a New File</a> | <a href="index.php?act=downloadscontrolpanel&amp;action=create_new_file_category">Create New File Category</a></td></tr>
                <tr><td>
                Top 10  Downloads:<br />
                <tr><td>';
            $count = 1;
            while ($row = mysql_fetch_array($find_top)) {
                print '#'.$count.' <a href="?act=dldb&amp;action=view&amp;id='.$row[id].'">'.$row[name].'</a> '.$row[downloads].'<br />';
                $count++;
            };
            print '</td></tr></table><br />';
            print '<table class="table" align="center">
                <tr>
                <td><center><strong>Number</strong></center></td>
                <td><center><strong>Name</strong></center></td>
                <td><center><strong>Author</strong></center></td>
                <td><center><strong>Downloads</strong></center></td>
                <td><center><strong>Date Submit</strong></center></td>
                <td><center><strong>View | Edit | Delete</strong></center></td>
                </tr>';
            while ($row = mysql_fetch_array($find_files_all)) {
                print '<tr>
                    <td><center>'.$row[id].'</center></td>
                    <td>'.$row[name].'</td>
                    <td>'.$row[author].'</td>
                    <td align="center">'.$row[downloads].'</td>
                    <td>'.$row[date_submitted].'</td>
                    <td><a href="?act=dldb&amp;action=view&amp;id='.$row[id].'">View</a> | <a href="index.php?act=downloadscontrolpanel&amp;action=edit_file">Edit</a> | <a href="index.php?act=downloadscontrolpanel&amp;action=delete_file">Delete</a></td>
                    </tr>';
            };
            print '</table>';
        };
        if ($action == 'new_file') {
            title("Add New File");
            print '<h1><center>Add New File</center></h1>
                <hr width="100%" align="center"/>
                <table class="table" align="center"><tr><td><form action="?act=downloadscontrolpanel&amp;action=save_file" method="POST">
                Name: <input type="text" value="" name="name" /><br />
                Author: <input type="text" value="" name="author" /><br />
                Category:
                <select name="category">
                <option value="">Select:</option>';
            while ($row = mysql_fetch_array($count_down)) {
                print '<option value="'.$row[id].'">'.$row[name].'</option>';
            };
            print '</select>
                <br />
                File name: <input type="text" value="" name="file_name" /><br />
                File size: <input type="text" value="" name="file_size" /> (bytes)<br />
                File type: <input type="text" value="" name="file_type" /><br />
                File path: <input type="text" value="/home/waf/public_html/downloads/" size="50" name="file_path" /> (on server)<br />
                Rating: <input type="text" value="" name="rating" /> /10<br />
                Description:<br />
                <textarea rows="5" cols="50" name="text"></textarea>
                <br />
                Hidden: <input type="text" value="0" name="hidden" /><br />
                Password: <input type="text" value="" name="password" /><br />
                <input type="submit" value="Add File" name="submit" /><br />
                </form></td></tr></table>';
        };
        if ($action == 'save_file') {
            $file_id = rand(000000,999999);
            print $_POST[file_name].' has been saved correctly';
        };
        if ($action == 'create_new_file_category') {
            title("Create New File Category");
            print '<h1><center>Create New File Category</center></h1>
                <hr width="100%" align="center"/>
                <table class="table" align="center">
                <tr><td>
                <form action="?act=downloadscontrolpanel&amp;action=save_category" method="POST">
                Name: <input type="text" value="" name="name" /><br />
                Description: <input type="text" value="" name="text" /><br />
                Hidden: <input type="text" value="" name="hidden" /><br />
                Password: <input type="text" value="" name="password" /> Leave blank for none<br />
                <input type="submit" name="submit" value="Create New Category" />
                </form>
                </td></tr></table>';
        };
        if ($action == 'delete_file') {
            title("Delete File");
            print '<h1><center>Delete File</center></h1>
                <hr width="100%" align="center"/>
                <table class="table" align="center">
                <tr><td>
                Delete File
                </td></tr>
                </table>';
        };
        if ($action == 'edit_file') {
            title("Edit File");
            print '<h1><center>Edit File</center></h1>
                <hr width="100%" align="center"/>
                <table class="table" align="center">
                <tr><td>
                Edit File
                </td></tr>
                </table>';
        };
        if ($action == 'save_category') {
            print '<strong>'.$_POST[name].'</strong> has been saved correctly.';
        };
        print '</table>';
    };
};
?>
