<?php session_start(); ?>
<?php include 'db.php'; ?>
<?php

function rename_track($playlist, $old, $new){
	if(rename("../media/{$playlist}/{$old}", "../media/{$playlist}/{$new}")){
		return true;
	}
	else{
		return false;
	}
}

if(isset($_POST['change'])){
	echo $new_name = mysqli_real_escape_string($conn, $_POST['new_name']).".mp3";
	$playlist_id = mysqli_real_escape_string($conn,$_POST['playlist_id']);
	$track_id = mysqli_real_escape_string($conn,$_POST['track_id']);
	
	$get_playlist_name = "SELECT playlist_title FROM playlists WHERE playlist_id = {$playlist_id}";
	$get_playlist_name_query = mysqli_query($conn, $get_playlist_name);
	
	$row_pl = mysqli_fetch_assoc($get_playlist_name_query);
	echo $playlist_name = $row_pl['playlist_title'];
	
	$get_track_old_name = "SELECT track_name FROM tracks WHERE track_id = {$track_id}";
	$get_track_old_name_query = mysqli_query($conn, $get_track_old_name);
	
	$row_tr = mysqli_fetch_assoc($get_track_old_name_query);
	echo $old_name = $row_tr['track_name'];
	
	$get_track = "SELECT track_name FROM tracks WHERE track_name = '{$new_name}'";
	$get_track_query = mysqli_query($conn, $get_track);
	
	if(mysqli_num_rows($get_track_query) == 1){
		echo "<p>Same name</p>";
	}
	else{
		if(rename_track($playlist_name, $old_name, $new_name)){
			$update_track_name = "UPDATE tracks SET track_name = '{$new_name}' ";
			$update_track_name .= "WHERE track_id = {$track_id}";
			
			$update_track_name_query = mysqli_query($conn, $update_track_name);
			
			if(!$update_track_name_query){
				die("query failed! ". mysqli_error($conn));
			}
			else{
				echo "Track Renamed!";
			}
		}
	}
	
}

?>