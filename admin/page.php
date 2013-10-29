<?php 
require_once(dirname(dirname(__FILE__)) . '/functions.php');

if($action == 'page') {
    //SAVE EDITED WEB PAGE
    if ($set == 'save_page') {
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
        if ($set2 == 'create_page') {
            print '<strong>'.$_POST[title].'</strong> has been created successfully.';
        };
        //SAVE EDITED PAGE
        if($set2 == 'save_edited_page') {
            if($_SESSION['group'] == 'admin') {
            };
            if($_SESSION['group'] != 'admin') {
            };
            print '<strong>'.$_POST[title].'</strong> has been successfully saved.';
        };
    };
    //SUBMIT DELETE WEBPAGE
    if ($set == 'delete') {
        while ($row = mysql_fetch_array($requesttitle)) {
            $printtitle = $row[page_title];
        };
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
    while($row = mysql_fetch_array($select_page_query)) {
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
if ($action == 'create_new_page') {
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
if ($action == 'edit_page') {
    title("Edit Web Page");
    if ($id != '') {
        while ($row = mysql_fetch_array($selectpage)) {
            if($row[admin] == 1) {
                $admincheckboxchecked = 'checked="checked" /';};
                if($row[admin] == 0) {
                    $admincheckboxchecked = '/';};
                    if($row[member] == 1) {
                        $membercheckboxchecked = 'checked="checked" /';};
                        if($row[member] == 0) {
                            $membercheckboxchecked = '/';};
                            if($row[member] == 1) {
                                $basicmembercheckboxchecked = 'checked="checked" /';};
                                if($row[member] == 0) {
                                    $basicmembercheckboxchecked = '/';};
                                    if($row['public'] == 1) {
                                        $publiccheckboxchecked = 'checked="checked"';};
                                        if($row['public'] == 0) {
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
        };
    };
};
//DELETE WEB PAGE
if ($action== 'delete_page') {
    title("Delete Web Page");
    if ($id != '') {
        while ($row = mysql_fetch_array($select_kill)) {
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
    }else{print 'WEB PAGE DOES NOT EXIST';};
};
};
?>
