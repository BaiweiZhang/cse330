<!-- Author Terry Lyu, AB Brooks-->
<!-- Student ID 435091, 441827-->


<?php

	session_start();
	$username= $_GET['username'];
	$_SESSION['username'] = $username;
// making new users, if name already taken, choose a new one. 
   
   $file=sprintf("/media/module2/users.txt");
   $handle = fopen($file,"r");
	while ( !feof($handle)) {
	
		$usernamearray[] = trim(fgets($handle));
	}
    fclose($handle);
    

    
  if(in_array($_SESSION['username'], $usernamearray, true)){
		 echo ("user name already taken, choose a different one, redirecting you to the main login page in five seconds");
		
      	 echo "<script>setTimeout(\"location.href = 'main.php';\",1500);</script>";
    	
		exit;
	}
  else {
     $full_path = sprintf("/media/module2/%s", $username);
	 if (!mkdir($full_path)){
		echo ("error making directory for new user");
		}
	 else {
		  $temp = fopen($file, "a");
                    if((fwrite($temp, $username))!==false){
                        fwrite($temp,"\r\n");
						echo("successfully added you to our site, I will redirect you to your user page in five seconds. ");
                  	 echo "<script>setTimeout(\"location.href = 'user.php';\",1500);</script>";
                        exit;
                    }
                    else{
                       echo("error writing user name to user.txt");
                    }
                    fclose($temp);
                }

  }

	session_destroy();
	
?>