<?php session_start(); ?>
<?php include 'db.php'; ?>


<?php

/*
function dir_is_empty($dirname)
{
  if (!is_dir($dirname)) return false;
  foreach (scandir($dirname) as $file)
  {
    if (!in_array($file, array('.','..', '.mp3'))) return false;
  }
  return true;
}*/





	if(isset($_GET['delete'])){
		$author = $_SESSION['email'];
		$del_id = $_GET['delete'];
		$source = "../media/";
		
		$query = "SELECT * FROM tracks WHERE track_playlist_id = $del_id ";
		
		$delete_query = mysqli_query($conn, $query);
		
		while($del_rows = mysqli_fetch_assoc($delete_query)){
			$track_name = $del_rows['track_name'];
			
			$dir_query = "SELECT * FROM playlists WHERE playlist_id = $del_id ";
			$dir_query .= "AND playlist_author = '$author'";
			
			$get_dir_query = mysqli_query($conn, $dir_query);
			
			while($pl_rows = mysqli_fetch_assoc($get_dir_query)){
				$dir_name = $pl_rows['playlist_title'];
			}
			
			if(unlink($source.$dir_name."/".$track_name)){
				$delete_tr = "DELETE FROM tracks WHERE track_playlist_id = $del_id ";
				
				$delete_tr_query = mysqli_query($conn, $delete_tr);
				
				if(!$delete_tr_query){
					die("query failed! ".mysqli_error($conn));
				}
				else{
					echo "<h1>Deleted!</h1>";
				}
			}
		}
		if(rmdir($source.$dir_name)){
			$delete_pl = "DELETE FROM playlists WHERE playlist_id = $del_id AND playlist_author = '$author'";
			$delete_pl_query = mysqli_query($conn, $delete_pl);
					
			if(!$delete_pl_query){
				die("query failed! ".mysqli_error($conn));
			}
			else{
				$messege = "<h2>Playlist Has Been Deleted.</h2>";
				$_SESSION['messege'] = $messege;
				header("Location: ../dooplay.php");
			}
		}
	}
?>