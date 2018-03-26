
<?php
session_start();
require 'callNewsDataBase.php';
function checkexisting ($username){
    require 'callNewsDataBase.php';
	$stmt = $mysqli->prepare("select * from users where username=? ");
		if(!$stmt){
            	        echo("prepare check username failed");
            	}
			$stmt->bind_param("s", $username);	
	$stmt->execute();
	$stmt->store_result();
	if($stmt->num_rows > 0) {
		
		echo "username already existed , redirecting you to the main login page in five seconds. ";
	 echo "<script>setTimeout(\"location.href = 'register.php';\",1500);</script>";
     exit;
     
	}
	
}

if(isset($_POST['username']) && isset($_POST['password'])){
	
	checkexisting($_POST['username']);
    
$username = $_POST['username'];
$password = $_POST['password'];
$q1 = $_POST['q1'];
$q2 = $_POST['q2'];
$q1ans = $_POST['q1ans'];
$q2ans = $_POST['q2ans'];


$passwordHash = crypt($password);



 



$stmt = $mysqli->prepare("insert into users (username, hashpass, q1, q2, q1ans, q2ans) values (?, ?, ?, ?, ?, ?)");
    if(!$stmt){
		printf("prepare register query failed;");
		exit;
	}
    $stmt->bind_param('ssssss', $username, $passwordHash,$q1,$q2, $q1ans, $q2ans);
 
 
    $stmt->execute();
  
  
    $stmt->close();
	echo htmlentities("Register complete!, directing you to home page in 5 seconds");
     echo "<script>setTimeout(\"location.href = 'mainLogin.php';\",1500);</script>";
}

else {
    echo " not fully filled, go back to refill all the blanks ,";
    
	 echo "<script>setTimeout(\"location.href = 'register.php';\",1500);</script>";
}


?>