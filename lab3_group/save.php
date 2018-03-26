
        <?php
        require 'callNewsDataBase.php';
          session_start();
          $username = $_SESSION['username'];
          
          
          if (isset($_GET['id'])) {
          $newsid=$_GET['id'];
         
          

       $stmt = $mysqli->prepare("SELECT * FROM news4 where newsid=?");
        if(!$stmt){
	
                printf("select news prep failed");
                exit;
            }
            
            
            
            $stmt->bind_param("i", $newsid);
          $stmt->execute();

         $stmt->bind_result($newsid, $title, $author, $content, $link);
            $stmt->store_result();
            
            $stmt->fetch();
                
                header('Content-disposition: attachment; filename=UserData.txt');
header('Content-type: text/plain');



echo "title is  " . $title . "\r\n";
echo "===================\r\n";
echo "content is  " . $content . "$\r\n";
echo "link is" . $link . "$\r\n";


                
                
                
            }
            
        
       
          
                
    ?>
                   