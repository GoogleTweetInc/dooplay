<?php
if(isset($_GET['playlist'])){
	$playlist = $_GET['playlist'];
	$author = $_SESSION['email'];
	$query = "SELECT * FROM playlists WHERE playlist_author = '{$author}' AND playlist_id = $playlist";
	$playst_query = mysqli_query($conn, $query);
	
	while($rows = mysqli_fetch_assoc($playst_query)){
		$cover = $rows['playlist_cover'];
		$title = $rows['playlist_title'];
		
	}
	
	if(!empty($cover)){
			$cover_msg = "<img src='images/covers/{$cover}' width='380' title='Change Cover'>";
		}
		else if(empty($cover)){

			$cover_msg = "<h1 style='margin-left: 110px;margin-top: 100px;'>No Cover</h1>";
		}
		
	if(isset($_POST['addtrack'])){
		$track = $_FILES['track']['name'];
		$track_temp = $_FILES['track']['tmp_name'];
		$track_size = $_FILES['track']['size'];
		$track_ext = pathinfo($track, PATHINFO_EXTENSION);
		
		$playlist_title_query = "SELECT playlist_title FROM playlists WHERE playlist_id = $playlist";
		$title_query = mysqli_query($conn, $playlist_title_query);
		$pl_row = mysqli_fetch_assoc($title_query);
		$playlist_title = $pl_row['playlist_title'];
		
		if($track_size <= '20000000'){
			if($track_ext == 'mp3'){
				if(move_uploaded_file($track_temp, "media/$playlist_title/$track")){
					$query = "INSERT INTO tracks (track_name, track_playlist_id) ";
					$query .= "VALUES ('{$track}', {$playlist})";

					$messege = "<h2>Track Has Been Added To {$playlist_title}</h2>";
					$_SESSION['messege'] = $messege;
					header("Location: playlist.php?playlist={$playlist}");
				}
				else{
					$messege = "<h2>did not upload!</h2>";
					header("Location: playlist.php?playlist={$playlist}");
					$_SESSION['messege'] = $messege;
				}
			}
			else{
				$messege = "<h2>Sorry, You Can Only Add mp3 Files.</h2>";
				$_SESSION['messege'] = $messege;
			}
		}
		else{
			$messege = "<h2>This Track Is Too Big. Try Another One.</h2>";
			$_SESSION['messege'] = $messege;
		}

		

		

		$track_up_query = mysqli_query($conn, $query);

		if(!$track_up_query){
			die("failed! " . mysqli_error($conn));
		}
	}
	
}


?>