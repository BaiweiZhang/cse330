<?php
        require 'callNewsDataBase.php';

session_start();


$username=$_SESSION['username'];
$newsid=$_POST['id'];
$comment=$_POST['comment'];






$stmt = $mysqli->prepare("INSERT INTO comment (commentcontent, commentauthor, newsid) values (?, ?, ?)");
if(!$stmt){
    echo "Unable to upload comment";
}

$stmt->bind_param('ssi', $comment, $username, $newsid);
     

$stmt->execute();
$stmt->close();


header("Location: home.php");
?>