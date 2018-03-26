<!DOCTYPE html>
<html>

    <body>
  
        <?php
			require 'callNewsDataBase.php';

			session_start();
								
		if($_SESSION['token'] !== $_POST['token']){
	die("Request forgery detected");
}

//delete comment first from the database 
        $stmt1 = $mysqli->prepare("delete from comment where newsid=?");

			if(!$stmt1) {
				echo "error in preparing delete comment";
			}

			$stmt1->bind_param('i', $_POST['id']);
			$stmt1->execute();
            $stmt1->close();
            
        //then delete the actual story     
            
            
        $stmt2 = $mysqli->prepare("delete from news4 where newsid=?");
		
			if(!$stmt2) {
				echo "error in preparing delete story ";
			}

			$stmt2->bind_param('i', $_POST['id']);
			$stmt2->execute();
            $stmt2->close();
            
    echo ("delete story and comment successful ");
	

	 echo "<script>setTimeout(\"location.href = 'home.php';\",1500);</script>";
     exit;
        ?>
        

 
    </body>
</html>