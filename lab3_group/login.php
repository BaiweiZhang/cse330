<?php
session_start();


require 'callNewsDataBase.php';
if( !preg_match('/^[\w_\.\-]+$/', $_POST['username']) ){
	echo "Invalid usesrname entered";
	exit;
}
$stmt = $mysqli->prepare("SELECT username, hashpass FROM users WHERE username=?");

$username=$_POST['username'];


$stmt->bind_param('s', $username);



$stmt->execute();
 
$stmt->bind_result( $userdata, $realpasswordhash);
$stmt->fetch();




$passwordentered=$_POST['password'];







$pwdhash = crypt($passwordentered);

if(crypt($passwordentered,$realpasswordhash)==$realpasswordhash)

{
	session_start();


	$_SESSION['username'] = $username;
	
  echo ("haha logged in !!!!");
	
    header("Location: home.php");
	
}

else{
	
	
	
	echo "login failure, redirecting you back to the login page .";
		
	 echo "<script>setTimeout(\"location.href = 'mainLogin.php';\",1500);</script>";
     exit;


}



?>



