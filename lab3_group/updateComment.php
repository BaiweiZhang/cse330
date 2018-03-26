<?php

require 'callNewsDataBase.php';

session_start();

   if( !preg_match('/^[\w_\.\-]+$/', $_POST['commentcontent'] ){
	echo "Invalid filename detected";
	exit;
}
$username=$_SESSION['username'];

$commentcontent=$_POST['commentcontent'];

$commentid=$_POST['commentid'];





$stmt = $mysqli->prepare("UPDATE comment SET commentcontent=?   WHERE commentid=?");
if(!$stmt){
     printf("update comment failed ");
   exit;
}
$stmt->bind_param('si', $commentcontent, $commentid);
     

$stmt->execute();
$stmt->close();


header("Location: home.php");
?>