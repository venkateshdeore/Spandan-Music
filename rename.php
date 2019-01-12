<!-- <!DOCTYPE html>
<html>
<body>
	<form method='POST' action=''>
	<input type='text' name='songid'>
	<input type='text' name='rename'>
	<input type='submit'>
</form>
</body>
</html> -->

<?php

	include('includes/connection.php');
	session_start();
	if(!isset($_SESSION['uid']))
	{
		header('Location: logout.php');
		die();
	}
	if(!isset($_GET['song_id']) || !isset($_GET['rename']) || $_GET['song_id']=="" || $_GET['rename']=="")
	{
		header('Location: dashboard.php');
		die();
	}
	$uid = $_SESSION['uid'];
	$song_id = $_GET['song_id'];
	$rename = $_GET['rename'];
	if($rename == '')
		die();
	$query = "SELECT * FROM user_song_map WHERE custom_name LIKE '$rename' AND uid=$uid";
	$res = mysqli_query($con,$query);
	if(mysqli_num_rows($res) != 0)
	{
		echo "<script>alert('Name already exists');window.location='dashboard.php';</script>";
		die();
	}

	$query = "UPDATE user_song_map SET custom_name='$rename' WHERE uid=$uid AND song_id=$song_id";
	$result = mysqli_query($con,$query);
	if($result == 0)
	{
		echo "<script>alert('Song not present.');window.location='dashboard.php';</script>";
		die();
	}
	echo "<script>alert('Successfully renamed');window.location='dashboard.php';</script>";
	
?>