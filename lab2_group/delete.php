<!-- Author Terry Lyu, AB Brooks-->
<!-- Student ID 435091, 441827-->

<?php
session_start();
$username = $_SESSION['username'];
$filename = $_POST['filename'];
$file = sprintf("/media/module2/%s/%s", $username, $filename);


if(unlink($file)){
	//header( "refresh:5; url=login.php" ); //wait for 5 seconds before redirecting
	//header(' refresh:5; Location=user.php');
	echo ('delete successful ');
	echo "<script>setTimeout(\"location.href = 'user.php';\",1500);</script>";
	
}
else{header("Location: user.php");
	echo "error while deleting ".$filename;
	echo "<script>setTimeout(\"location.href = 'user.php';\",1500);</script>";
}
?>

