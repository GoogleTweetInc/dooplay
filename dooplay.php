<?php session_start(); ?>

<?php

if(!isset($_SESSION['email'])){
	header("Location: index.php");
}

//echo session_status();
//echo session_name();
//echo session_encode();

?>

<?php include 'includes/db.php'; ?>
<!DOCTYPE html>
<html>
	<head>
		<title>Audio Player</title>
		<link rel="stylesheet" href="css/main.css" type="text/css">
		<style>
		
			
			
			.logged a{
				width: auto;
				float: right;
				color: #fff;
				text-decoration: none;
				background-color: firebrick;
				padding: 4px 8px 4px 8px;
				font-size: 16px;
				border-radius: 2px;

			}
			
			#user{
				width: auto;
				float: left;
			}
			
			.clearfix{
				clear: both;
			}
			
			.upperbar{
				padding: 15px;
			}
			
			.playlists{
				width: 400px;
				margin: 0 auto;
				/*text-align: center;*/
				padding-top: 60px;
			}
			
			.playlists h3{
				text-align: center;
			}
			
			#createLink{
				color: #fff;
				text-decoration: none;
				background: cadetblue;
				padding: 12px 30px 12px 30px;
				font-size: 16px;
			}
			
			#addLink{
				color: white;
				text-decoration: none;
				background-color: cornflowerblue;
				padding: 6px 30px 6px 30px;
				font-size: 14px;
			}
			
			#container h2{
				border: 1px solid #fff;
				padding: 10px;
				font-size: 13px;
				margin-bottom: 20px;
				border-radius: 6px;
			text-align: center;
			}
			
			#editLink, #delLink{
				color: antiquewhite;
				text-decoration: none;
				margin-left: 10px;
				
			}
			
			.pls{
				width: 170px;
				height: 125px;
				float: left;
				padding: 0px;
				background-color: aliceblue;
				margin: 14px;
				margin-bottom: 20px;
				overflow: hidden;
			}
			
			.pls #plLink{
				color: black;
				text-decoration: none;
				font-weight: bold;
				font-size: 16px;
				font-family: tahoma;
				padding: 2px;
			}
			
			.pls #delLink{
				background-color: crimson;
    			padding: 2px;
				font-size: 12px;
			}
			
			.pls #editLink{
				padding: 2px;
    			background-color: chocolate;
				font-size: 12px;
			}
			
			.cover-not{
				color: black;
				font-size: 16px;
				width: 85px;
				text-align: center;
				margin-left: 40px;
				margin-top: 22px;
			}
			
			
		
		</style>
	</head>
	<body>
	
	
		<div id="container" style="width: 400px;">
			<?php
			if(isset($_SESSION['messege'])){
				echo $_SESSION['messege'];
				
				unset($_SESSION['messege']);
			}
			?>
			<div class="upperbar">
				<div class="logged">
					<?php echo "<p id='user'> Logged in ".$_SESSION['username']."</p>"; ?>
					<a href="includes/logout.php">Log out</a>
					<div class="clearfix"></div>
				</div>
			</div>
			<hr>
				
				
				
				<div class="playlists">
					<h3>My Playlists</h3>
					
					
					
						<?php 
					
						
					
						$author = $_SESSION['email'];	
					
						$query = "SELECT * FROM playlists WHERE playlist_author = '{$author}'";
						$list_query = mysqli_query($conn, $query);

						if(mysqli_num_rows($list_query) == 0){
							echo "<p>It's Lonely Here So Far. Go Create a Playlist!</p>";
							echo "<br>";
							echo "<a href='create_playlist.php' id='createLink'>Create</a>";
							
						}
						else{
								
								while($row = mysqli_fetch_assoc($list_query)){
									$title = $row['playlist_title'];
									$id = $row['playlist_id'];
									$cover = $row['playlist_cover'];


									echo "<div class='pls'>";		
									echo "<a id='plLink' href='playlist.php?playlist={$id}'>{$title}</a><br>";
									
									if(!empty($cover)){
										echo "<a href='playlist.php?playlist={$id}'><img src='images/covers/{$cover}' width='180'></a>";
									}
									else{
										echo "<div class='cover-not'>Cover Unavailable</div>";
									}
									
									

									echo "</div>";
									//echo "<div class='clearfix'></div>";
									
									
									
									
								
								
								}
							echo "<br>";
							echo "<div style='text-align:center; clear:both; padding-bottom:60px;'><a href='create_playlist.php' id='addLink'>Add</a></div>";
						}

						 ?>
					
				<div class="clearfix"></div>		
					
				</div>
				
					
					 
		</div>
		
		<script src="js/jquery.js"></script>

	</body>
</html>