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
	$query = "DELETE FROM `queue_details` WHERE queue_id='$uid' AND song_id='$song_id'";
	$result = mysqli_query($con, $query);

	$qr = "SELECT * FROM `queue_details` WHERE queue_id='$uid'";
	$rq = mysqli_query($con, $qr);
	if(mysqli_num_rows($rq)==0)
	{
		$query = "UPDATE `user_details` SET `has_queue`='0' WHERE uid='$uid'";
		$result = mysqli_query($con, $query);
		header('Location: dashboard.php');
		die();
	}

	header('Location: edit_the_queue.php');
}
else {
	header('Location: logout.php');
}

?>