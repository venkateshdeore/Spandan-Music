<?php
session_start();
include('includes/connection.php');
if(!isset($_SESSION['uid']))
{
	header('Location:index.php');
	die();
}
$uid=$_SESSION['uid'];
if(!isset($_POST['arguments'][0]))
{
	header('Location:index.php');
	die();
}
$song_id=$_POST['arguments'][0];
$query="SELECT last_paused FROM user_song_map WHERE uid='$uid' AND song_id='$song_id'";
$result=mysqli_query($con,$query);
$row=mysqli_fetch_array($result);
$last_paused=$row['last_paused'];
echo $last_paused;
?>