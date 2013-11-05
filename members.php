<?php 
include_once('functions.php');

if ($_SESSION['login'] != true) {
    redirect("failed.php?id=2");
} else {
    // DISPLAY MEMBERS LIST
    if ($get_action == 'view') {
        title("Members List");
        page_header('Members List');
        if ($users = $db->get_results("SELECT * FROM `users` ORDER BY username ASC")) {
?>
<p>Total Number of Members: <?php print $db->num_rows ?></p>
<table class="table">
<tr>
<th>Username</th>
<th>Group</th>
</tr>
<?php
            foreach ($users as $user) {
?>
<tr>
<td>
<a href="profile.php?action=view&amp;username=<?php print $user->username ?>"><?php print $user->username ?></a>
</td>
<td><?php print $user->user_group ?></td>
<?php
            };
?>
</tr>
</table>
<?php
        };
    };
};
include_once('footer.php');
?>
