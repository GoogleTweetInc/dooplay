<?php session_start(); ?>
<?php include 'db.php'; ?>


<?php
$author = $_SESSION['email'];
if(isset($_GET['playlist']) && isset($_GET['delete_track'])){
	$playlist = $_GET['playlist'];
	$track_id = $_GET['delete_track'];
	
	$track_name_sql = "SELECT track_name FROM tracks WHERE track_id = {$track_id}";
	$track_name_query = mysqli_query($conn, $track_name_sql);
	
	if(!$track_name_query){
		die("Query Failed! ".mysqli_error($conn));
	}
	
	$tr_row = mysqli_fetch_assoc($track_name_query);
	$track_name = $tr_row['track_name'];
	
	$pl_name_sql = "SELECT * FROM playlists WHERE playlist_id = {$playlist} ";
	$pl_name_sql .= "AND playlist_author = '{$author}'";
	$pl_name_query = mysqli_query($conn, $pl_name_sql);
	
	if(!$pl_name_query){
		die("Query Failed! ".mysqli_error($conn));
	}
	
	$pl_row = mysqli_fetch_assoc($pl_name_query);
	$playlist_title = $pl_row['playlist_title'];
	
	if(unlink("../media/".$playlist_title."/".$track_name)){
		$delete_track_sql = "DELETE FROM tracks WHERE track_id = {$track_id}";
		$delete_track_query = mysqli_query($conn, $delete_track_sql);
		
		if($delete_track_query){
			$messege = "<h2>Track Has Been Deleted.</h2>";
			$_SESSION['messege'] = $messege;
			header("Location: ../playlist.php?playlist={$playlist}");
		}
		else{
			die("Query Failed! ".mysqli_error($conn));
		}
	}
}

?>