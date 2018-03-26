
<?php
session_start();
$filename = $_POST['filename'];



$username = $_SESSION['username'];





$full_path = sprintf("/media/module2/%s/%s", $username, $filename);
$finfo = new finfo(FILEINFO_MIME_TYPE);
$mime = $finfo->file($full_path);
header("Content-Type: ".$mime);
header("Content-Disposition: attachment; filename=\"$filename\"");
ob_clean();
readfile($full_path);

	
	
?>