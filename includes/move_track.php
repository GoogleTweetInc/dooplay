<?php session_start(); ?>
<?php include 'db.php'; ?>
<?php
$author = $_SESSION['email'];





if(isset($_POST['move-track'])){
	echo $playlist_id = $_POST['playlist'];
	echo $trackname = $_POST['trackname'];
	
	$get_pl_title = "SELECT * FROM playlists WHERE playlist_id = $playlist_id AND playlist_author = '{$author}'";
	$get_pl_title_query = mysqli_query($conn, $get_pl_title);
	
	while($row = mysqli_fetch_assoc($get_pl_title_query)){
		echo $new_pl_title = $row['playlist_title'];
	}
	
	
	$get_all_pls = "SELECT track_name FROM tracks WHERE track_name = '{$trackname}' AND track_playlist_id = {$playlist_id}";
	if(!$get_all_pls_query = mysqli_query($conn, $get_all_pls)){
		die("query failed! ".mysqli_error($conn));
	}

	$check = mysqli_num_rows($get_all_pls_query);
	
	
	
	$get_old_pl_id = "SELECT track_playlist_id FROM tracks WHERE track_name = '{$trackname}'";
	$get_old_pl_id_query = mysqli_query($conn, $get_old_pl_id);
	
	$i = mysqli_fetch_assoc($get_old_pl_id_query);
	$old_pl_id = $i['track_playlist_id'];
	
	
	$get_old_pl_title = "SELECT playlist_title FROM playlists WHERE playlist_id = {$old_pl_id}";
	$get_old_pl_title_query = mysqli_query($conn, $get_old_pl_title);
	
	$j = mysqli_fetch_assoc($get_old_pl_title_query);
	echo $old_pl_title = $j['playlist_title'];
	
	if($check == 1){
		$messege = "<h2>This Track Is Already In This Playlist</h2>";
		$_SESSION['messege'] = $messege;
		header("Location: ../playlist.php?playlist={$playlist_id}");
	}
	else{
		if(rename("../media/{$old_pl_title}/{$trackname}", "../media/{$new_pl_title}/{$trackname}")){
			$update_pl = "UPDATE tracks SET track_playlist_id = {$playlist_id} WHERE track_name = '{$trackname}'";
			$update_pl_query = mysqli_query($conn, $update_pl);

			if(!$update_pl_query){
				die("failed!!! " . mysqli_error($conn));
			}
			else{
				$messege = "<h2>Track Has Been Moved To {$new_pl_title}</h2>";
				$_SESSION['messege'] = $messege;
				header("Location: ../dooplay.php");
			}
		}
	}
		
}

?>