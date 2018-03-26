<!-- Author Terry Lyu, AB Brooks-->
<!-- Student ID 435091, 441827-->
<?php

	session_start();
	$username= $_GET['username'];
	$_SESSION['username'] = $username;
	
	$handle = fopen("/media/module2/users.txt" , "r");
   
   
	while ( !feof($handle)) {
	
		$usernamearray[] = trim(fgets($handle));
		
	}
    
    
	fclose($handle);
    
	if(in_array($_SESSION['username'], $usernamearray, true)){
	
		echo ("login successful, "+ $username);
		
	
		 echo "<script>setTimeout(\"location.href = 'user.php';\",5);</script>";
      
    	header("Location: user.php");
		exit;
	}
	else echo "wrong user, redirecting you to the main login page in five seconds. ";
	 echo "<script>setTimeout(\"location.href = 'main.php';\",1500);</script>";
    
	session_destroy();
	
?>
