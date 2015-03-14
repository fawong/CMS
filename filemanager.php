<?php 
if ($_SESSION['login'] != true){
    redirect("failed.php?id=2");
};
if ($_SESSION['login'] == true){
    if($act == 'manager'){
        title("File Manager");
        if($_SESSION['access_file_manager'] == 0){
            redirect("failed.php?id=2");
        };
        if($_SESSION['access_file_manager'] == 1){
            function size_file($size){
                //Returns a human readable size
                $i = 0;
                $iec = array(" Byte(s)", " Kilobyte(s)", " Megabyte(s)", " Gigabyte(s)", " Terabyte(s)", " Petabyte(s)", " Exabyte(s)", " Zettabyte(s)", " Yottabyte(s)");
                while(($size / 1024) > 1){
                    $size = $size / 1024;
                    $i++;
                };
                return substr($size, 0, strpos($size, '.') + 4).$iec[$i];
            };
            //Usage : size_hum_read(filesize($file));
            //open a file
            $fp = fopen($settings['file_path'].$_SESSION['username'], "r");
            //gather statistics
            $fstat = fstat($fp);
            //close the file
            fclose($fp);
            //print only the associative part
            array_slice($fstat, 13);
            if($path == '' || $_SESSION['path'] == ''){
                $path = $settings['file_path'].$_SESSION['username'].'/';
                $_SESSION['path'] = $path;
            };
            $dirname = '/files/';
            if($group_id == 1){
                $_SESSION[limit_space] = 'unmetered';
            }else{
                $thequery = 'SELECT `file_space` FROM `users` WHERE `username` = ' . $_SESSION['username'];
                while($row = mysql_fetch_array($find_s)){
                    $_SESSION[limit_space] = size_file($row[file_space]);
                };
            };
            if($action == ''){
                $dirname = $settings['file_path'].$_SESSION['path'];
                page_header('File Manager');
?>
                    <p>Current Directory: <strong><?php print $_SESSION['path'] ?></strong>
                    <p>Current Directory Size: <strong><?php print size_file($_SESSION['dir_s']) ?></strong>
                    <p>Total Disk Space Usage: <strong><?php print size_file($_SESSION['dir_t']) ?></strong>
                    <p>Total Disk Space Limit: <strong><?php print $_SESSION['limit_space'] ?></strong>
                    <br />
                    <a href="?act=manager&action=create_new_file&path=<?php print $_SESSION['path'] ?>">Create New File</a> | 
                    <a href="?act=manager&action=create_new_folder&path=<?php print $_SESSION['path'] ?>">Create New Folder</a> | 
                    <a href="?act=manager&action=upload_file&path=<?php print $_SESSION['path'] ?>">Upload a File</a> | 
                    <a href="?act=manager&action=view_folder&cpath=<?php print $_SESSION['username'] ?>/">Parent Directory</a>
                    <table class="table" align="center">
                    <tr>
                    <td><strong><center>File Name</center></strong></td>
                    <td><strong><center>Size</center></strong></td>
                    <td><strong><center>CHMOD</center></strong></td>
                    <td><strong><center>Options</center></strong></td>
                    </tr>
<?php
                //Obtain Directory Handle
                $dirhandle = opendir($dirname);
                $want = 1;
                while(FALSE !=($filename = readdir($dirhandle)))
                {
                    if(($filename != ".") and($filename != ".."))
                    {
                        if(!is_file($dirname.$filename)){
                            //view edit move copy rename CHMOD delete
                            print '<tr>
                                <td><img src="themes/' . $_SESSION[theme] . '/images/i-directory.gif"> '.$filename.'</td>
                                <td><center>'.size_file(filesize($dirname.$filename)).'</center></td>
                                <td><center>'.substr(sprintf('%o', fileperms($dirname.'/'.$filename)), -3).'</center></td>
                                <td>
                                <a href="?act=manager&action=view_folder&cpath='.$_SESSION['path'].$filename.'/">View</a> | 
                                <a href="?act=manager&action=move_folder&path='.$_SESSION['path'].'&file='.$filename.'">Move</a> | 
                                <a href="?act=manager&action=rename_folder&path='.$_SESSION['path'].'&file='.$filename.'">Rename</a> |  
                                <a href="?act=manager&action=chmod_folder&path='.$_SESSION['path'].'&file='.$filename.'">CHMOD</a> | 
                                <a href="?act=manager&action=delete_folder&path='.$_SESSION['path'].'&file='.$filename.'">Delete Folder</a>
                                </td>
                                </tr>';
                            $array_c[0] = '';
                            $array_c[$want] = $filename;
                            $want++;
                        };
                    };
                };
                $number_count = count($array_c); 
                $cont = 0;
                $want = 0;
                while($number_count > 0){
                    $darname = $settings['file_path'].$_SESSION['username']."/".$array_c[$want]."";
                    $doname = $settings['file_path'].$_SESSION['username']."/".$array_c[$want]."/";
                    $darhandle = opendir($darname);
                    while(FALSE !=($filename = readdir($darhandle))){
                        if(($filename != ".") and($filename != "..")){
                            if(is_file($doname.$filename)){
                                $cant[$cont] = filesize($doname.$filename);
                                $dir_m = $dir_m+$cant[$cont];
                                $cont++;
                            };
                        };
                    };
                    $want++;
                    $number_count--;
                };
                $dirhandle2 = opendir($dirname);
                $count = 0;
                while(FALSE !=($filename = readdir($dirhandle2))){
                    if(($filename != ".") and($filename != "..")){
                        if(is_file($dirname.$filename)){
                            $cunt[$count] = filesize($dirname.$filename);
                            echo '<tr>
                                <td><img src="' . $_SESSION[theme] . '/images/i-regular.gif"> '.$filename.'</td>
                                <td><center>'.size_file($cunt[$count]).'</center></td>
                                <td><center>'.substr(sprintf('%o', fileperms($dirname.'/'.$filename)), -3).'</center></td>
                                <td>  
                                <a href="' . $_SESSION['path'] . $filename . '" target="_blank">View</a> |';
                            $sometxt = strstr($filename, '.');
                            if($sometxt == '.zip') {
                                print '<a href="?act=manager&action=unzip_a&path='.$_SESSION['path'].'&file='.$filename.'">Unzip</a> |';
                            };
                            print ' <a href="?act=manager&action=edit_file&path='.$_SESSION['path'].'&file='.$filename.'">Edit</a> | 
                                <a href="?act=manager&action=move_file&path='.$_SESSION['path'].'&file='.$filename.'">Move</a> | 
                                <a href="?act=manager&action=copy_file&path='.$_SESSION['path'].'&file='.$filename.'">Copy</a> | 
                                <a href="?act=manager&action=rename_file&path='.$_SESSION['path'].'&file='.$filename.'">Rename</a> | 
                                <a href="?act=manager&action=chmod_file&path='.$_SESSION['path'].'&file='.$filename.'">CHMOD</a> | 
                                <a href="?act=manager&action=delete_file&path='.$_SESSION['path'].'&file='.$filename.'">Delete File</a>
                                </td>
                                </tr>';
                            $dir_s = $dir_s+$cunt[$count];
                            $count++;
                        };
                    };
                };
                $_SESSION[dir_s] = $dir_s;
                $_SESSION[dir_m] = $dir_m;
                $_SESSION[dir_t] = $dir_s+$dir_m;
                //change chmod move rename delete
                //Close the directory handle for security and to prevent possible glitches
                closedir($dirhandle);
                closedir($dirhandle2);
                print '</table>';
            };
            //Create New File Form
            if($action == 'create_new_file'){
                print '<form method="post" action="?act=manager&action=fix_file&path='.$path.'">
                    File Name: <input type="text" name="filename" value="'.$file_name.'"><br />
                    <textarea name="text" cols="75" rows="35">'.$file_data.'</textarea>
                    <br />
                    <input type="hidden" name="dir" value="'.$settings['file_path'].$_SESSION['path'].'/">
                    <input type="submit" value="Save File">
                    </form> ';
            };
            if($action == 'create_new_folder'){
                print '<form method="post" action="?act=manager&action=create_folder&path='.$path.'">
                    Folder Name: <input type="text" name="foldername" value="'.$folder_name.'"><br />
                    <input type="submit" value="Create Folder"> <br />
                    </form> ';
            };
            if($action == 'create_folder'){
                $file_paths = $settings['file_path'].$path;
                if(mkdir($settings['file_path'].$_SESSION['path'].$_POST[foldername], 0755)){
                    //chmod($file_paths,);
                    print ''.$_POST[foldername].' has been created.';
                }else{
                    redirect('failed.php?id=500');
                };
            };
            if($action == 'fix_file'){
                $filename = $_POST[dir].$_POST['filename'];
                $theText = $_POST['text'];
                $theText = stripslashes($theText);
                $save_file = fopen($filename, "w+");
                fwrite($save_file, $theText);
                //fclose($save_file);
                print '<strong>'.$_POST[filename].'</strong> has been edited and saved.';
            };
            if($action == 'edit_file'){
                $dir = $settings['file_path'];
                $file_data = fopen($dir.$_SESSION['path'].$file, 'r');
                $file_read = fread($file_data, filesize($dir.$_SESSION['path'].$file));
                fclose($file_data);
                print '<form method="post" action="?act=manager&action=fix_file&path='.$path.'">
                    File Name: <input type="text" name="filename" value="'.$file.'"><br />
                    <textarea name="text" cols="75" rows="35">'.$file_read.'</textarea>
                    <br />
                    <input type="hidden" name="dir" value="'.$dir.$_SESSION['path'].'">
                    <input type="submit" value="Save Edited File">
                    </form>';
            };
            if($action == 'chmod_file'){
                $dirname = $settings['file_path'].$_SESSION['path']."";
                $file_chmod = substr(sprintf("%o", fileperms($dirname.'/'.$file)), -3);
                print '<form method="post" action="?act=manager&action=chmod&path='.$_SESSION['path'].'">
                    Folder Name: <input type="text" name="filename" value="'.$file.'"><br />
                    CHMOD: <input type="text" name="file_chmod" value="'.$file_chmod.'">
                    <input type="submit" value="Save File"> <br />
                    </form> ';
            };
            if($action == 'chmod_folder'){
                $dirname = $settings['file_path'].$_SESSION['path']."";
                $file_chmod = substr(sprintf('%o', fileperms($dirname.'/'.$file)), -3);
                print '<form method="post" action="?act=manager&action=chmod&path='.$_SESSION['path'].'">
                    Folder Name: <input type="text" name="filename" value="'.$file.'"><br />
                    CHMOD Value: <input type="text" name="file_chmod" value="'.$file_chmod.'">
                    <input type="submit" value="Save Folder"><br />
                    </form> ';
            };
            if($action == 'chmod'){
                $file_paths = $settings['file_path'].$_SESSION['path'].$_POST[filename];
                chmod($file_paths, octdec($_POST[file_chmod]));
                print '<strong>'.$_POST[filename].'</strong> has been CHMOD to '.$_POST[file_chmod].'';
            };
            if($action == 'rename_file'){
                print '<form action="?act=manager&action=rename&path='.$_SESSION['path'].'" method="post">
                    Current File Name:<input type="text" value="'.$file.'" name="current_name" /><br />
                    NEW File Name: <input type="text" value="" name="new_name" /><br />
                    <input type="submit" value="Rename File" />
                    </form>';
            };
            if($action == 'rename'){
                $dir = $settings['file_path'];
                rename($dir.$_SESSION['path'].$_POST[current_name], $dir.$_SESSION['path'].$_POST[new_name]);
                print 'File/Folder: '.$_POST[current_name].' has been renamed to '.$_POST[new_name];
                redirect_time("?act=manager", "100");
            };
            if($action == 'rename_folder'){
                print '<form action="?act=manager&action=rename&path='.$_SESSION['path'].'" method="post">
                    Current File Name:<input type="text" value="'.$file.'" name="current_name" /><br />
                    NEW File Name: <input type="text" value="" name="new_name" /><br />
                    <input type="submit" value="Rename File" />
                    </form>';
            };
            if($action == 'copy_file'){
                print '<form action="?act=manager&action=copy&path='.$_SESSION['path'].'" method="post">
                    Copy File: b<input type="text" value="'.$_SESSION['path'].$file.'" name="current_name" /><br />
                    New Copied File: <input type="text" value="'.$_SESSION['path'].'COPY_'.$file.'" name="new_name" /><br />
                    <input type="submit" value="Rename File" />
                    </form>';
            };
            if($action == 'copy'){
                $dir = $settings['file_path'];
                copy($dir.$_POST[current_name], $dir.$_POST[new_name]);
                print 'File: '.$_POST[current_name].'has been copied to,'.$_POST[current_name];
            };
            if($action == 'view_folder'){
                if($cpath == '/' || $cpath == ''){
                    if($group_id != 1){
                        $cpath = $_SESSION['username']."/";
                    };
                };
                $_SESSION['path'] = $cpath;
                redirect("?act=manager");
            };
            if($action == 'delete_file'){
                print '<form action="?act=manager&action=delete&set=file&path='.$_SESSION['path'].'" method="post">
                    Are you sure you want to delete <strong>'.$file.'</strong>?<input type="hidden" value="'.$file.'" name="name" /><br /><br />
                    <input type="submit" value="Yes" /><input type="asdf" value="No" />
                    </form>';
            };
            if($action == 'delete_folder'){
                print '<form action="?act=manager&action=delete&set=folder&path='.$_SESSION['path'].'" method="post">
                    Are you sure you want to delete <strong>'.$file.'</strong>?<input type="hidden" value="'.$file.'" name="name" /><br /><br />
                    <input type="submit" value="Yes" /><input type="asdf" value="No" />
                    </form>';
            };
            if($action == 'delete'){
                if($set == 'file'){
                    $dir = $settings['file_path'];
                    unlink($dir.$_SESSION['path'].$_POST['name']);
                    print '<strong>'.$_POST['name'].'</strong> has been deleted.';
                };
                if($set == 'folder'){
                    $dir = $settings['file_path'];
                    rmdir($dir.$_SESSION['path'].$_POST['name']);
                    print '<strong>'.$_POST['name'].'</strong> has been deleted.';
                };};
                if($action == 'unzip_a'){
                    print '<form method="POST" action="?act=manager&action=unzip">Zip File path:<input type="text" name="file" value="'.$settings['file_path'].$_SESSION['path'].$file.'" /><br />
                        Unzip Here:<input type="text" name="to_dir" value="'.$settings['file_path'].$_SESSION['path'].'" /><br />
                        <input type="submit" name="Unzip File" value="Unzip File" />
                        </form>';
                };
                if($action == 'unzip'){
                    function unzip($zipfile)
                    {
                        $zip = zip_open($zipfile);
                        while($zip_entry = zip_read($zip))    {
                            zip_entry_open($zip, $zip_entry);
                            if(substr(zip_entry_name($zip_entry), -1) == '/') {
                                $zdir = substr(zip_entry_name($zip_entry), 0, -1);
                                if(file_exists($zdir)) {
                                    trigger_error('Directory "<strong>' . $zdir . '</strong>" exists', E_USER_ERROR);
                                    return false;
                                };
                                mkdir($zdir);
                            }
                            else {
                                $name = zip_entry_name($zip_entry);
                                if(file_exists($name)) {
                                    trigger_error('File "<strong>' . $name . '</strong>" exists', E_USER_ERROR);
                                    return false;
                                };
                                $fopen = fopen($name, "w");
                                fwrite($fopen, zip_entry_read($zip_entry, zip_entry_filesize($zip_entry)), zip_entry_filesize($zip_entry));
                            };
                            zip_entry_close($zip_entry);
                        };
                        zip_close($zip);
                        return true;
                    };
                    exec("unzip $_POST[file] -d $_POST[to_dir]", $outputlines);
                    echo 'Script returned the following: ';
                    foreach($outputlines as $outputline) echo $outputline.'\n';
                    $test = exec("unzip $_POST[file]");
                    if($test == true){
                        echo 'Successfully unzipped:'.$_POST[file];
                    }else{
                        echo 'Failed:'.$_POST[file];
                    };
                    $zip = new ZipArchive();
                    if($zip->open($_POST[file]) === TRUE) {
                        $zip->extractTo($_POST[to_dir]);
                        $zip->close();
                    } else {};
                };
                if($action == 'upload_file'){
                    title("Upload File");
                    print '<h1><center>Upload File</center></h1>
                        <hr width="100%" align="center"/>
                        <form action="?act=manager&action=upload&path='.$_SESSION['path'].'" method="post" enctype="multipart/form-data">
                        <table class="table" align="center">
                        <tr><td>
                        File Name: <input name="file" type="file" size="50" /><br />
                        <input type="submit" value="Upload File" />
                        </td></tr>
                        </table>
                        </form>';
                };
                if($action == 'upload'){
                    if($_FILES['file']['name'] != ""){
                        $path_parts = pathinfo($_FILES['file']['name']);
                        $set_to = '1';
                        if($path_parts['extension'] == 'rar'){
                            $set_to = '1';
                        }; 
                        if($set_to != '0'){
                            if($_SESSION[limit_space] > $_SESSION[dir_t] || $_SESSION[limit_space] == 'unmetered'){
                                if($_FILES['file']['size'] > $settings['img_size']){
                                    $local_file = $_FILES['file']['tmp_name']; //Defines Name of Local File to be Uploaded
                                    $destination_file = 'files/'.$_SESSION['path'].'/'.basename($_FILES['file']['name']);//Path for File Upload(relative to your login dir)
                                    //Connect to FTP Server
                                    $conn_id = ftp_connect($ftp_server);
                                    //Login to FTP Server
                                    $login_result = ftp_login($conn_id, $ftp_username, $ftp_password);
                                    //Verify Log In Status
                                    if((!$conn_id) ||(!$login_result)) {
                                        echo "FTP connection has failed.<br />";
                                        exit;
                                    };
                                    $upload = ftp_put($conn_id, $destination_file, $local_file, FTP_BINARY);  //Upload the File
                                    //Verify Upload Status
                                    if(!$upload) {
                                        print ''.$_SESSION['path'].'FTP upload of <strong>'.$_FILES['file']['name'].'</strong> has failed!<br /><br />';
                                    } else {
                                        print '<strong>'.$_FILES['file']['name'].'</strong> has been successfully uploaded to <strong>'.$_SESSION['path'].'</strong>.';
                                    }
                                    ftp_close($conn_id); //Close the FTP Connection
                                }else{print 'The file uploaded is greater then the file size limit.';};
                            }else{print 'Not enough space left.';};
                        }else{print 'Invalid File Extension.';};
                    }else{print 'The file name is not valid.';};
                };
        };
    };
};
?>
