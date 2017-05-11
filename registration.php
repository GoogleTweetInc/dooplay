<?php session_start(); ?>
<?php include 'includes/db.php'; ?>


<?php
$messege = '';

if($_SERVER['REQUEST_METHOD'] == 'POST'){
	$email = $_POST['email'];
	$username = $_POST['username'];
	$password = $_POST['password'];
	$conf_password = $_POST['confirm_password'];
	
	if(!empty($email) && !empty($username) && !empty($password) && !empty($conf_password)){
		
		$email = mysqli_real_escape_string($conn, $email);
		$username = mysqli_real_escape_string($conn, $username);
		$password = mysqli_real_escape_string($conn, $password);
		
		$query = "SELECT user_email FROM users WHERE user_email = '{$email}'";
		$email_query = mysqli_query($conn, $query);
		
		if(mysqli_num_rows($email_query) >= 1){
			$messege = "<h1>This Email Already Exists!</h1>";
			$_SESSION['messege'] = $messege;
			header("Location: registration.php");
		}
		else{
			
			if($password === $conf_password){
				$reg_query = "INSERT INTO users (username, user_email, user_password) ";
				$reg_query .= "VALUES ('{$username}', '{$email}', '{$password}')";
				
				$register_user = mysqli_query($conn, $reg_query);
				
				if(!$register_user){
					die("query failed! ".mysqli_error($conn));
				}
				else{
					$messege = "<h1>You Have Registered Successfully! <br> You Can Login Now. <br> <a href='index.php'>Login</a></h1>";
					$_SESSION['messege'] = $messege;
					header("Location: index.php");
				}
			}
			else{
				$messege = "<h1>Password Does Not Match!</h1>";
				$_SESSION['messege'] = $messege;
				header("Location: registration.php");
			}
			
			
			
		}
	}
	else{
		$messege = "<h1>Please Fill in These Fields!</h1>";
		$_SESSION['messege'] = $messege;
		header("Location: registration.php");
	}
}

?>


<!DOCTYPE html>
<html>
	<head>
		<title>Audio Player</title>
		<link rel="stylesheet" href="css/main.css" type="text/css">
		<style>
		
			.register{
				width: 195px;
				margin: 0 auto;
				padding-top: 75px;
			}
			
			.register h1{
				border: 1px solid #fff;
				padding: 10px;
				font-size: 13px;
				margin-bottom: 20px;
			}
			
			.register form h2{
				margin-left: 55px;
			}
			
			.register form input{
				padding-top: 15px;
				padding-bottom: 15px;
				width: 195px;
			}
			
			.register form input[type]{
				font-size: 16px;
			}
			
			.register-email, .register-password, .confirm-register-password, .register-submit, .register-username{
				margin-top: 15px;
			}
			
			.register-submit input[value]{
				font-weight: bold;
				font-size: 18px;
			}
			
			
			
		
		</style>
	</head>
	<body>
		<div id="container" style="width: 500px;height: 600px;">
			<div class="register">
				<?php 
				if(isset($_SESSION['messege'])){
					echo $_SESSION['messege'];

					//unset($_SESSION['messege']);
				}
				
				?>
				<form action="" method="post">
				<h2>Sign Up</h2>
					<div class="register-email">
						<input type="email" name="email" placeholder="EMAIL">
					</div>
					<div class="register-username">
						<input type="text" name="username" placeholder="USERNAME">
					</div>
					<div class="register-password">
						<input type="password" name="password" placeholder="PASSWORD">
					</div>
					<div class="confirm-register-password">
						<input type="password" name="confirm_password" placeholder="COFIRM PASSWORD">
					</div>
					<div class="register-submit">
						<input type="submit" value="Sign Up" name="login">
					</div>
					
				</form>
				
				
				
			</div>
		</div>
		<script src="js/jquery.js"></script>
		<script src="js/main.js"></script>

	</body>
</html>