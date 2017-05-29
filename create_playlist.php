<?php session_start(); ?>

<?php

if(!isset($_SESSION['email'])){
	header("Location: index.php");
}

?>

<?php include 'includes/db.php'; ?>
<!DOCTYPE html>
<html>
	<head>
		<title>Audio Player</title>
		<link rel="stylesheet" href="css/main.css" type="text/css">

	</head>
	<body>
	
	
		<div id="container" style="width: 400px;height: auto;">
			<div class="upperbar">
				<div class="logged">
					<?php echo "<p id='user'> Logged in ".$_SESSION['username']."</p>"; ?>
					<a href="includes/logout.php">Log out</a>
					<div class="clearfix"></div>
				</div>
			</div>
			<hr>
				
				
				
				<div class="new-playlist playlists">
					<form action="includes/new_playlist.php" method="post">
						<div class="playlist-name">
							<input type="text" name="playlist" placeholder="Name Your Playlist">
						</div>
						<div class="submit-playlist">
							<input type="submit" name="submit_playlist" value="Add">
						</div>
					</form>
				</div>
					
					 
		</div>
		
		<script src="js/jquery.js"></script>
		<script src="js/main.js"></script>

	</body>
</html>
