 <!-- Author Terry Lyu, AB Brooks-->
<!-- Student ID 435091, 441827-->
  <?php

 session_start();
 $username = $_SESSION['username'];
 $target_dir = sprintf("/media/module2/".$username."/");
 					  
 $target_file = $target_dir . basename($_FILES["uploadedfile"]["name"]);
 
 if ($target_dir==$target_file){
	echo ("please select a file before you upload");
		echo "<script>setTimeout(\"location.href = 'user.php';\",1500);</script>";
	exit();
	
 }
if(isset($_POST["submit"])) {
    $check = filesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        echo "file is good" ;
        $uploadOk = 1;
    } else {
        echo "cannot upload empty file.";
		echo "<script>setTimeout(\"location.href = 'user.php';\",1500);</script>";
		
        $uploadOk = 0;
		exit();
		
    }
}
 

 if (file_exists($target_file)) {
     echo " file already exists.";
	 echo "<script>setTimeout(\"location.href = 'user.php';\",1500);</script>";
	 $uploadOk = 0;
	 exit();
	 
    
 }
 // Check file size
 if ($_FILES["uploadedfile"]["size"] > 50000) {
     echo " file is too large.";
	 echo "<script>setTimeout(\"location.href = 'user.php';\",1500);</script>";
	  $uploadOk = 0;
	  exit();
	  
   
 }
else

  {

 	
     if (move_uploaded_file($_FILES["uploadedfile"]["tmp_name"], $target_file)) {
         echo "The file ". basename( $_FILES["uploadedfile"]["name"]). " has been uploaded.";
		 echo "<script>setTimeout(\"location.href = 'user.php';\",1500);</script>";
		 //header("Location: user.php");
       exit();
     } else {
		
         echo "Unresolvable error";
		 echo "<script>setTimeout(\"location.href = 'user.php';\",1500);</script>";
		 exit();
		 
     }
     
 }
 ?>
 ?>