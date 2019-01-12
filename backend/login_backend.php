<?php
session_start();
include('../includes/connection.php');
if(isset($_SESSION['uid']))
{
	header('Location: dashboard.php');
	die();
}
if(isset($_POST['login-submit']))
{
	$email = mysqli_real_escape_string($con, $_POST['email']);
	$pass = mysqli_real_escape_string($con, $_POST['password']);
	$pass = md5(md5($email).md5($pass));
	$query = "SELECT * FROM user_details WHERE email='$email' AND pass='$pass' AND verify_key='Yes' ";
	$result = mysqli_query($con, $query);
	$check = mysqli_num_rows($result);
	$result = mysqli_fetch_array($result);
	if($check == 1)
	{
		$uid = $result['uid'];
		$_SESSION['uid'] = $uid;
		$q = "UPDATE `user_details` SET `last_login`=NOW() WHERE uid='$uid' ";
		$r = mysqli_query($con, $q);
		echo "<script>window.open('../dashboard.php','_self');</script>";
	}
	else
	{
		$query = "SELECT * FROM user_details WHERE email='$email' AND verify_key != 'Yes' ";
		$result = mysqli_query($con, $query);
		$check = mysqli_num_rows($result);
		$result = mysqli_fetch_array($result);
		if($check == 1)
		{
			echo "<script>window.open('../index.php?action=noverify','_self');</script>";
		}
		else
			echo "<script>alert('Invalid Credentials.');window.open('../index.php?action=invalid','_self');</script>";
	}
}
else
{
	header('Location: ../logout.php');
}

?>