
<!-- Author Terry Lyu, AB Brooks-->
<!-- Student ID 435091, 441827-->
<!doctype html>
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
		
	</head>
	<body>
		
	<div class="container-fluid">
		<div class="row">
		<div class="col-lg-12" style="background-color:#A9D0F5;">
		<?php
			for($i=0; $i<3; $i=$i+1){
				echo "<br>";
			}
		?>
		<div class="row">
		<div class="col-lg-4" style="background-color:#A9D0F5;"></div>
		<div class="col-lg-4" style="background-color:#F6F6F9;">
			<?php
			#for($i=0; $i<8; $i=$i+1){
			#	echo "<br>";
			#}
			?>
			<br>
			<img style="display: block; margin: auto; width: 15%;" src="icon128-2x.png" alt="file">
				<h1 class="text-center">Welcome!<small>
				<?php
					$i = rand(1,15);
					if($i==1){
						echo "ようこそ！";
					}
					elseif($i==2){
						echo "¡Bienvenido!";
					}
					elseif($i==3){
						echo "Bienvenue!";
					}
					elseif($i==4){
						echo "Добро пожаловат!";
					}
					elseif($i==5){
						echo "Hoşgeldiniz!";
					}
					elseif($i==6){
						echo "欢迎";
					}
					elseif($i==7){
						echo "أهلاً و سهلاً";
					}
					elseif($i==8){
						echo " Benvenuto!";
					}
					elseif($i==9){
						echo "Willkommen!";
					}
					elseif($i==10){
						echo "ברוך הבא";
					}
					elseif($i==11){
						echo "स्वागत";
					}
					elseif($i==12){
						echo "환영합니다";
					}
					elseif($i==13){
						echo "Velkommen!";
					}
					elseif($i==14){
						echo "Aloha!";
					}
					elseif($i==15){
						echo "Välkommen!";
					}
					elseif($i==16){
						echo "ยินดีต้อนรับ";
					}
					elseif($i==17){
						echo "Croeso!";
					}
					elseif($i==18){
						echo "Tervetuloa!";
					}
				?>
				</small></h1>
				<br>
				<form class="text-center" action="siteLogin.php" method="GET">
					<label for="username">Username:</label>
					<input type="text" style="width:inherit;" name="username"/>
					<span class="glyphicons glyphicons-circle-arrow-right"></span>
					<button type="submit" class="btn btn-primary">Exisiting User Login</button>
				</form>
				<br>
				<form class="text-center" action="new.php" method="GET">
					<label 	for="username"> New User: </label>
					<input type="text" style="width:inherit;" name="username"/>
					<button type="submit" class="btn btn-info">New user? Join here!</button>
				</form>
			<?php
			for($i=0; $i<10; $i=$i+1){
				echo "<br>";
			}
			?>
		</div>
		<div class="col-lg-4" style="background-color:#A9D0F5;"></div>
		</div>
		<?php
			for($i=0; $i<22; $i=$i+1){
				echo "<br>";
			}
		?>
		</div>
		</div>
	</div>
	</body>
</html>

