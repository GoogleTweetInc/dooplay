<?php session_start(); ?>
<?php
if(!isset($_SESSION['email'])){
	header("Location: index.php");
}
?>

<?php include 'includes/db.php'; ?>
<?php include 'includes/update_cover.php'; ?>

<?php
$sess_author = $_SESSION['email'];
$sql = "SELECT playlist_author, playlist_title FROM playlists WHERE playlist_id = $_GET[playlist]";
$sql_query = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($sql_query);
$db_author = $row['playlist_author'];
$db_playlist_title = $row['playlist_title'];

if($db_author != $sess_author){
	header("Location: dooplay.php");
}
?>

<?php
//if(isset($_POST['addtrack'])){
	include 'includes/add_track.php';
//}

 ?>

<!DOCTYPE html>
<html>
	<head>
		<title>Audio Player</title>
		<link rel="stylesheet" href="css/main.css" type="text/css">
		<style>
			
			#container{
				height: auto;
				width: 330px;
			}
		
		#container h2{
				border: 1px solid #fff;
				padding: 10px;
				font-size: 13px;
				margin-bottom: 20px;
				border-radius: 6px;
			text-align: center;
			}
			
			.back-to-link{
				color:aliceblue;
				text-decoration: none;
				margin-left: 10px;
			}	
			
			.back-to-link:hover{
				text-decoration: underline;
			}
			
			#showfilebtn{
				    margin-left: 10px;
					padding: 5px;
					margin-bottom: 10px;
			}
			
			#submitTrack{
				padding: 2px 31px 2px 31px;
				background-color: darkgoldenrod;
				margin-top: 5px;
				margin-bottom: 10px;
			}
			
			#add-track{
				margin-left: 15px;
			}
			
			.track-del-link{
				color: black;
				text-decoration: none;
				font-weight: bold;
				font-family: cursive;
				font-size: 16px;
				display: block;
    			width: 15px;
				float: right;
				
			}
			
			#playlist li{
				width: 270px;
				float: left;
			}
			
			.clearfix{
				clear: both;
			}
			
			#audio-image{
				height: 310px;
			}
			
			#audio-image form{
				margin-left: 80px;
				margin-top: 120px;
			}
			
			#audio-image form input[type="submit"]{
				font-size: 16px;
				margin-top: 15px;
				text-transform: capitalize;
				padding: 10px 60px 10px 60px;
				background-color: black;
				color: aliceblue;
				cursor: pointer;
			}
			
			#title{
				text-align: center;
			}
			
			#title h3{
				font-family: tahoma;
				font-size: 22px;
				letter-spacing: 1px;
			}
		
		</style>
		<script src="js/jquery.js"></script>
	</head>
	<body>
		<div id="container">
			<?php 
			if(isset($_SESSION['messege'])){
				echo $_SESSION['messege'];
				
				//unset($_SESSION['messege']);
			}
			
			?>
			<div id="audio-image">
				
				<?php
				 echo $cover_msg;
				
				?>
				
			</div>
			<script>
			$('#audio-image img').click(function() {
				$(this).fadeOut('medium', function() {
					$('#audio-image').append(
						"<form action='' method='post' enctype='multipart/form-data'>" +
							"<input type='file' name='new_cover' id='newCover'>" +
							"<br>" +
							"<input type='submit' name='apply_new_cover' id='submitCover' value='change'>" +
						"</form>"
					).hide().fadeIn('slow');
					//$('#submitCover').hide();
				});
			});
				
				
					
			</script>
			<div id="title"><h3><?php echo $db_playlist_title; ?></h3></div>
			<div id="audio-player">
				<div id="audio-info">
				
					<span class="title"></span>
				
				</div>
				<input id="volume" type="range" min="0" max="10" value="10">
				<br>
				<div id="audio-buttons">
					<button id="prev"></button>
					<button id="play"></button>
					<button id="pause"></button>
					<button id="stop"></button>
					<button id="next"></button>
				</div>
				<div id="clearfix"></div>
				<div id="tracker">
					<div id="progressbar">
						<span id="progress"></span>
					</div>
					<span id="duration"></span>
				</div>
				<div id="clearfix"></div>
				
				<ul id="playlist">
					


					<?php 
					
					if(isset($_GET['playlist'])){
						$playlist = $_GET['playlist'];
						
						$query = "SELECT * FROM tracks WHERE track_playlist_id = {$playlist}";
						$track_query = mysqli_query($conn, $query);

						while($row = mysqli_fetch_assoc($track_query)){
							$track = $row['track_id'];
							$song = $row['track_name'];
							echo "<li song='{$title}/{$song}' title='Duration'> ".$song."</li>";
							echo "<a href='manage.php?playlist={$playlist}&track={$track}' class='track-del-link'><img src='images/settings.png' alt='settings' width='15' title='Settings'></a>";
							echo "<div class='clearfix'></div>";
							

						}
						
					}
					else{
						header("Location: index.php");
					}

					 ?>
	
				</ul>
				<script>
				
					$('#playlist').hide();
					$(window).ready(function(){
						$('#playlist').delay('medium').slideDown('slow');
					});
				</script>
				<button id="showfilebtn">Add Track</button>
				<br>
				<div id="add-track">
					
				</div>
				
				
				
				<script>
					$(document).ready(function(){
						//$('#add-track').hide();
						
						var addTrackForm = "<form action='' method='post' enctype='multipart/form-data'>" +
												"<input type='file' name='track'>" +
												"<br>" +
												"<input type='submit' name='addtrack' value='Add' id='submitTrack'>" +
											"</form>";
						
						$('#showfilebtn').click(function(){
							$(this).fadeOut('fast', function() {
								$('#add-track').append(addTrackForm).hide().fadeIn('fast');
							});
							
							
						});
						
					});
				</script>
				<a href="dooplay.php" class="back-to-link">Playlists</a>
				
			</div>
		</div>
		
		<script src="js/main.js"></script>

	</body>
</html>
