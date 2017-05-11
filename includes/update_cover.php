<?php

if(isset($_GET['playlist'])){
	$playlist_id = $_GET['playlist'];
	if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['apply_new_cover'])){
		$new_cover = $_FILES['new_cover']['name'];
		$tmp = $_FILES['new_cover']['tmp_name'];
		$size = $_FILES['new_cover']['size'];
		$ext = pathinfo($new_cover, PATHINFO_EXTENSION);
		
		$allowed_exts = ['png', 'jpg', 'jpeg', 'gif', 'GIF', 'PNG', 'JPG', 'JPEG'];
		
		if($size <= 3000000){
			if(in_array($ext, $allowed_exts)){
				if(move_uploaded_file($tmp, "images/covers/$new_cover")){
					$sql_query = "UPDATE playlists SET playlist_cover = '$new_cover' ";
					$sql_query .= "WHERE playlist_id = $playlist_id";
					
					$send_sql_query = mysqli_query($conn, $sql_query);
					
					if(!$send_sql_query){
						die("FAILED! ".mysqli_error($conn));
					}
					else{
						$messege = "<h2>Cover Updated!</h2>";
						$_SESSION['messege'] = $messege;
						header("Location: playlist.php?playlist=$playlist_id");
					}
				}
			}
			else{
				echo "You can upload only image file here!";
			}
		}
		else{
			echo "File too big!";
		}
	}
}

?>