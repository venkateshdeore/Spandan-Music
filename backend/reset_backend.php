<?php
session_start();
if(isset($_SESSION['uid']))
{
	header('Location: dashboard.php');
	die();
}
include('../includes/connection.php');

if(isset($_POST['reset-submit']))
{
	$email = $_POST['email'];
	$query = "SELECT * FROM user_details WHERE email='$email'";
	$result = mysqli_query($con, $query);
	if(mysqli_num_rows($result)==0)
	{
		echo "<script>alert('Enter Valid email ID');window.open('../reset.php','_self');</script>";
		die();
	}
	$token = md5(uniqid(rand(),true));
	$query = "UPDATE `user_details` SET `reset_token`='$token',`reset_complete`='No' WHERE email='$email'";
	$result = mysqli_query($con, $query);

	$server_name_curr=$_SERVER['SERVER_NAME'];
	$verify_link = $server_name_curr."/music/reset_password.php?email=$email&key=$token";
				$to = strtolower($email);
				$subject = "Verify emial to reset password.";
				$body = '<html><head></head><body><a href='.$verify_link.' style="text-decoration:none;padding:10px 20px;background-color:#4b9e60;color:white;border-radius:5px">Click here to reset yout password.</a></body></html>';
				$altbody = 'Reset password link. Click the link to reset.';
				include("../send-mail.php");
				header('Location: ../index.php?action=reset');
				exit;


}	



?>