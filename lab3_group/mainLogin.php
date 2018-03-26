<!DOCTYPE html>
<html>
	<head>
		<title>Homepage</title>
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
						<li><a class="active" href="mainLogin.php">Home</a></li>
						<li><a href="home.php">News</a></li>
						<li><a href="mailto:bradleybrooks@wustl.edu?Subject=News%20Contribution%20Submission" target="_top">Contact</a></li>
						<li><a href="#about">About</a></li>
					
					
					<form id="loginwidget" class="text-right" action="login.php" method="POST">
						<label class="hf">Username:</label>
						<input type="text" style="width:inherit;" name="username"/>
						<label class="hf">Password:</label>
						<input type="text" style="width:inherit;" name="password"/>
						<span class="glyphicons glyphicons-circle-arrow-right"></span>
						<button type="submit" class="btn">Login</button>
					</form>
					
					</ul>
				</div>
			</div>
		</div>
		<div id="div1" class="container-fluid">
			<div class="row">
				<div class="col-lg-12">
					<?php
						for($i=0; $i<8; $i=$i+1){
							echo "<br>";
						}
					?>
					<div class="col-lg-8"></div>
					<div class="col-lg-2" id="login">
						<br>
						<h1>
						<form class="text-center" action="register.php" method="POST">
							<label>Heya! New here?</label>
							<br>
							<button type="submit" class="btn">Join Today!</button>
						</form>
						<form class="text-center" action="guest.php" method="GET">
							<label>Continue as a Guest</label>
							<br>
							<button type="submit" class="btn" name= "guestsubmit" >Go!</button>
						</form>
						</h1>
						<br>
					</div>
					<div class="col-lg-2"></div>
					<?php
						for($i=0; $i<34; $i=$i+1){
							echo "<br>";
						}
					?>
				</div>
			</div>
		</div>
		<div id="div2" class="container-fluid">
			<div class="row">
				<div class="col-lg-12">
					<form class="text-right" action="forgetpassword.php" method="POST">
						<h6 class="text-right" id="forget">Forgot your password?
						<label class="hf">Username:</label>
						<input type="text" style="width:inherit;" name="username"/>
						<button type="submit" class="btn">Retrieve Password</button></h6>
					</form>
					</ul>
				</div>
			</div>
		</div>
		
                
    </body>
</html>