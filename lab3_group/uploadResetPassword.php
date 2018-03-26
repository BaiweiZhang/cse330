<?php

          $username = $_POST['username'];

require 'callNewsDataBase.php';

 





if(isset($_POST['newpassword']) ){
    $newpassword = $_POST['newpassword'];
               $newpasshash = crypt($newpassword);
               
    
    
    $stmt = $mysqli->prepare("UPDATE users SET hashpass = ? WHERE username=?");
       $stmt->bind_param('ss', $newpasshash, $username );
                 $stmt->execute();
                 $stmt->close();
                 
                 
                 
                 
                 echo "password reset complete ";
                    
                 
    
    
    
    
}

else echo "nothing entered as new password ";
?>