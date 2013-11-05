<?php 
include_once('functions.php');

if ($_SESSION['login'] != true) {
    redirect("failed.php?id=2");
} else {
    // DISPLAY MEMBERS LIST
    if ($action == 'view') {
        $select_all_members = mysql_query("SELECT * FROM `users`") or die (mysql_error());
        $total_members = mysql_num_rows($select_all_members) or die (mysql_error());
        $find_members = mysql_query("SELECT * FROM users ORDER BY username ASC");
        title("Members List");
        page_header('Members List');
?>
<p>Total Number of Members: <?php print $total_members ?></p>
<table class="table">
<tr>
<th>Username</th>
<th>Group</th>
</tr>
<?php
        while($row = mysql_fetch_array($find_members)) {
?>
<tr>
<td>
<a href="profile.php?action=view&amp;username=<?php print $row['username'] ?>"><?php print $row['username'] ?></a>
</td>
<td><?php print $row['user_group'] ?></td>
<?php
        };
?>
</tr>
</table>
<?php
    };
};
include_once('footer.php');
?>
