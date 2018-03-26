
    
<?php

$A=$_GET['num1'];
$B=$_GET['num2'];
$ans=0;

if ($_GET['radio'] == 'plus'){
    $ans = $A+$B;
    echo ("your answer is "+$ans);
    
    
}



if ($_GET['radio'] == 'minus'){
    $ans = $A-$B;
    echo ("your answer is "+$ans);
    
    
}

if ($_GET['radio'] == 'mult'){
    $ans = $A*$B;
    echo ("your answer is "+$ans);
    
    
}

if ($_GET['radio'] == 'div'){
     if($B == 0){
            echo "cannot divide by 0";
            }
            else{
               $ans = $A/$B;
                 echo ("your answer is "+$ans);
            }

  
    
    
}
?>

</body>

</html>