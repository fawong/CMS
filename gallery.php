<?php 
if ($act == 'gallery'){
    if ($_SESSION['login'] != true){
        $_SESSION[error] = 'Error: Not Enough Access';
        redirect("failed.php");
    };
    if ($_SESSION['login'] == true){
        print '<h1>Gallery</h1>
            <hr width="250" align="left"/>';

        if ($action == ''){
            $count = 1;
            print '<table class="table" width="'.$settings[table_size].'"><tr><td><b>Newsest Uploaded Images</b></td></tr>';
            while ($row = mysql_fetch_array($find_newsest)){
                if ($count == '1' ){
                    print '<tr>';
                };
                print '<td><a href="?act=gallery&action=view&id='.$row[id].'"><img width="200" height="200" src="img/'.$row[filename].'"></a></td>';
                if ($count == '4'){
                    print '</tr>';
                    print '<tr>';
                };
                if ($count == '8'){
                    print '</tr>';
                };
                $count++;
            };
            print '</table>';
            if ($settings['shota_gallery'] == 1){
                $shota_gallery = '<tr><td><b>Public Shota Gallery</b></td></tr><Tr><Td>
                    <table class="table" width="'.$settings[table_size].'"><tr><Td>
                    <b>Types</b><br>
                    Animation()<br>
                    Animal/Beastie()<br>
                    Comics()<br>
                    Fan Art()<br>
                    Furry()<br>
                    Futuristic()<br>
                    General Shota()<br>
                    Outdoors()<br>
                    Rape/Torture()<br>
                    </Td>
                    <td>
                    <b>Anime</b><br>
                    Final Fantasy Series()<br>
                    Kingdom Hearts()<br>
                    Miscellaneous()<br>
                    Kakashi x Sasuke()<br>
                    Naruto X Sasuke()<br>
                    General Naruto()<br>
                    Sukisho()<br>
                    </td>
                    </tr></table>
                    </Td></Tr>';
            };
            print '<table class="table" width="'.$settings[table_size].'"><tr><td><b>Public Yaoi Galleries</b></td></tr><tr><td>
                <table class="table" width="600"><tr><Td>
                <b>Types</b><br>
                Animation()
                <br>
                Comics()<br>
                Fan Art()<br>
                Furry()<br>
                Futuristic()<br>
                General Yaoi()<br>
                Miscellaneous()<br></Td>
                <td>
                <b>Anime</b><br>
                DNAngel()<br>
                Final Fantasy Series()<br>
                Kingdom Hearts()<br>
                Kakashi x Sasuke()<br>
                Naruto X Sasuke()<br>
                General Naruto()<br>
                Sukisho()<br></td>
                </tr></table>

                </td></tr>'.$shota_gallery.'<tr><td><b>Search Gallery</b></td></tr>
                <tr><td><form action="?act=gallery&action=search" method="post">Quick Search:<input name="query" type="text" size="50" />
                <input type="submit" value="Search"><br><br>
                </form></td></tr><tr><td><b>Advance Search</b></td></tr><tr><td>
                <!-- <form action="?act=gallery&action=search_adv" method="post" name="adv_search">
                Search:<input name="search" type="text" size="50" /><br>
                Search By:
                <select name="search_by">
                <option selected="selected">Title and Description</option>
                <option>Author</option>
                <option>Submitted By</option>
                <option>Date Submitted</option>
                <option>Selected Galleries</option>
                <option>Highest Views</option>
                <option>Lowest Views</option>
                <option>Highest Rated</option>
                <option>Lowest Rated</option>
                </select><br>
                <div id="search_options"></div>
                <input type="submit" value="Search">
                </form> --></td></tr></table>';
        };

        if ($action == 'cat'){
            if ($cat != ''){


                if($_GET['page']) // Is page defined?
                {
                    $page = $_GET['page']; // Set to the page defined
                }else{
                    $page = 1; // Set to default page 1
                }
                $max = 15; // Set maximum to 10

                $cur = (($page * $max) - $max); // Work out what results to show
                $counta = 1;
                while ($row = mysql_fetch_array($getdata)){
                    if ($counta == 1){
                        print '<tr>';
                    };
                    print '<td><a href="?act=gallery&action=view&id='.$row[id].'"><img width="200" height="200" src="/gallery/img/'.$row[filename].'"></a></td>';
                    if ($counta == 4){
                        print '</tr>';
                        $counta = 0;
                    };
                    $counta++;
                }; // get the data

                $total_pages = ceil($counttotal / $max); // dive the total, by the maximum results to show 
                print '<table class="table" width="250" align="center"><tr><td>';
                if($page > 1){ // is the page number more than 1?
                    $prev = ($page - 1); // if so, do the following. take 1 away from the current page number
                    echo '<a href="?act=gallery&action=cat&cat='.$cat.'&page=' . $prev . '">« Previous</a>'; // echo a previous page link
                }

                for($i = 1; $i <= $total_pages; $i++) // for each page number
                {
                    if($page == $i) // if this page were about to echo = the current page
                    {
                        echo'<b>[' . $i .']</b> '; // echo the page number bold
                    } else {
                        echo '<a href="?act=gallery&action=cat&cat='.$cat.'&page=' . $i . '">' . $i . '</a> '; // echo a link to the page
                    }
                }

                if($page < $total_pages){ // is there a next page?
                    $next = ($page + 1); // if so, add 1 to the current
                    echo '<a href="?act=gallery&action=cat&cat='.$cat.'&page=' . $next . '">Next »</a>'; // echo the next page link
                } 
                print '</td></tr></table>';

            };
        };

        if ($action == 'view'){
            if ($id != ''){
                while($row = mysql_fetch_array($getimg)){
                    print '<table class="table" width="'.$settings[table_size].'"><tr><td>
                        <h1>'.$row[name].' by: '.$row[author].'</h1><hr width="250" align="left" />
                        </td></tr>
                        <tr><td width="'.$row[file_L].'" height="'.$row[file_H].'">
                        <center><img src="'.$row[file_path].'" width="'.$frow[file_L].'" height="'.$row[file_H].'"/></center>
                        </td></tr>
                        <tr><td>
                        <center>					  <a href="?act=gallery&action=report&id='.$row[id].'">Report Image</a> |<a href="index.php?act=gallery&amp;action=add_fave&amp;id='.$row[id].'"> Add To Favorites</a> </center>
                        </td></tr>
                        <tr><td>
                        Information:
                        <table class="table" width="500"><tr><Td>
                        Name: '.$row[name].'<br />
                        Submitted by: <a href="profile.php?action=view&id='.$row[submited_by].'">'.$row[submited_by].'</a><br />
                        Author: '.$row[author].'<br />
                        File Size: '.$row[file_size].'<br />
                        File Type: '.$row[file_type].'<br />
                        Image Dimensions: '.$row[file_L].' x '.$row[file_H].'<br />
                        Views: '.$row[views].'<br />
                        Comments:'.comments($id).'<br />
                        </Td></tr></table>
                        </td></tr>
                        <tr><td><Center>'.$_SESSION[saved].'</Center>
                        <h1>Comments</h1><hr width="250" align="left" />
                        <br />

                        <table class="table" width="450">';
                    $count = 0;
                    while ($row = mysql_fetch_array($find_comments)){
                        while ($con = mysql_fetch_array($find_avatar))
                        {
                            $abs[$count][avatar] = $row[avatar];
                        };
                        print '
                            <tr><td><center><a href="profile.php?action=view&id='.$row[username].'">'.$row[username].'<br /><img align="middle" src="'.$abs[$count][avatar].'" /></a></center></td><td>'.$row[comment].'</td></tr>';
                        $count++;
                    };
                    print '
                        </table>
                        <br />
                        <form action="?act=gallery&action=comment&id='.$row[id].'" method="post">
                        <center><strong>Add a Comment</strong> <br />
                        <textarea name="comment" rows="8" cols="50">
                        </textarea>
                        <br /><input type="submit" value="Submit Comment" /></center>
                        </form>
                        </td></tr>
                        </table>';
                };
            };
        };
        if ($action == 'upload_file'){
            print '<form action="?act=gallery&action=upload&path='.$_SESSION[path].'" method="post" enctype="multipart/form-data">
                Title: <input name="title" type="text" size="30">

                <br>
                Author: <input name="author" type="text" size="30"><br>
                Category: 
                <select name="cat"><option selected="selected" value="">-</option>
                </select><br />
                Description:<br />
                <textarea id="textarea1" name="description" style="height: 170px; width: 500px;">

                </textarea>
                <script language="javascript1.2">
generate_wysiwyg(\'textarea1\');
</script>
<br />
<hr />
 <center>
   <strong>* Max File Size: '.size_file($settings['img_size']).'   </strong>
 </center>
<br />
Upload File: <input name="file" type="file" size="50" /><br />
<input type="submit" value="Upload File" />
</form>';
while ($row = mysql_fetch_array($find_cat)){
print '<option value="'.$row[id].'">'.$row[name].'</option>';
};
};
if($action == 'upload' && $_FILES['file']['name'] != ""){
$path_parts = pathinfo($_FILES['file']['name']);
$set_to = '0';
 if($path_parts['extension'] != 'jpg'){
  if($path_parts['extension'] != 'jpeg'){
   if($path_parts['extension'] != 'gif'){
    if($path_parts['extension'] != 'bmp'){
 if($path_parts['extension'] != 'png'){
 $set_to = '5';
 };
    };
   };
  };
 };
 if ($set_to == '0'){
     if ($_FILES['file']['size'] || $settings['img_size'] || $group_id == 1){
   $local_file = $_FILES['file']['tmp_name']; // Defines Name of Local File to be Uploaded

   $destination_file = basename($_FILES['file']['name']);  // Path for File Upload (relative to your login dir)

   // Global Connection Settings
   $ftp_server = "127.0.0.1";      // FTP Server Address (exlucde ftp://)
   $ftp_user_name = "img@yaoi.dhs1.net";    // FTP Server Username
   $ftp_user_pass = "oinky";      // Password

   // Connect to FTP Server
   $conn_id = ftp_connect($ftp_server);
   // Login to FTP Server
   $login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);

   // Verify Log In Status
   if ((!$conn_id) || (!$login_result)) {
       echo "Connection has failed! <br />";
       exit;
   };

   $upload = ftp_put($conn_id, $destination_file, $local_file, FTP_BINARY);  // Upload the File

   // Verify Upload Status
   if (!$upload) {
       echo "<h2>Upload of ".$_FILES['file']['name']." has failed!</h2><br /><br />";
   } else {
   $file_id = rand(0000000000,999999999);
       echo "Success!<br />" . $_FILES['file']['name'] . " has been uploaded.<br /><br />";
        if ($save){
        print '<a href="?act=gallery&action=view&id=">Click here to view your sumbited image.</a>';
        };
   }

   ftp_close($conn_id); // Close the FTP Connection
   }else{
   print 'Error: The file uploaded is greater then the file size limit.';
   };
   }else{ print 'Error: Unexceptable File Extension.';};
};
if ($action == 'comment'){
 if ($id != ''){
 $_SESSION[saved] = "Your comment has been saved correctly.<br>";
 redirect("?act=gallery&action=view&id=$id");
 };
};

if ($action == 'search'){
if ($_POST[query] != ''){
print '<table class="table" width="'.$settings[table_size].'">';
    if($_GET['page']) // Is page defined?
    {
        $page = $_GET['page']; // Set to the page defined
    }else{
        $page = 1; // Set to default page 1
    }
$max = 15; // Set maximum to 10

$cur = (($page * $max) - $max); // Work out what results to show
 $counta = 1;
while ($row = mysql_fetch_array($getdata)){
if ($counta == 1){
print '<tr>';
};
print '<td><a href="?act=gallery&action=view&id='.$row[id].'"><img width="100" height="100" src="/gallery/img/'.$row[filename].'"></a></td>';
if ($counta == 5){
print '</tr>';
$counta = 0;
};
$counta++;
}; // get the data
 print '</table>';

$total_pages = ceil($counttotal / $max); // dive the total, by the maximum results to show 
 print '<table class="table" width="'.$settings[table_size].'" align="center"><tr><td>';
if($page > 1){ // is the page number more than 1?
                $prev = ($page - 1); // if so, do the following. take 1 away from the current page number
                echo '<a href="?act=gallery&action=cat&cat='.$cat.'&page=' . $prev . '">« Previous</a>'; // echo a previous page link
                }

for($i = 1; $i <= $total_pages; $i++) // for each page number
                {
                    if($page == $i) // if this page were about to echo = the current page
                        {
                            echo'<b>[' . $i .']</b> '; // echo the page number bold
                                } else {
                            echo '<a href="?act=gallery&action=cat&cat='.$cat.'&page=' . $i . '">' . $i . '</a> '; // echo a link to the page
                        }
                }

if($page < $total_pages){ // is there a next page?
                    $next = ($page + 1); // if so, add 1 to the current
                echo '<a href="?act=gallery&action=cat&cat='.$cat.'&page=' . $next . '">Next »</a>'; // echo the next page link
                    } 
print '</td></tr></table>';

};
};

if ($_SESSION[saved] != ''){
$_SESSION[saved] = '';
};

};};

?>
<?php

//if ($act == 'gallery'){
//print '<h1>Gallery</h1><hr width="250">';
//title("Alawelfjlry");
//Newest Uploaded Images




//};
?>
