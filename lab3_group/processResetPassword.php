
<?php
session_start();
require 'callNewsDataBase.php';







if(isset($_POST['q1ans']) && isset($_POST['q2ans'])){

    
$username = $_POST['username'];


$q1ans = $_POST['q1ans'];
$q2ans = $_POST['q2ans'];


//$passwordHash = crypt($password);





$stmt = $mysqli->prepare("SELECT q1ans, q2ans FROM users WHERE username=?");



    if(!$stmt){
		printf("prepare get reset answer query failed;");
		exit;
	}
    
    
    $stmt->bind_param('s',  $username);
 
 
    $stmt->execute();
    $stmt->bind_result( $q1ansreal, $q2ansreal);
while($stmt->fetch()){
    if ($q1ans==$q1ansreal && $q2ans==$q2ansreal){
        
          //good now you can reset password
         echo '<form action="uploadResetPassword.php" method="POST">';
                echo '<input type="text" name="newpassword" />';
                echo'			 <input type="hidden"  name="username" value = "'.$username.'"/>';
            
                echo '<input type="submit" value="submit"/>';
				
                echo '</form>';
      
        
        
    }
    else {echo " security questions wrong , redirecting you back to login page";
     echo "<script>setTimeout(\"location.href = 'mainLogin.php';\",1500);</script>";}
}

  
  
  
  
  
  
  
  
    $stmt->close();
	
}


else {
    echo " not fully filled, go back to refill all the blanks ,";
    
	 echo "<script>setTimeout(\"location.href = 'forgetpassword.php';\",1500);</script>";
}


?>