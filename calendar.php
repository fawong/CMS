<?php
if ($act == 'calendar'){
error_reporting('0'); 
ini_set('display_errors', '0'); 
// Gather variables from 
// user input and break them 
// down for usage in our script 

if(!isset($_REQUEST['date'])){ 
$date = mktime(0,0,0,date('m'), date('d'), date('Y')); 
} else { 
$date = $_REQUEST['date']; 
} 

$day = date('d', $date); 
$month = date('m', $date); 
$year = date('Y', $date); 

// Get the first day of the month 
$month_start = mktime(0,0,0,$month, 1, $year); 

// Get friendly month name 
$month_name = date('F', $month_start); 

// Figure out which day of the week 
// the month starts on. 
$month_start_day = date('D', $month_start); 

switch($month_start_day){ 
case 'Sun': $offset = 0; break; 
case 'Mon': $offset = 1; break; 
case 'Tue': $offset = 2; break; 
case 'Wed': $offset = 3; break; 
case 'Thu': $offset = 4; break; 
case 'Fri': $offset = 5; break; 
case 'Sat': $offset = 6; break; 
} 

// determine how many days are in the last month. 
if($month == 1){ 
$num_days_last = cal_days_in_month(0, 12, ($year -1)); 
} else { 
$num_days_last = cal_days_in_month(0, ($month -1), $year); 
} 
// determine how many days are in the current month. 
$num_days_current = cal_days_in_month(0, $month, $year); 

// Build an array for the current days 
// in the month 
for($i = 1; $i <= $num_days_current; $i++){ 
$num_days_array[] = $i; 
} 

// Build an array for the number of days 
// in last month 
for($i = 1; $i <= $num_days_last; $i++){ 
$num_days_last_array[] = $i; 
} 

// If the $offset from the starting day of the 
// week happens to be Sunday, $offset would be 0, 
// so don't need an offset correction. 

if($offset > 0){ 
$offset_correction = array_slice($num_days_last_array, -$offset, $offset); 
$new_count = array_merge($offset_correction, $num_days_array); 
$offset_count = count($offset_correction); 
} 

// The else statement is to prevent building the $offset array. 
else { 
$offset_count = 0; 
$new_count = $num_days_array; 
} 

// count how many days we have with the two 
// previous arrays merged together 
$current_num = count($new_count); 

// Since we will have 5 HTML table rows (TR) 
// with 7 table data entries (TD) 
// we need to fill in 35 TDs 
// so, we will have to figure out 
// how many days to appened to the end 
// of the final array to make it 35 days. 


if($current_num > 35){ 
$num_weeks = 6; 
$outset = (42 - $current_num); 
} elseif($current_num < 35){ 
$num_weeks = 5; 
$outset = (35 - $current_num); 
} 
if($current_num == 35){ 
$num_weeks = 5; 
$outset = 0; 
} 
// Outset Correction 
for($i = 1; $i <= $outset; $i++){ 
$new_count[] = $i; 
} 

// Now let's 'chunk' the $all_days array 
// into weeks. Each week has 7 days 
// so we will array_chunk it into 7 days. 
$weeks = array_chunk($new_count, 7); 


// Build Previous and Next Links 
$previous_link = '<a href="?act=calendar&date='; 
if($month == 1){ 
$previous_link .= mktime(0,0,0,12,$day,($year -1)); 
} else { 
$previous_link .= mktime(0,0,0,($month -1),$day,$year); 
} 
$previous_link .= '"><< Prev</a>'; 

$next_link = '<a href="?act=calendar&date='; 
if($month == 12){ 
$next_link .= mktime(0,0,0,1,$day,($year + 1)); 
} else { 
$next_link .= mktime(0,0,0,($month +1),$day,$year); 
} 
$next_link .= '">Next >></a>'; 

if ($_SESSION['group'] == 'admin' || $_SESSION['access_calendar'] == 1){
print '<a href="?act=calendar&action=add_event&date='.$date.'">[Add Event to Current Date]</a>';
};


// Build the heading portion of the calendar table 
echo '<table class="table" cellpadding="2" cellspacing="0" width="300" class="calendar" align="center">'. 
'<tr>'. 
'<td colspan="7">'. 
'<table class="table" align="center">'. 
'<tr>'. 
'<td colspan="2" width="75" align="left">' . $previous_link . '</td>'. 
'<td colspan="3" width="150" align="center">' . $month_name .' '. $year .'</td>'. 
'<td colspan="2" width="75" align="right">'.$next_link.'</td>'. 
'</tr>'. 
'</table>'. 
'</td>'. 
'<tr>'. 
'<td>S</td><td>M</td><td>T</td><td>W</td><td>T</td><td>F</td><td>S</td>'. 
'</tr>'; 
// Now we break each key of the array  
// into a week and create a new table row for each 
// week with the days of that week in the table data 
$i = 0; 
foreach($weeks AS $week){ 
echo '<tr>'; 
foreach($week as $d){ 
if($i < $offset_count){ 
$day_link = '<a href="?act=calendar&date='.mktime(0,0,0,$month -1,$d,$year).'">'.$d.'</a>'; 
$last_month = mktime(0,0,0,$month -1,$d,$year);
$find_mate = mysql_query('SELECT * FROM calendar');
$count_may = 0;
while($row = mysql_fetch_array($find_love)){
$les_day_fa[$count_may] = date('d', $row[date]);
$les_month_fa[$count_may] = date('m', $row[date]);
$les_year_fa[$count_may] = date('y', $row[date]);  
$les_complex_fa[$count_may] = $les_month[$count].'-'.$les_day[$count].'-'.$les_year[$count];
if (preg_match('/$last_month/i', 'row[date]')){
$count_may++;
};
};
if ($count_may >= 1){
echo '<td class="nonmonthdays_event">' .$day_link.'</td>';
}else{
echo '<td class="nonmonthdays">'.$day_link.'</td>';
};
} 
if(($i >= $offset_count) && ($i < ($num_weeks * 7) - $outset)){ 
$day_link = '<a href="?act=calendar&date='.mktime(0,0,0,$month,$d,$year).'">'.$d.'</a>'; 
if($date == mktime(0,0,0,$month,$d,$year)){
$this_month = mktime(0,0,0,$month,$d,$year);
$find_love = mysql_query('SELECT * FROM calendar');
$count = 0;
while($row = mysql_fetch_array($find_love)){
$les_tick_da[$count] = $row[date];
$les_day_da[$count] = date('d', $row[date]);
$les_month_da[$count] = date('m', $row[date]);
$les_year_da[$count] = date('y', $row[date]);  
$les_complex_da[$count] = $les_month_da[$count].'-'.$les_day_da[$count].'-'.$les_year_da[$count];
if ($row[date] == $this_month){
$count++;
};
}; 		    
/*if ($count >= 1){
echo '<td class='today_event'>$d</td>'; 
}else{
echo '<td class='today'>$d</td>'; 
};*/
$funt = 0;
if ($count >= 1){
if ($les_tick_da[$funt] == $this_month){
print '<td class="today_event">'.$d.'</td>';
$count--;
$funt++;
};
}else{
echo '<td class="today">'.$d.'</td>'; 
};
} else { 
$this_month = mktime(0,0,0,$month,$d,$year);
$find_hate = mysql_query('SELECT * FROM calendar');
$count_day = 0;
while($row = mysql_fetch_array($find_love)){
$les_tick_ma[$count_day] = $row[date];
$les_day_ma[$count_day] = date('d', $row[date]);
$les_month_ma[$count_day] = date('m', $row[date]);
$les_year_ma[$count_day] = date('y', $row[date]);  
$les_complex_ma[$count_day] = $les_month_ma[$count_day].'-'.$les_day_ma[$count_day].'-'.$les_year_ma[$count_day];
if ($row[date] == $this_month){
$count_day++;
};
};
$font = 0;
if ($count_day >= 1){
if ($les_tick_ma[$font] == $this_month){
echo '<td class="days_event">'.$day_link.'</td>';
$count_day--;
$font++;
};
}else{
echo '<td class="days">'.$day_link.'</td>';
};
/*if ($count_day >= 1){
echo '<td class='days_event'>$day_link</td>';
}else{
echo '<td class='days'>$day_link</td>';
};*/ 
} 
} elseif(($outset > 0)) { 
if(($i >= ($num_weeks * 7) - $outset)){ 
$next_month = mktime(0,0,0,$month +1,$d,$year);
$day_link = '<a href="?act=calendar&date='.mktime(0,0,0,$month +1,$d,$year).'">$d</a>'; 
$find_cake = mysql_query('SELECT * FROM calendar');
$count_cake = 0;
while($row = mysql_fetch_array($find_love)){
$les_day_ka[$count_cake] = date('d', $row[date]);
$les_month_ka[$count_cake] = date('m', $row[date]);
$les_year_ka[$count_cake] = date('y', $row[date]);  
$les_complex_ka[$count_cake] = $les_month[$count].'-'.$les_day[$count].'-'.$les_year[$count];
if ($next_month == $row[date] ){

$count_cake++;
};
};
if ($count_cake >= 1){
echo '<td class="nonmonthdays_event">'.$day_link.'</td>';
$count_cake--;
}else{
echo '<td class="nonmonthdays">'.$day_link.'</td>';
};
} 
} 
$i++; 
} 
echo '</tr>';    
} 

// Close out your table and that's it! 
echo '<tr><td colspan="7" class="days"></td></tr>'; 
echo '</table>'; 
/*print $count;
print $count_cake;
print $count_day;
print $count_may;
print $funt;
print $font;*/
?> 
<br /><br />
<table class="table" width='500' align='center' bordercolor='#0066CC'>
<?php 

if ($action == ''){

/*$find = mysql_query('SELECT * FROM calendar WHERE `date` = '$date'');
while ($row = mysql_fetch_array($find)){
if ($group == 'admin' || $_SESSION['access_calendar'] == 1){
$admin_funcs = '<div align='right'><a href='?act=calendar&action=event_edit&id='.$row[id].''>Edit Post</a> -<a href='index.php?act=calendar&action=event_delete&id='.$row[id].''> Delete Post
</a></div>';}else{
$admin_funcs = '';
};
print '<tr bordercolor='#0066CC'><td>
<strong>'.$row[title].'</strong>
&nbsp;&nbsp;&nbsp;-posted by: <a href='?act=profile&action=view&id='.$row[username].''>'.$row[username].'</a> Date: '.date('m-d-Y', $row[date]).'
</td>
</tr><tr bordercolor='#0066CC'><td>
<p>&nbsp;&nbsp;'.$row[text].'</p><br />'.$admin_funcs.'
</td></tr>';
};*/

$fastd = 7;
$count_dj = 0;
while ($fastd >= 1){
$kadate = mktime(0,0,0,$month,$day+$count_dj,$year);
$find = mysql_query("SELECT * FROM calendar WHERE `date` = '$kadate' LIMIT 1");
while ($row = mysql_fetch_array($find)){
if ($_SESSION['group'] == 'admin' || $_SESSION['access_calendar'] == 1){
$admin_funcs = '<div align="right"><a href="?act=calendar&action=event_edit&id='.$row[id].'">Edit Post</a> -<a href="index.php?act=calendar&action=event_delete&id='.$row[id].'"> Delete Post
</a></div>';}else{
$admin_funcs = '';
};
print '<tr bordercolor="#0066CC"><td>
<strong>'.$row[title].'</strong>
&nbsp;&nbsp;&nbsp;-posted by: <a href="?act=profile&action=view&id='.$row[username].'">'.$row[username].'</a> <b>Date: '.date('m-d-Y', $row[date]).'</b>
</td>
</tr><tr bordercolor="#0066CC"><td>
<p>&nbsp;&nbsp;'.$row[text].'</p><br />'.$admin_funcs.'
</td></tr>';
};

$count_dj++;
$fastd--;
};

};

if ($action == 'add_event'){
print '<tr><td>';
print '<h1>Add an Event</h1><br />';
print '<form action="?act=calendar&action=save_event" method="post">
Title: <input type="text" name="title" value="" /><br />
Date: <input type="text" disabled="disabled" name="fun" value="".$month."-".$day."-".$year."" /> <input name="date" type="hidden" value="'.$date.'"/><br />
Description:<br />
<textarea name="text" cols="50" rows="10"> </textarea><br />
<input type="submit" name="Submit" value="Submit" />
</form>';
print '</td></tr>';
};

if ($action == 'save_event'){
print '<tr><td>';
$save = mysql_query("INSERT INTO `calendar` VALUES ('', '$_POST[title]', '$_POST[date]', '$username', '$_POST[text]')") or die ('Mysql Error: '.mysql_error());
print '<strong>Event:'.$_POST[title].' on '.$month.'-'.$day.'-'.$year.' has been saved.</strong>';
print '</td></tr>';
};

if ($action == 'event_edit'){
print '<tr><td>';
print '<h1>Edit Event</h1><br />';
$find = mysql_query("SELECT * FROM calendar WHERE `id` ='$id'");
while ($row = mysql_fetch_array($find)){
print '<form action="?act=calendar&action=event_save&id=".$id."" method="post">
Title: <input type="text" name="title" value="'.$row[title].'" /><br />
Date:<input type="text" disabled="disabled" name="fun" value="'.date("m-d-Y", $row[date]).'" />
<input name="date" type="hidden" value="'.$row[date].'"/><br />
Description:<br />
<textarea name="text" cols="50" rows="10">'.$row[text].'</textarea><br />
<input type="submit" name="Submit" value="Submit" />
</form>';

};
print '</td></tr>';
};
if ($action == 'event_save'){
print '<tr><td>';
$save = mysql_query("UPDATE `calendar` SET `title` ='$_POST[title]', `text` ='$_POST[text]' WHERE `id` ='$id'") or die ('Mysql Error: '.mysql_error());
print '<strong>Event:'.$_POST[title].' on '.date('m-d-Y', $_POST[date]).' has been saved.</strong>';
print '</td></tr>';
};

if ($action == 'event_delete'){

$find = mysql_query("SELECT * FROM calendar WHERE `id` ='$id' LIMIT 1");
while ($row = mysql_fetch_array($find)){
print '<tr><td>
<strong>Are you sure you want to delete this event?</strong>
<br />
'.$row[title].'
&nbsp;&nbsp;&nbsp;-posted by: <a href="?act=profile&action=view&id='.$row[username].'">'.$row[username].'</a> Date: '.$row[date].'
</td>
</tr><tr><td>
<p>&nbsp;&nbsp;'.$row[post].'</p>'.$admin_funcs.'
</td></tr>';
print '<form action="?act=calendar&action=delete_event&id='.$id.'" method="post">
<input type="submit" name="Delete Event" value="Delete Event" />
</form>';
};
};
if ($action == 'delete_event'){
print '<tr><td>';
$delete = mysql_query("DELETE FROM `calendar` WHERE `id` ='$id'") or die (mysql_error());
print 'Event: '.$id.' has been deleted.';
print '</td></tr>';  
};
print '</table>';
};
?>
