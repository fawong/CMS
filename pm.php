<?php 
require_once('functions.php');

if ($login != true) {
    redirect('failed.php?id=3');
} else {
    $current_folder = 'inbox';

    // INBOX
    if ($get_action == 'inbox' || $get_action == '') {
        title("Inbox");
        page_header('Inbox');
?>
<p>Current Folder: <?php print $current_folder ?></p>
<p>Total Usage: <?php print pm_usage() ?> (Used/Maximum)</p>
<p><a href="?act=inbox&amp;action=compose">Compose</a></p>

<form method="post" role="form" action="?action=change_folder">
Change Folder: 
<div class="form-group">
<div class="col-sm-2">
<select name="folder" class="form-control"> 
<option value="inbox" selected="selected">Inbox</option>
<option value="outbox">Outbox</option>
<option value="drafts">Drafts</option>
<option value="sent">Sent</option>
<option value="trash">Trash</option>
<option value="spam">Spam</option>
</select>
</div>
<button type="submit" class="btn btn-primary">Go!</button>
</div>
</form>

<?php
        $results = $db->get_results("SELECT * FROM `personal_messages` WHERE `to_user_id` = $user_id ORDER BY `timestamp`");
        if ($results) {
?>
<table class="table">
<tr>
<td>Number</td>
<td>From</td>
<td>Subject</td>
<td>Date</td>
<td>Options</td>
</tr>
<?php
            $count = 1;
            foreach ($results as $message) {
?>
<tr>
<td><?php print $count ?></td>
<td><?php print id2username($message->from_user_id) ?></td>
<td><?php print $message->subject ?></td>
<td><?php print timestamp2date($message->timestamp) ?></td>
<td><a href="?action=read&amp;id=<?php print $message->id ?>">Read</a> | <a href="?action=reply&amp;id=<?php print $message->id ?>">Reply</a> | <a href="?action=move&amp;id=<?php print $message->id ?>">Move</a> | <a href="?action=delete&amp;id=<?php print $message->id ?>">Delete</a></td>
</tr>
<?php
                $count++;
            };
        } else {
?>
<h4>You have no messages</h4>
<?php
        };
?>
</table>
<?php
    };

    // READ
    if ($get_action == 'read') {
        if ($get_id != '') {
            $message = $db->get_row("SELECT * FROM `personal_messages` WHERE `id` = $get_id");
            title($message->subject);
            page_header($message->subject);
?>
<p><strong>Subject:</strong> <?php print $message->subject ?></p>
<p><strong>From:</strong> <?php print id2username($message->from_user_id) ?></p>
<p><strong>To:</strong> <?php print id2username($message->to_user_id) ?></p>
<p><strong>Date:</strong> <?php print timestamp2date($message->timestamp) ?></p>
<p><?php print $message->text ?></p>
<a href="?action=reply&amp;id=<?php print $message->id ?>">Reply</a> | <a href="index.php?action=move&amp;id=<?php print $message->id ?>">Move</a> | <a href="index.php?action=delete&amp;id=<?php print $message->id ?>">Delete</a>
<?php
        };
    };

    // REPLY
    if ($get_action == 'reply') {
        if ($get_id != '') {
            $message = $db->get_row("SELECT * FROM `personal_messages` WHERE `id` = $get_id");
            title($message->subject);
            page_header('Reply to ' . $message->subject);
?>
<form method="post" role="form" action="?action=submit_reply">
<div class="form-group">
<label>To:</label>
<input type="text" class="form-control" name="to" value="<?php print id2username($message->from_user_id) ?>" /></p>
</div>
<div class="form-group">
<label>Subject:</label>
<input type="text" class="form-control" name="subject" value="RE: <?php print $message->subject ?>" /></p>
</div>
<div class="form-group">
<label>Body:</label>
<textarea name="body" class="form-control"><quote><?php print $message->text ?></quote></textarea>
</div>
<button type="submit" class="btn btn-lg btn-primary" name="submit">Send Message</button>
</form>
<?php
        };
    };

    // SUBMIT REPLY
    if ($get_action == 'submit_reply') {
        $to_id = username2id($_POST['to']);
        if ($to_id == -1) {
            page_header("Username not found");
?>
Username not found
<?php
        } else {
          $subject = $_POST['subject'];
          $body = $_POST['body'];
          $db->query("INSERT INTO `personal_messages` (`subject`, `from_user_id`, `to_user_id`, `text`) VALUES ('$subject', '$user_id', '$to_id', '$body')");
          page_header('Message Sent!');
?>
Message sent!
<?php
        };
    };

    // COMPOSE MESSAGE
    if ($get_action == 'compose') {
        title("Compose New Message");
        page_header('Compose New Message');
?>
<form method="post" action="?action=submit_reply">
<div class="form-group">
<label>To:</label>
<input type="text" class="form-control" name="to" value="" />
</div>
<div class="form-group">
<label>Subject:</label>
<input type="text" class="form-control" name="subject" value="" />
</div>
<div class="form-group">
<label>Body:</label>
<textarea name="body" class="form-control" rows="10" cols="50"></textarea>
</div>
<button type="submit" class="btn btn-lg btn-primary" name="submit">Send Message</button>
</form>
<?php
    };

    // DELETE MESSAGE
    if ($get_action == 'delete') {
        if ($get_id != '') {
            page_header('Delete Message');
            $message = $db->get_row("SELECT * FROM `personal_messages` WHERE `id` = $get_id");
?>
<h2>Are you sure you want to delete this message?</h2>
<p><strong>Subject:</strong> <?php print $message->subject ?></p>
<p><strong>From:</strong> <?php print id2username($message->from_user_id) ?></p>
<p><strong>To:</strong> <?php print id2username($message->to_user_id) ?></p>
<p><strong>Date:</strong> <?php print timestamp2date($message->timestamp) ?></p>
<p><strong>Message:</strong> <?php print $message->text ?></p>

<form action="?action=submit_delete&amp;id=<?php print $message->id ?>" class="form" role="form" method="post">
<button type="submit" class="btn btn-lg btn-primary">Yes, delete this message</button>
<button type="button" class="btn btn-lg" onclick="history.go(-1)">No</button>
</form>
<?php
        };
    };

    if ($get_action == 'submit_delete') {
        $db->query("DELETE FROM `personal_messages` WHERE `id` = $get_id");
        page_header('Message has been deleted');
?>
Message has been deleted.
<?php
    };

    if($get_action == 'change_folder') {
        print '<center>not implemented yet</center>';
    };
};
require_once('footer.php');
?>
