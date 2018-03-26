<!doctype html>
<html>
	<head>
		<title>Register!</title>
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
						<li><a href="home.php">News</a></li>
						<li><a href="mailto:bradleybrooks@wustl.edu?Subject=News%20Contribution%20Submission" target="_top">Contact</a></li>
						<li><a href="#about">About</a></li>
					
					
					<form id="loginwidget" class="text-right" action="login.php" method="POST">
						<label for="username" class="hf">Username:</label>
						<input type="text" style="width:inherit;" name="username"/>
						<label for="password" class="hf">Password:</label>
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
				<div class="col-lg-12" ">
					<?php
						for($i=0; $i<6; $i=$i+1){
							echo "<br>";
						}
					?>
					<div class="col-lg-5"></div>
					<div class="col-lg-3" id="newForm">
						
						<form class="text-center"  id="NewUsr" action="processRegister.php" method="POST" role="form">
							<div class="form-group">
							Username:<br>
							<input type="text" class="form-control" style="width:inherit;" name="username"/>
							</div>
							<div class="form-group">
							Password:<br>
							<input type="text" class="form-control" style="width:inherit;" name="password"/>
							</div>
							<div class="form-group">
							Password Reset Question #1:
							<input type="text" class="form-control" style="width:inherit;" name="q1"/>
							</div>
							<div class="form-group">
							Password Reset Answer #1:
							<input type="text" class="form-control" style="width:inherit;" name="q1ans"/>
							</div>
							<div class="form-group">
							Password Reset Question #2:
							<input type="text" class="form-control" style="width:inherit;" name="q2"/>
							</div>
							<div class="form-group">
							Password Reset Answer #2:
							<input type="text" class="form-control" style="width:inherit;" name="q2ans"/>
							</div>
							<div class="form-group">
							<button type="submit" class="btn">New user? Join here!</button>
							</div>
						</form>
						
					</div>
					<div class="col-lg-4"></div>
					
					<?php
						for($i=0; $i<46; $i=$i+1){
							echo "<br>";
						}
					?>
				</div>
			</div>
		</div>
	</body>
</html>
