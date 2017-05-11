<?php include 'db.php'; ?>
<?php session_start(); ?>

<?php

if(isset($_POST['login'])){
	$email = $_POST['email'];
	$password = $_POST['password'];
	
	if(!empty($email) && !empty($password)){
		$email = mysqli_real_escape_string($conn, $email);
		$password = mysqli_real_escape_string($conn, $password);

		$query = "SELECT * FROM users WHERE user_email = '{$email}'";
		$login_query = mysqli_query($conn, $query);

		if(!$login_query){
			die("query failed! ".mysqli_error($conn));
		}

		while($row = mysqli_fetch_assoc($login_query)){
			$db_user_id = $row['user_id']; 
			$db_email = $row['user_email']; 
			$db_password = $row['user_password']; 
			$db_username = $row['username']; 
		}
		
		if($email === $db_email && $password === $db_password){
			$_SESSION['user_id'] = $db_user_id;
			$_SESSION['email'] = $db_email;
			$_SESSION['username'] = $db_username;
			
			header("Location: ../dooplay.php");
		}
		else{
			$messege = "<h1>Wrong Email or Password!</h1>";
			header("Location: ../index.php");
			$_SESSION['messege'] = $messege;
		}
	}
	
	
	else{
		$messege = "<h1>Enter Your Email And Password To Login.</h1>";
		header("Location: ../index.php");
		$_SESSION['messege'] = $messege;
	}
}

?>


