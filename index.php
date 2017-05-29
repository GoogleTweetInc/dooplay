<?php session_start(); ?>
<?php include 'includes/db.php'; ?>
<!DOCTYPE html>
<html>
	<head>
		<title>Audio Player</title>
		<link rel="stylesheet" href="css/main.css" type="text/css">
	
	</head>
	<body>
		<div id="container" style="width: 500px;height: 600px;">
			<div class="login">
				
				<form action="includes/login.php" method="post">
				
					<?php
					if(isset($_SESSION['messege'])){
						echo $_SESSION['messege'];

						unset($_SESSION['messege']);
					}
				?>
			
					<h2>Login</h2>
					<div class="login-email">
						<input type="email" name="email" placeholder="EMAIL">
					</div>
					<div class="login-password">
						<input type="password" name="password" placeholder="PASSWORD">
					</div>
					<div class="login-submit">
						<input type="submit" value="Login" name="login">
					</div>
					
				</form>
				
				<p class="register-link">Don't Have a Dooplay Account? <br> <a href="registration.php">Create</a> One Now!</p>
				
			</div>
		</div>
		<script src="js/jquery.js"></script>

	</body>
</html>
