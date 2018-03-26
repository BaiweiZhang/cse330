
<!DOCTYPE html>
	
	<head>
	<title>File Management</title>
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
	</head>
	
	<body>
		<div class="container-fluid">
			<div class="row">
				<div class="col-lg-12" style="background-color:#A9D0F5;">
					<form class="text-center" action='logout.php' method='GET'>
						<br>
						<button type="submit" style="float: right;" class="btn btn-primary btn-lg">Logout</button>
					</form>
					<?php
						for($i=0; $i<5; $i=$i+1){
							echo "<br>";
						}
					?>
					<div class="row">
					<div class="col-lg-1" style="background-color:#A9D0F5;"></div>
					<div class="col-lg-10" style="background-color:#F6F6F9;">
						<br>
						<br>
						<br>
						<div class="row">
						<div class="col-lg-1" style="background-color:#F6F6F9;"></div>
						<div class="col-lg-3" style="background-color:#F6F6F9;">
							<form class="text-center" enctype="multipart/form-data" action="upload.php" method="POST">
								<h2>New Upload <small>Search Local Disk:</small></h2>
								<br>
								<br>
								<label class="btn btn-default btn-file">
								Choose File <input style="display: block; margin:auto;" name="uploadedfile" type="file" id="uploadfile_input" />
								</label>
								<br>
								<br>
								<button type='submit' class='btn btn-primary' value="Upload File" style="display: block; margin: auto;">Upload File</button>
							</form>
						</div>
						
						<div class="col-lg-4" style="background-color:#F6F6F9;">
							
							<?php
							session_start();
								$username = $_SESSION['username'];
								$target_dir= sprintf("/media/module2/%s/", $username);
								$target_file = scandir($target_dir);
							
								echo "<form class='text-center'><h2>Your Files  <small>Manage Your File Library:</small></h2><br></form>";
											for ($a=0;$a<count($target_file);$a++) {									
											if($target_file[$a]!="." && $target_file[$a]!=".."){
											
												printf("<p class='text-center'><strong>".$target_file[$a]."</strong></p>");
												echo "<table class='table'><tr>";
												echo "<td><form class='text-center' action='view.php' method='POST'>
													<input type='hidden' name='filename' value='".$target_file[$a]. "'/>
													<button type='submit' class='btn btn-primary btn-sm' name='view' value='view'>View</button></form></td>";
								
												echo "<td><form class='text-center' action='delete.php' method='POST'>
													<input type='hidden' name='filename' value='" .$target_file[$a]. "'/>
													<button type='submit' class='btn btn-primary btn-sm' name='delete' value='Delete'>Delete</button></form></td>";
								
												echo "<td><form class='text-center' action= 'share.php' method = 'POST' >
													<input type = 'hidden' name = 'filename' value ='" .$target_file[$a]. "'/>
													<button type='submit' class='btn btn-primary btn-sm' name = 'share' value='share'>Share</button></form></td>" ;
												echo "</tr></table>" ;
											}
										}
										$shared_dir="/media/module2/share";
										$shared_file=scandir($shared_dir);
								?>
								
						</div>
						<div class="col-lg-3" style="background-color:#F6F6F9;">
							<h2>Public Data <small>Shared files:</small></h2>
							<br>
							<br>
							<?php
								echo "<ul class='list-group'>";
								for ($b=0; $b<count($shared_file);$b++){
									
									if($shared_file[$b]!="." && $shared_file[$b]!=".."){
										printf("<li class='list-group-item float:center'>
										<form action='viewShared.php' method='POST'>
										<p class='text-left'><label>".$shared_file[$b]."</label>
										<input type='hidden' name='filename' value='".$shared_file[$b]."'/>
										<button type='submit' class='btn btn-primary btn-sm pull-right' name='view' value='view'>View</button></p></form> ", $shared_file[$b])."</li>";
									}
									
								}
								echo "</ul>";
							?>
						</div>
						<div class="col-lg-1" style="background-color:#F6F6F9;">
					</div>
					</div>
				<br>
				<br>
				<a class="btn btn-primary"
					href="https://twitter.com/intent/tweet?text=Here%20is%20a%20file%20sharing%20website!%20Check%20it%20out!"
					data-size="large">
					Tweet About Us!</a>
				<!--<link rel="canonical"
				href="https://dev.twitter.com/web/tweet-button">-->
				<br>
				<br>
			</div>
		</div>
		<div class="col-lg-1" style="background-color:#A9D0F5;"></div>
			<?php
				for($i=0; $i<30; $i=$i+1){
					echo "<br>";
				}
			?>
			</div>
			</div>
			
	</div>
</body>
</html>