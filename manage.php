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
		<style>
		
			
			#container{
				height: 600px;
			}
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
				text-align: center;
				padding-top: 60px;
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
				padding: 10px;
				background-color: blanchedalmond;
				margin: 8px;
			}
			
			.pls #plLink{
				color: black;
				text-decoration: none;
				font-weight: bold;
				font-size: 16px;
				font-family: tahoma;
			}
			
			.pls #delLink{
				background-color: crimson;
    			padding: 5px;
				font-size: 14px;
			}
			
			.pls #editLink{
				padding: 5px;
    			background-color: chocolate;
				font-size: 14px;
			}
			
			.actions{
				margin-top: 16px;
			}
			
			.actions h3{
				margin-top: 40px;
				font-weight: normal;
			}
			
			.delete, .move, .changename, .delete-pl, .edit-pl{
				padding: 7px 0px 7px 0px;
				transition: background 0.5s;
			}
			
			.delete:hover, .move:hover, .delete-pl:hover, .edit-pl:hover, .changename:hover{
				background: black;
			}
			
			.delete a, .changename a, .move #slideTrigger, .delete-pl a, .edit-pl a{
				color: white;
				text-decoration: none;
				font-size: 24px;
				font-family: tahoma;
    			letter-spacing: 2px;
				margin-top: 0px;
			}
			
			.changename form input{
				padding: 10px;
			}
			
			.changename form input[type='submit']{
				background-color:black;
			}
			
			.changename form input[value='Change']{
				color: aliceblue;
			}
			
			.move #slideTrigger:hover{
				cursor: pointer;
			}
			
			.move-options{
				margin-top: 10px;
			}
			
			.move-options p{
				margin-top: 8px;
			}
			
			.move-options form input[type='submit']{
			    width: 60px;
				padding: 8px;
				background-color: darkkhaki;
				font-size: 16px;
			}
			
			
			.move-options form select{
				width: 120px;
    			padding: 8px;
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