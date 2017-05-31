<?php session_start(); ?>
<?php

if(!isset($_SESSION['email'])){
	header("Location: index.php");
}

$author = $_SESSION['email'];

?>

<?php include 'includes/db.php'; ?>

<?php
$sess_author = $_SESSION['email'];
$sql = "SELECT * FROM playlists WHERE playlist_id = $_GET[playlist]";
$sql_query = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($sql_query);
$db_author = $row['playlist_author'];
$this_pl = $row['playlist_title'];

if($db_author != $sess_author){
	header("Location: dooplay.php");
}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Audio Player</title>
		<link rel="stylesheet" href="css/main.css" type="text/css">
	
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
					<h1 style="margin-bottom:15px;"><?php echo $this_pl; ?></h1>
					<h3>Actions On:</h3>
					
					
					
						<?php 
							if(isset($_GET['playlist']) && isset($_GET['track'])){
								$playlist = $_GET['playlist'];
								$track_id = $_GET['track'];
								
								$get_track = "SELECT track_name FROM tracks WHERE track_id = {$track_id}";
								$get_track_query = mysqli_query($conn, $get_track);
								
								$row = mysqli_fetch_assoc($get_track_query);
								$trackname = $row['track_name'];
								
								echo "<p id='trackName'>{$trackname}</p>";
							}
							else{
								header("Location: dooplay.php");
							}
						
						 ?>
						 
						 
						 <div class="actions">
						 	<div class="delete">
						 		<?php
								echo "<a href='includes/delete_track.php?playlist={$playlist}&delete_track={$track_id}'>Delete</a>";
								?>
							 </div>
							 
							 <div class="changename">
							 	<a href="#">Change Name</a>
							 </div>
							 
							 <div class="move">
								<p id="slideTrigger">Move</p>
							 </div>
							 
								 <div class="move-options">
								 	<form action="includes/move_track.php" method="post">
										<select name="playlist" id="">
										<?php
										 $get_playlists = "SELECT * FROM playlists WHERE playlist_author = '{$author}'";
										 $get_playlists_query = mysqli_query($conn, $get_playlists);

										 while($rows = mysqli_fetch_assoc($get_playlists_query)){
											 $pl_id = $rows['playlist_id'];
											 $pl_title = $rows['playlist_title'];
											 
											 if($playlist == $pl_id){
												 echo "<option value='{$pl_id}' selected>{$pl_title}</option>";
											 }
											 else{
												 echo "<option value='{$pl_id}'>{$pl_title}</option>"; 
											 }
											 
										 }

										 ?>
									 </select>
									 <p>
									 	<input type="hidden" name="trackname" value="<?php echo $trackname; ?>">
									 </p>
									 <p>
									 	<input type="submit" name="move-track" id="movetr" value="Move">
									 </p>
									 
								 </form>
							 </div>
							 <h3>Other</h3>
							 <div class="edit-pl">
							 	<a href='edit_playlist.php?edit=<?php echo $playlist; ?>' id='editLink'>Edit Playlist</a>
							 </div>
							 <?php
							 
							 $track_query = "SELECT * FROM tracks WHERE track_playlist_id = $playlist";
									$track_num_query = mysqli_query($conn, $track_query);

									if(mysqli_num_rows($track_num_query) != 0){
										echo "<div class='delete-pl'>
												<a href='includes/delete_playlist.php?delete={$playlist}'>Delete Playlist</a>
											</div>"	;
									}
							 
							 ?>
							 <!--<div class="delete-pl">
							 	<a href="#">Delete Playlist</a>
							 </div>-->
						 </div>
				</div>
				
					
					 
		</div>
		
		<script src="js/jquery.js"></script>
		<script src="js/slide.js"></script>
		<script>
			$('.changename a').click(function() {
				$(this).fadeOut('medium', function() {
					//var track = '';
					$('.changename').append(
						"<form action='includes/change_title.php' method='post'>" +
							"<input type='text' name='new_name' value='<?php echo $trackname; ?>'>" +
							"<input type='hidden' name='playlist_id' value='<?php echo $playlist; ?>'>" +
							"<input type='hidden' name='track_id' value='<?php echo $track_id; ?>'>" +
							"<input type='submit' name='change' value='Change'>" +							 
						"</form>"
					).hide().fadeIn('fast');
					
				});
			});
			
			$('.changename').mouseenter(function() {
				$("input[value='Change']").css({"background": "darkcyan", "color": "black"});
			});
			
			$('.changename').mouseleave(function() {
				$("input[value='Change']").css({"background": "black", "color": "white"});
			});
			
			
			$('#movetr').hide();
			
			$('.move-options select').on('change', function() {
				$('#movetr').fadeIn('slow');
			});
			
		</script>
		

	</body>
</html>
