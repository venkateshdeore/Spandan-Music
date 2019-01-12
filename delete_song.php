<?php
include('includes/connection.php');
session_start();
if(!isset($_SESSION['uid']))
{
	header('Location: logout.php');
	die();
}
$uid = $_SESSION['uid'];
if(isset($_GET['song_id']) and isset($_GET['p']))
{
	$song_id = $_GET['song_id'];
	$p = $_GET['p'];
	$qr = "SELECT * FROM user_song_map WHERE uid='$uid' and song_id='$song_id'";
	$rq = mysqli_query($con, $qr);
	if(mysqli_num_rows($rq)==0)
	{
		echo "<script>alert('Song with this ID doesnt exist');window.open('logout.php', '_self');</script>";
		die();
	}
	$query = "DELETE FROM `user_song_map` WHERE uid='$uid' and song_id='$song_id' ";
	$result = mysqli_query($con, $query);
	
	$query = "DELETE FROM `queue_details` WHERE queue_id='$uid' and song_id='$song_id' ";
	$result = mysqli_query($con, $query);

	$query = "SELECT * FROM `user_song_map` WHERE song_id='$song_id'";
	$result = mysqli_query($con, $query);
	if(mysqli_num_rows($result) == 0)
	{
		$abc="rm songs/".$song_id.".mp3";
		shell_exec($abc);
		$qr = "DELETE FROM `song_details` WHERE song_id='$song_id'";
		$rq = mysqli_query($con, $qr);
	}

	if($p == 0)
	{
		header('Location: dashboard.php');
		die();
	}
	else if($p == 1)
	{
		header('Location: all_songs_fetch.php');
	}
}
else
{
	header('Location: logout.php');
	die();
}

?>