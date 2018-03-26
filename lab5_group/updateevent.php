 <?php
 
 require 'database.php';
header("Content-Type: application/json");


session_start();

$username=$_SESSION['username'];
 
 

 $title = $_POST['title'];
$eventdetail= $_POST['detail'];
$mergedate = $_POST['mergedate'];

$mergeenddate = $_POST['mergeenddate'];
 $id = $_POST['id'];
 
 
    
    //echo ($start.$end .$id.$detail.$title);
//$token = $_POST['token'];
//	if($_SESSION['token'] !== $_POST['token']){
//	die("Request forgery detected");
//	}
	
$stmt = $mysqli->prepare("UPDATE event SET title=?, eventdetail=?, start=?, end=? WHERE eventid=?");
if(!$stmt){
     printf("update story  prep failed： %s\n", $mysqli->error);
   exit;
}
$stmt->bind_param('ssssi', $title, $eventdetail, $mergedate, $mergeenddate, $id);
     

$stmt->execute();
$stmt->close();
 echo json_encode(array(
		"success" => true
	));
	exit;
	
?>