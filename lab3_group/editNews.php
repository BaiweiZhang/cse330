<!DOCTYPE html>
<html>

    <body>
  
        <?php
			require 'callNewsDataBase.php';

			session_start();
					
		if($_SESSION['token'] !== $_POST['token']){
	die("Request forgery detected");
}


			$stmt = $mysqli->prepare("SELECT * FROM news4 WHERE newsid=? ");
			if(!$stmt) {
				echo "error in preparing statement";
			}

			$stmt->bind_param('i', $_POST['id']);
			$stmt->execute();
			$stmt->bind_result($id, $title, $author, $content, $link);
			$stmt->fetch();
        
        

   echo ("Edit your story here: ");
    echo'    <form action="updateNews.php" method="POST">';
            echo'Title: <input type="text" name="title" value="'. $title.'">	</label><br>';
         echo'   <label>Link: <input type="text" name="link" value="'.$link.'"></label><br>';
         echo'   <label>Story: <input type="text" name="content" maxlength="50" style="width:200px; height: 100px;" value="'. $content.'">	</label>';
            
      echo'      <input type="hidden" name="id" value="'. $id.' " />';
     echo'       <input type="submit" value="Submit"/>     </form>';
    

		 $stmt->close() ;
         ?>
    </body>
</html>