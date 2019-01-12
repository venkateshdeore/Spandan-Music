<?php

session_start();
if(!isset($_SESSION['uid']))
{
	header('Location: logout.php');
	die();
}
$uid = $_SESSION['uid'];
include('../includes/connection.php');
if(isset($_POST['send-msg']))
{
	$message = $_POST['message'];
	$query = "INSERT INTO `messages`(`sender_id`, `message`, `msg_time`) VALUES ('$uid', '$message', NOW())";
	$result = mysqli_query($con, $query);
	$q = "UPDATE `user_details` SET `msg_notification`='1' WHERE uid != '$uid' ";
	$r = mysqli_query($con, $q);
	echo "<script>window.open('../chat.php','_self')</script>";
}

?>