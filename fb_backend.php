<?php

	session_start();
	include('includes/connection.php');
	$email = $_POST['arguments'][0];
	$name = $_POST['arguments'][1];

	//checking if email already exists
	$query="SELECT * FROM user_details WHERE email LIKE '$email'";
	$res=mysqli_query($con,$query);

	if(mysqli_num_rows($res) == 0)
	{
		//user doesnt exists
		$query="INSERT into user_details (name,email,reg_date,last_login,verify_key) values ('$name','$email',NOW(),NOW(),'Yes')";
		mysqli_query($con,$query);
	}
	
	$query="SELECT * FROM user_details WHERE email LIKE '$email'";
	$res=mysqli_query($con,$query);
	$arr=mysqli_fetch_array($res);
	$uid=$arr['uid'];
	$_SESSION['uid']=$uid;

?>