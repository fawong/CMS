<?php 
$current_folder = 'inbox';
//INBOX
if ($act == 'inbox'){
    title("Inbox");
    print '<center><h1>Inbox</h1></center>
        <hr width="100%" align="center" /><br/>';
    if ($_SESSION['login'] == true){
        if ($action == ''){
            print '<table class="table" align="center"><tr><td>
                <form method="post" action="?act=inbox&amp;action=change_folder">
                Current Folder: '.$current_folder.'<br />
                Total Usage: ';
            total_message();
            print ' (Used/Maximum)
                <br />
                <a href="?act=inbox&amp;action=compose">Compose</a> | Change Folder: 
                <select name="folder" size="1"> 
                <option value="inbox" selected="selected">Inbox</option>
                <option value="outbox">Outbox</option>
                <option value="drafts">Drafts</option>
                <option value="sent">Sent</option>
                <option value="trash">Trash</option>
                <option value="spam">Spam</option>
                </select>
                <input type="submit" value="Go!" />
                </form>
                </td></tr>
                <table class="table" align="center">
                <tr>
                <td>Number</td>
                <td>From</td>
                <td>Subject</td>
                <td>Date</td>
                <td>Options</td>
                </tr>';
            $count = 1;
            while ($row = mysql_fetch_array($select_all_messages)){
                if ($row[read] == 0){
                    $b = '<strong>';
                    $ba = '</strong>';
                };
                if ($row[important] == 1){
                    if ($row[read] == 0){
                        $c = '<span class="important">';
                        $ca = '</span>';
                    };};
                    print '<tr>
                        <td>'.$c.''.$b.''.$count.''.$ba.''.$ca.'</td>
                        <td>'.$c.''.$b.''.$row[from].''.$ba.''.$ca.'</td>
                        <td>'.$c.''.$b.''.$row[subject].''.$ba.''.$ca.'</td>
                        <td>'.$c.''.$b.''.$row[date].''.$ba.''.$ca.'</td>
                        <td>'.$c.''.$b.'<a href="?act=inbox&amp;action=read&amp;id='.$row[id].'">Read</a> | <a href="index.php?act=inbox&amp;action=reply&amp;id='.$row[id].'">Reply</a> | <a href="index.php?act=inbox&amp;action=move&amp;id='.$row[id].'">Move</a> | <a href="index.php?act=inbox&amp;action=delete&amp;id='.$row[id].'">Delete</a>'.$ba.''.$ca.'</td>
                        </tr>';
                    $count++;
            };
            print '</table></table>';
        };
        if ($action == 'read'){
            if ($id != ''){
                print '<table class="table" align="center"><tr><td>';
                while ($row = mysql_fetch_array($read_msg)){
                    if ($row[important] == '1'){
                        $priority = '<span class="important">Important</span>';
                    };
                    if ($row[important] == '0'){
                        $priority = '<strong>Normal</strong>';
                    };
                    print '<strong>Subject:</strong> '.$row[subject].'<br />
                        <strong>From:</strong> '.$row[from].' <strong>To:</strong> '.$row[to].'<br />
                        <strong>Date:</strong> '.$row[date].'<br />
                        <strong>Priority:</strong> '.$priority.'<br />
                        &nbsp;&nbsp;<a href="?act=inbox&amp;action=reply&amp;id='.$row[id].'">Reply</a> | <a href="index.php?act=inbox&amp;action=move&amp;id='.$row[id].'">Move</a> | <a href="index.php?act=inbox&amp;action=delete&amp;id='.$row[id].'">Delete</a><br /><br /></td>
                        </tr>
                        <tr><td>'.$row[text].'</td>';
                };
                print '</tr></table>';
            };
        };
        if ($action == 'reply'){
            if ($id != ''){
                if ($group == 1){
                    $admin_check = 'Important: <input type="text" value="0" name="admin"><br />';
                };
                print '<table class="table" width="100%"><tr><td>';
                while ($row = mysql_fetch_array($find_un_msg)){
                    print '<form method="post" action="?act=inbox&amp;action=reply_to">
                        To: <input type="text" name="to" value="'.$row[username].'" /><br />
                        Subject: <input type="text" name="subject" value="RE: '.$row[subject].' " /><br />
                        Body:<br />
                        <textarea name="body" rows="10" cols="50"><quote>'.$row[text].'</quote></textarea><br /><br /><br />
                        '.$admin_check.'
                        <input type="submit" value="Send Message" name="submit" />
                        </form>';
                };
                print '</td></tr></table>';
            };
        };
        if ($action == 'reply_to'){
            if ($group == 1){
                if ($_POST['admin'] == '1'){
                    $admin = 1;
                };
                if ($_POST['admin'] == '0'){
                    $admin = 0;
                };
            };
            if ($group != 1){
                $admin = 0; 
            };
            print '<strong><center>Message Sent!</center></strong>';
        };
        if ($action == 'compose'){
            if ($group == 1){
                $admin_check = 'Important: <input type="text" value="0" name="admin"><br />';
            };
            print '<table class="table" align="center"><tr><td>
                <form method="post" action="?act=inbox&amp;action=reply_to">
                To: <input type="text" name="to" value="" /><br />
                Subject: <input type="text" name="subject" value="" /><br />
                Body:<br />
                <textarea name="body" rows="10" cols="50"></textarea><br />
                '.$admin_check.' <input type="hidden" value="100" name="set">
                <input type="submit" value="Send Message" name="submit" />
                </form>
                </td></tr></table>';
        };
        if ($action == 'delete'){
            if ($id != ''){
                if ($_POST[set] == 'delete'){
                    print '<strong>Message has been deleted.</strong></table>';
                };
                if (!isset($_POST[set])){
                    print '<strong>Are you sure you want to delete this message?</strong>';
                    print '<table class="table" align="center"><tr><td>';
                    while ($row = mysql_fetch_array($read_msg)){
                        if ($row[important] == '1'){
                            $priority = '<span class="important">Important</span>';
                        };
                        if ($row[important] == '0'){
                            $priority = 'Normal';
                        };
                        print '<strong>Subject:</strong> '.$row[subject].'<br />
                            <strong>From:</strong> '.$row[from].'<br />
                            <strong>To:</strong> '.$row[to].'<br />
                            <strong>Date:</strong> '.$row[date].'<br />
                            <strong>Priority:</strong> '.$priority.'<br />
                            <strong>Message:</strong> '.$row[text].'';
                    };
                    print '<form action="?act=inbox&amp;action=delete&amp;id='.$id.'" method="post">
                        <input type="hidden" name="set" value="delete">
                        <input type="submit" value="Yes, Delete this message" />
                        </form>
                        </td></tr></table>';
                };//if (!isset($_POST[set]))
            };//if ($id != '')
        };//if ($action == 'delete')
        if($action == 'change_folder'){
            print '<center>not implemented yet</center>';
        }
    };//if ($_SESSION['login'] == true)
};//if ($act == 'inbox')
?>
