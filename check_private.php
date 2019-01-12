<?php
include('includes/connection.php');
session_start();
if(!isset($_SESSION['uid']))
{
	header('Location: logout.php');
	die();
}
$uid = $_SESSION['uid'];
if(isset($_GET['song_id']))
{
	$song_id = $_GET['song_id'];
	$p = $_GET['p'];
	$query = "SELECT * FROM user_song_map WHERE uid='$uid' AND song_id='$song_id'";
	$result = mysqli_query($con, $query);
	if(mysqli_num_rows($result)!=0)
	{
		$row = mysqli_fetch_array($result);
		$is_private = $row['is_private'];
		$is_private = 1 - $is_private;
		$query = "UPDATE `user_song_map` SET `is_private`='$is_private' WHERE uid='$uid' AND song_id='$song_id'";
		$result = mysqli_query($con, $query);
		if($p==0)
		{
			header('Location: dashboard.php');
		}
		else
		{
			header('Location: all_songs_fetch.php');
		}
		die();
	}
	else
	{
		header('Location: logout.php');
		die();
	}
}
else {
	header('Location: logout.php');
	die();
}

?>