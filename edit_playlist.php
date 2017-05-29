<?php session_start(); ?>
<?php include 'includes/db.php'; ?>

<?php

if(!isset($_SESSION['email'])){
	header("Location: index.php");
}


if(isset($_GET['edit'])){
	$author = $_SESSION['email'];
	$edit_id = $_GET['edit'];
	
	$pl_query = "SELECT playlist_title, playlist_cover FROM playlists WHERE playlist_id = $edit_id AND playlist_author = '{$author}'";
	$send_pl_query = mysqli_query($conn, $pl_query);
		
	while($row = mysqli_fetch_assoc($send_pl_query)){
		$pl_cover = $row['playlist_cover'];
		$old_name = $row['playlist_title'];
	}
	
	
	if(isset($_POST['edit_playlist'])){
		if(empty($pl_cover)){
			$img_name = $_FILES['pl-cover']['name'];
			$img_temp_name = $_FILES['pl-cover']['tmp_name'];
			$img_size = $_FILES['pl-cover']['size'];
			$img_type = pathinfo($img_name, PATHINFO_EXTENSION);

			if($img_size < 2000000){
				if($img_type == 'gif' || $img_type == 'jpg' || $img_type == 'jpeg' || $img_type == 'png'){
					if(move_uploaded_file($img_temp_name, "images/covers/$img_name")){
						$cover_query = "UPDATE playlists SET playlist_cover = '{$img_name}' ";
						$cover_query .= "WHERE playlist_id = {$edit_id} AND playlist_author = '{$author}'";

						$run_cover_query = mysqli_query($conn, $cover_query);
						if(!$run_cover_query){
							die("FAILED! " . mysqli_error($conn));
						}
					}
				}
				else{
					echo "extension!!!";
				}
			}
			else{
				echo "too big!!!";
			}
		}
		
		
		$new_name = mysqli_real_escape_string($conn, $_POST['playlist']);
		
		if(rename("media/".$old_name, "media/".$new_name)){
			$name_query = "UPDATE playlists SET playlist_title = '{$new_name}' WHERE playlist_id = $edit_id AND playlist_author = '{$author}'";
			$new_name_query = mysqli_query($conn, $name_query);
			
			if(!$new_name_query){
				die("QUERY FAILED! ".mysqli_error($conn));
			}
			
			$messege = "<h2>Playlist Has Been Updated.</h2>";
			$_SESSION['messege'] = $messege;
			//header("Location: dooplay.php");
		}
		else{
			echo "<h2>Sorry, Could Not Update Playlist.</h2>";
		}
	}
}
else{
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
					<form action="" method="post" enctype="multipart/form-data">
						<div class="playlist-name">
							<input type="text" name="playlist" value="<?php echo $old_name; ?>">
						</div>
						<?php
						
						if(empty($pl_cover)){
							echo "
							
								<div class='playlist-cover'>
									<div class='cover-label'>
										<label for='cover'>Playlist Cover</label>
									</div>

									<input type='file' name='pl-cover'>
								</div>
							
							";
						}
						else{
							echo "<div><img src='images/covers/{$pl_cover}' width='100'></div>";
						}
						
						?>
						<div class="submit-playlist">
							<input type="submit" name="edit_playlist" value="Done">
						</div>
					</form>
				</div>
					
					 
		</div>
		
		<script src="js/jquery.js"></script>
		<script src="js/main.js"></script>

	</body>
</html>
