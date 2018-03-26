

<?php
session_start();
$username = $_SESSION['username'];
$filename = $_POST['filename'];
$full_path = sprintf("/media/module2/%s/%s", $username, $filename);
$new_path = sprintf("/media/module2/share/%s", $filename);
if (file_exists($new_path)) {
     echo " file already exists.";
	 echo "<script>setTimeout(\"location.href = 'user.php';\",1500);</script>";
	 
	 exit();
	 
    
 }
if (!copy($full_path, $new_path)) {
    echo "failed to copy $filename...\n";
}

else echo "copy successful to the share folder ";
 echo "<script>setTimeout(\"location.href = 'user.php';\",1500);</script>";

?>
