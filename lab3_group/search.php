<?php
		     
          if (isset($_POST['search'])) {
          $search=$_POST['search'];
         
       require 'callNewsDataBase.php';

       $stmt = $mysqli->prepare("SELECT * FROM news4 where title=? || author=? || content=?");
        if(!$stmt){
	
                printf("Query Prep Failed: %s\n", $mysqli->error);
                exit;
            }
            
              $stmt->bind_param("sss", $search,  $search, $search);
          $stmt->execute();

         $stmt->bind_result($id, $title, $author, $content, $link);
            $stmt->store_result();
            if($stmt->num_rows == 0) {
		
		echo "no matches found,  redirecting you to the main login page in five seconds. ";
	 echo "<script>setTimeout(\"location.href = 'home.php';\",1500);</script>";
     exit;
     
	}
	
	while ($stmt->fetch()){
	
		
	
		
	
		        printf("the title of this story is %s", htmlspecialchars($title));
				printf(" <br>author is  :  %s ", htmlspecialchars($author));
				printf("<br>link is : <a href=\"%s\">%s</a><br>",
					htmlspecialchars($link), htmlspecialchars($link));
				printf("<br>  the content of this news is  %s",     htmlspecialchars($content));
				echo "<br>";
    }
          }
?>