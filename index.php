<?php session_start(); ?>
<?php include 'includes/db.php'; ?>
<!DOCTYPE html>
<html>
	<head>
		<title>Audio Player</title>
		<link rel="stylesheet" href="css/main.css" type="text/css">
		<style>
		
			.login{
				width: 245px;
				margin: 0 auto;
				padding-top: 75px;
			}
			
			.login h1{
				border: 1px solid #fff;
				padding: 10px;
				font-size: 13px;
				margin-bottom: 20px;
			}
			
			.login form h2{
				margin-left: 90px;
			}
			
			.login form input{
				padding-top: 15px;
				padding-bottom: 15px;
				width: 245px;
			}
			
			.login form input[type]{
				font-size: 18px;
			}
			
			.login-email, .login-password, .login-submit{
				margin-top: 15px;
			}
			
			.login-submit input[value]{
				font-weight: bold;
				font-size: 18px;
			}
			
			.register-link{
				margin-top: 15px;
			}
			
			.register-link a{
				color: #fff;
				font-size: 16px;
				text-decoration: none;
			}
			
			.register-link a:hover{
				color: cyan;
			}
			
		
		</style>
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