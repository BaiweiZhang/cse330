<?php
session_start();


require 'callNewsDataBase.php';


function checkexisted ($username){
    require 'callNewsDataBase.php';
	$stmt = $mysqli->prepare("select * from users where username=? ");
		if(!$stmt){
            	        echo("prepare check username failed");
            	}
			$stmt->bind_param("s", $username);	
	$stmt->execute();
	$stmt->store_result();
	if($stmt->num_rows == 0) {
		
		echo "username not existed in our database , redirecting you to the main login page in five seconds. ";
	 echo "<script>setTimeout(\"location.href = 'mainLogin.php';\",1500);</script>";
     exit;
     
	}
	
}


if(isset($_POST['username'])){
  $username=  $_POST['username'];
    checkexisted($username);
    
  $stmt = $mysqli->prepare("SELECT q1 ,q2 FROM users WHERE username= ?");

     $username=$_POST['username'];


     $stmt->bind_param('s', $username);



     $stmt->execute();
 
      $stmt->bind_result( $q1, $q2);
$stmt->fetch();
    
    echo("these are  your security questions, please answer the questions  , q1 is " );
    echo "<br>";
    
    echo $q1;
    
    echo ("q2 is ");
    echo "<br>";
    
    
    echo $q2;
    
    				
echo'<form class="text-center" action="processResetPassword.php" method="POST">';
			
	echo '				password reset questions q1ans<input type="text" style="width:inherit;" name="q1ans"/>';
		echo'			q2ans <input type="text" style="width:inherit;" name="q2ans"/>';
        		echo'			 <input type="hidden"  name="username" value = "'.$username.'"/>';
            echo'        <button type="submit" class="btn btn-info">check the answers</button>	</form>';
			

    
    
    
    

}
else echo "fill in the username that you want to reset ";




?>



