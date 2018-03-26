<?php


          if (isset($_GET['guestsubmit'])) {
session_start();
	$_SESSION['username'] = "guest";
echo "haha you are a guest";
    header("Location: home.php");
          }
?>