<?php 
session_start();
include('../includes/connection.php');
if(isset($_SESSION['uid']))
{
	header('Location: dashboard.php');
	die();
}
if(isset($_POST['register-submit']))
{
		// Captcha verification start
		if(isset($_POST['g-recaptcha-response']))
          $captcha=$_POST['g-recaptcha-response'];
        if(!$captcha){
          echo '<h2>Please check the the captcha form.</h2>';
        }
        $response=json_decode(file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=6LcqOG0UAAAAAO3qdyTF1V2V4gw5CRRP7foGxEcM&response=".$captcha), true);
        if($response['success'] == false)
        {
          	echo "<script>alert('Captcha verification invalid.');window.open('../index.php','_self');</script>";
          	die();
        }
        //Captcha verification end

		$name = mysqli_real_escape_string($con, $_POST['name']);
		$pass = mysqli_real_escape_string($con, $_POST['password']);
		$conf_pass = mysqli_real_escape_string($con, $_POST['confirm-password']);
		$email = mysqli_real_escape_string($con, $_POST['email']);
		$verify_key = md5(uniqid(rand(),true));
		$get_email = "SELECT * FROM user_details WHERE email='$email' ";
		$run_email = mysqli_query($con, $get_email);
		$check = mysqli_num_rows($run_email);
		if($check >= 1)
		{
			echo "<script>alert('This email is already registered. Please login!');window.open('../index.php','_self');</script>";
		}
		else if($pass != $conf_pass)
		{
			echo "<script>alert('Passwords do not match.');window.open('../index.php','_self');</script>";	
		}
		else if(strlen($name)>50)
		{
			echo "<script>alert('Name is not valid.');window.open('../index.php','_self');</script>";
		}
		else if(strlen($pass)<8)
		{
			echo "<script>alert('Password should be greater than 8 characters.');window.open('../index.php','_self');</script>";
		}
		else
		{
			$pass = md5(md5($email).md5($pass));
			$insert = "INSERT into user_details (name, pass, email, verify_key, reg_date, last_login) values ('$name', '$pass', '$email', '$verify_key', NOW(), NOW() ) ";
			$run_insert = mysqli_query($con, $insert);
			if($run_insert)
			{
				$query = "SELECT uid FROM user_details WHERE email='$email' ";
				$result = mysqli_query($con, $query);
				$result = mysqli_fetch_array($result);
				// $_SESSION['uid']=$result['uid'];
				// echo "<script>alert('Registration successful');</script>";
				$id = $result['uid'];
				$server_name_curr=$_SERVER['SERVER_NAME'];
				$verify_link = $server_name_curr."/music/activate.php?x=$id&y=$verify_key";
				$to = strtolower($email);
				$subject = "Verify your email to complete registration.";
				$body = '<html><head></head><body><a href='.$verify_link.' style="text-decoration:none;padding:10px 20px;background-color:#4b9e60;color:white;border-radius:5px">Click here to activate your account</a></body></html>';
				$altbody = 'Thank you for registering with us. Click the link to activate your account.';
				include("../send-mail.php");
				header('Location: ../index.php?action=joined');
				exit;
			}
		}
}

?>
