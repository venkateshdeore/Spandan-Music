<?php
include('includes/connection.php');
session_start();
if((!isset($_SESSION['uid']))||(!isset($_GET['song_id'])))
{
	header('Location:logout.php');
	die();	
}

$queue_id=$_SESSION['uid'];
$song_id=$_GET['song_id'];
$query1="SELECT * FROM user_song_map WHERE song_id='$song_id'";
$result1=mysqli_query($con,$query1);
if(mysqli_num_rows($result1)==0)
{
	echo "<script>alert('Song id mishandled');window.location='logout.php';</script>";
}
$query3="SELECT * FROM queue_details WHERE queue_id='$queue_id' AND song_id='$song_id'";
$result3=mysqli_query($con,$query3);
if(mysqli_num_rows($result3))
{
	echo "<script>alert('Already in queue');window.location='dashboard.php';</script>";
	die();
}
$query="INSERT INTO queue_details (queue_id,song_id) VALUES ('$queue_id','$song_id')";
mysqli_query($con,$query);
$query2="UPDATE user_details SET has_queue='1' WHERE uid='$queue_id";
mysqli_query($con,$query2);
echo "<script>alert('Successfully Added');window.location='dashboard.php';</script>";
?>