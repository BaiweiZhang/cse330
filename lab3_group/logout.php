<?php

session_start();
session_destroy();
		
		echo "logging you out , redirecting you to the main login page in five seconds. ";
	 echo "<script>setTimeout(\"location.href = 'mainLogin.php';\",1500);</script>";
     exit;


?>