
      <?php
        require 'callNewsDataBase.php';
          session_start();
          		if($_SESSION['token'] !== $_POST['token']){
	die("Request forgery detected");
}

          $username = $_SESSION['username'];
          
          
          if (isset($_POST['submit'],$_POST['content'],$_POST['title'])) {
          
 




$title = $_POST['title'];
                 $content = $_POST['content'];
                 $link = $_POST['link'];
             
                        if( !preg_match('/^[\w_\.\-]+$/', $_POST['content'],$_POST['title']) ){
	echo "Invalid filename detected";
	exit;
}


	    
                                 
                 $stmt = $mysqli->prepare("insert into news4 (title, author, content, link) values(? ,? ,? ,? )");
                if (!$stmt) {
                    echo("upload prep query failed");
                }
                    
            
                 $stmt->bind_param('ssss', $title, $username, $content, $link);
                 $stmt->execute();
                 $stmt->close();
                    
                
                header("Location: home.php");
            }
            else {
                echo "nothing to upload";
            
        }
        
       
        
        
       
                
                
    ?>
                   