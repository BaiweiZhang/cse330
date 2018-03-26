<!DOCTYPE html>
<html>

    <body>
  
        <?php
		
		



			require 'callNewsDataBase.php';

			session_start();
					

             

			$stmt = $mysqli->prepare("SELECT * FROM comment WHERE commentid=? LIMIT 1");
			if(!$stmt) {
				echo "error in preparing statement";
			}

			$stmt->bind_param('i', $_POST['commentid']);
			$stmt->execute();
			$stmt->bind_result($commentid, $commentcontent, $commentauthor, $newsid);
			$stmt->fetch();
        
        


       echo' <form action="updateComment.php" method="POST">';
          echo'  <label>change your comment here <input type="text" name="commentcontent" value="'.$commentcontent.'">	</label><br>';
		

            
          echo'  <input type="hidden" name="commentid" value="'. $commentid .'" />';
           echo' <input type="submit" value="Submit"/> </form>';

		 $stmt->close();
        ?>
    </body>
</html>