<?php session_start(); ?>
<?php include 'db.php'; ?>


<?php

if(isset($_POST['submit_playlist'])){
	$playlist = $_POST['playlist'];
	
	if(!empty($playlist)){
		$query = "INSERT INTO playlists (playlist_title, playlist_author) ";
		$query .= "VALUES ('{$playlist}', '{$_SESSION['email']}')";
		
		$playlist_query = mysqli_query($conn, $query);
		
		mkdir("../media/$playlist", 0700);
		
		if(!$playlist_query){
			die("failed! " . mysqli_error($conn));
		}
		
		$new_playlist_id = mysqli_insert_id($conn);
		
		$messege = "<h2>Playlist Has Been Created. You Can Now Add Some Tracks In It.</h2>";
		$_SESSION['messege'] = $messege;
		header("Location: ../playlist.php?playlist={$new_playlist_id}");
	}
}

?>