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
        $stmt1 = $mysqli->prepare("delete from comment where commentid=?");

			if(!$stmt1) {
				echo "error in preparing delete comment";
			}

			$stmt1->bind_param('i',$_POST['commentid']);
			$stmt1->execute();
            $stmt1->close();
            
       
    echo ("delete comment success ")
        ?>
        

 
    </body>
</html>