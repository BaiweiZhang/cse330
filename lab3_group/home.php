<!DOCTYPE html>
<html>
    <head>
        <title>News</title>
		<meta charset="utf-8"/>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<script src="jquery-1.12.2.min.js"></script>
		
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">

		<!-- jQuery library -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>

		<!-- Latest compiled JavaScript -->
		<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
		
		<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
		<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
		<link rel="stylesheet" type="text/css" href="Login.css">
    </head>
    
    <body>
		
		<div id="div0" class="container-fluid">
			<div class="row">
				<div class="col-lg-12">
					
					<ul>
						<li><a href="mainLogin.php">Home</a></li>
						<li><a class="active" href="home.php">News</a></li>
						<li><a href="mailto:bradleybrooks@wustl.edu?Subject=News%20Contribution%20Submission" target="_top">Contact</a></li>
						<li><a href="#about">About</a></li>
					
					<?php
					session_start();
					$_SESSION['token'] = substr(md5(rand()), 0, 10);
					$username = $_SESSION['username'];
						
					if($username != "guest"){
						echo '<li><form id="loginwidget2" class="text-right" action="search.php"  method="POST">';
						echo '<input type="text" name="search" />';
						echo' <input type="hidden" class="btn" name="token" value="'.$_SESSION['token'].'" />';
						echo '<button type="submit" class="btn" value="search">Search</button>';
						echo '</form>';
						echo '<form id="loginwidget3" class="text-right" action="logout.php" method="GET">';
						echo '<label class="hf">Sick of this website? </label>';
						echo '<button type="submit" class="btn" value="logout">Logout</button>';
						echo '</form></li>';
					}
					if($username == "guest"){
							echo"<li><form id='loginwidget' class='text-right' action='login.php' method='POST'>
								<label for='username' class='hf'>Username:</label>
								<input type='text' style='width:inherit;' name='username'/>
								<label for='password' class='hf'>Password:</label>
								<input type='text' style='width:inherit;' name='password'/>
								<span class='glyphicons glyphicons-circle-arrow-right'></span>
								<button type='submit' class='btn'>Login</button>
								</form></li>";
					}
					?>
					
					
					
					</ul>
				</div>
			</div>
		</div>
		<div id="div10" class="container-fluid">
			<div class="row">
				<div class="col-lg-12" style="background:#B22500;">

		<?php
			

//A FUNCTION DEALING WITH ALL COMMENT STUFF

			function  comment($id){
		
			require 'callNewsDataBase.php';
				$stmt = $mysqli->prepare("select * from comment where newsid=? ");
            	if(!$stmt){
            	        printf("Query prep Failed: %s\n", $mysqli->error);
            	}
				$stmt->bind_param("i", $id);
            	$stmt->execute();
            	$stmt->bind_result($commentid, $commentcontent, $commentauthor, $newsid);

            	
            while($stmt ->fetch()){
            	   
				echo "<h4>".($commentauthor." &nbsp;commented:&nbsp;".$commentcontent )."</h4>";
				echo "<br/><br/>";
                if(isset($_SESSION['username']) && $_SESSION['username']==$commentauthor){
					echo '<form action="editcomment.php" method="POST">';
					echo '<input type="hidden" name="commentid" value="'.$commentid.'"/>';
					echo '<button class="btn" type="submit" value="editcomment">Edit Comment</button><br><br>';
					echo '</form>';
					echo '<form action="deletecomment.php" method="POST">';
					echo '<input type="hidden" name="commentid" value="'.$commentid.'"/>';
					echo' <input type="hidden" name="token" value="'.$_SESSION['token'].'" />';
					echo '<button class="btn" type="submit" value="deletecomment">Delete Comment</button><br><br>';
					echo '</form>';
                	}
            	}
            	$stmt->close();
			}
			
      
				
       require 'callNewsDataBase.php';

       $stmt = $mysqli->prepare("SELECT * FROM news4");
        if(!$stmt){
	
                printf("Query Prep Failed: %s\n", $mysqli->error);
                exit;
            }
          $stmt->execute();

         $stmt->bind_result($id, $title, $author, $content, $link);
            $stmt->store_result();
			
			echo "<div id='divnews' class='container-fluid'>
					<div class='row' id='flexTime'>
						<div class='col-lg-1'></div>
						<div class='col-lg-6' id='divStories'>";
								
		while ($stmt->fetch()){
			$specialtitle=htmlspecialchars($title);
			$specialauthor = htmlspecialchars($author);
			$specialcontent = htmlspecialchars($content);
	
				
									echo "<h1 class='storyTitle'> $specialtitle  </h1><br>";
									echo "<h1 class='author'> $specialauthor </h1><br>";
									
									echo' <a  class="bodylink" href="https://'.$link.'">Link: "'.$link.'" </a>';
									echo"<br><h4>Story content: $specialcontent </h4><br>";
									
									
									
									echo'<a class="twitter-share-button" href="https://twitter.com/intent/tweet?text=Hey,%20I%20found%20a%20cool%20story:%20'.$title.'">Tweet this story!</a><br><br>';
							
									if ($author == $username){
								
									echo '<form class="text-left" action="editNews.php" method="POST">';
									echo '<input type="hidden" name="id" value="'.$id.'"/>';
									echo' <input type="hidden" name="token" value="'.$_SESSION['token'].'" />';
									echo '<button class="btn" type="submit" value="Edit">Edit</button><br><br>';
									
									echo '</form>';
									
									echo '<form class="text-left" action="deleteNews.php" method="POST">';
									echo '<input type="hidden" name="id" value="'.$id.'"/>';
									echo '<input type="hidden" name="token" value="'.$_SESSION['token'].'" />';
									echo '<button class="btn" type="submit" value="delete">Delete</button><br><br>';
									
									echo '</form>';
									}
									else {
									echo '<form class="text-left" action="save.php" method="GET">';
									echo '<input type="hidden" name="id" value="'.$id.'"/>';
									 
									echo '<button class="btn" type="submit" value="save">Save</button><br><br>';
									
									echo '</form><br><br>';
									}
									
									
		
							
				
									//print comment
									
									comment($id);
									
									//submit comment
									
									if($username != "guest"){
										echo '<form action="uploadComments.php" method="POST">';
										echo '<input type="text" name="comment" />';
										echo '<input type="hidden" name="id" value="'.$id.'"/>';
             
										echo '<button class="btn" type="submit" value="Comment">Comment</button><br><br>';
										echo '</form>';
	
										for($i=0; $i<5; $i=$i+1){
											echo "<br>";
										}
									}
		}
								echo '</div>';
								echo "<div class='col-lg-4' id='newStory'>";
								
			
		
				$stmt->close();
		  
				  if($username != "guest"){
						echo "<h1 class='text-center'>Submit a News Story!</h1>";
		  
					  echo'<form class="text-center" action="uploadNews.php" method = "POST">';
					  
					  
					  echo'<h4>Story Title: </h4><input type = "text" name = "title">  <br>';
						  
						  
						  
					  echo'	<h4>Add Content: </h4><textarea rows = "5" cols ="20" name = "content"></textarea>';
			  
			  
					  echo'<h4>External Link: </h4><input type = "text" name = "link"><br>';
					  echo'  <input type="hidden" name="token" value="'.$_SESSION['token'].'" />';
					  echo' <button class="btn" type ="submit" name = "submit" value = "Submit">Submit</button></form>';
				  }
				  echo'</div>';
				  echo "<div class='col-lg-1'></div>";
				echo '</div>';
			  echo '</div>';
			  
	
	


?>
		</div>
		</div>
		</div>
    </body>
</html>