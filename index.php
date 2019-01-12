
<?php
session_start();
if(isset($_SESSION['uid']))
{
	header("Location: dashboard.php");
	die();
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Spandan Music</title>
        <script src="include/jquery-2.1.4.min.js"></script>

        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="css/bootstrap-social.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        <link rel="icon" href="images/MNNIT1.ico" />
        <link href="https://fonts.googleapis.com/css?family=Graduate|Roboto+Condensed|Yanone+Kaffeesatz" rel="stylesheet">


        <link rel="stylesheet" type="text/css" href="include/lv-ripple.css">
        <link rel="stylesheet" type="text/css" href="include/style.css">
        <link rel="stylesheet" type="text/css" href="main.css" >

<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="fb.js"></script>
<style>

.panel-login {
	border-color: #ccc;
	-webkit-box-shadow: 0px 2px 3px 0px rgba(0,0,0,0.2);
	-moz-box-shadow: 0px 2px 3px 0px rgba(0,0,0,0.2);
	box-shadow: 0px 2px 3px 0px rgba(0,0,0,0.2);
}
.panel-login>.panel-heading {
	color: #00415d;
	background-color: #fff;
	border-color: #fff;
	text-align:center;
}
.panel-login>.panel-heading a{
	text-decoration: none;
	color: #666;
	font-weight: bold;
	font-size: 15px;
	-webkit-transition: all 0.1s linear;
	-moz-transition: all 0.1s linear;
	transition: all 0.1s linear;
}
.panel-login>.panel-heading a.active{
	color: #e22727;
	font-size: 25px;
}

.panel-login>.panel-heading hr{
	margin-top: 10px;
	margin-bottom: 0px;
	clear: both;
	border: 0;
	height: 1px;
	background-image: -webkit-linear-gradient(left,rgba(0, 0, 0, 0),rgba(0, 0, 0, 0.15),rgba(0, 0, 0, 0));
	background-image: -moz-linear-gradient(left,rgba(0,0,0,0),rgba(0,0,0,0.15),rgba(0,0,0,0));
	background-image: -ms-linear-gradient(left,rgba(0,0,0,0),rgba(0,0,0,0.15),rgba(0,0,0,0));
	background-image: -o-linear-gradient(left,rgba(0,0,0,0),rgba(0,0,0,0.15),rgba(0,0,0,0));
}
.panel-login input[type="text"],.panel-login input[type="email"],.panel-login input[type="password"] {
	height: 45px;
	border: 1px solid #ddd;
	font-size: 16px;
	-webkit-transition: all 0.1s linear;
	-moz-transition: all 0.1s linear;
	transition: all 0.1s linear;
}
.panel-login input:hover,
.panel-login input:focus {
	outline:none;
	-webkit-box-shadow: none;
	-moz-box-shadow: none;
	box-shadow: none;
	border-color: #ccc;
}
.btn-login {
	background-color: #59B2E0;
	outline: none;
	color: #fff;
	font-size: 14px;
	height: auto;
	font-weight: normal;
	padding: 14px 0;
	text-transform: uppercase;
	border-color: #59B2E6;
}
.btn-login:hover,
.btn-login:focus {
	color: #fff;
	background-color: #53A3CD;
	border-color: #53A3CD;
}
.forgot-password {
	text-decoration: underline;
	color: #888;
}
.forgot-password:hover,
.forgot-password:focus {
	text-decoration: underline;
	color: #666;
}

.btn-register {
	background-color: #1CB94E;
	outline: none;
	color: #fff;
	font-size: 14px;
	height: auto;
	font-weight: normal;
	padding: 14px 0;
	text-transform: uppercase;
	border-color: #1CB94A;
}
.btn-register:hover,
.btn-register:focus {
	color: #fff;
	background-color: #1CA347;
	border-color: #1CA347;
}


</style>
<script src='https://www.google.com/recaptcha/api.js'></script>
</head>

<body style="background-color: #F9F9F9">
	<div style="background:#191919 !important; padding: 20px 15px;" class="jumbotron">
    <h1 style="text-align: center; color: #EEEEEE">Spandan Music<i class="fa fa-music"></i></h1>
</div>

<div class="container" style="padding: 25px;">
    	<div class="row">
    		
			<div class="col-md-6 col-md-offset-3">
				<?php
    		if(isset($_GET['action'])){

					//check the action
					switch ($_GET['action']) {
						case 'noverify':
							echo "<h3 style='text-align:center;' class='bg-success'>Account is not verified. Check inbox.</h3>";
							break;
						case 'invalid':
							echo "<h3 style='text-align:center;' class='bg-success'>Invalid Credentials.</h3>";
							break;	
						case 'joined':
							echo "<h3 style='text-align:center;' class='bg-success'>Registration successful. Verification Email sent. Please check inbox.</h3>";
							break;
						case 'active':
							echo "<h3 style='text-align:center;' class='bg-success'>Your account is now active you may now log in.</h3>";
							break;
						case 'reset':
							echo "<h3 style='text-align:center;' class='bg-success'>Please check your inbox for a reset link.</h3>";
							break;
						case 'resetAccount':
							echo "<h3 style='text-align:center;' class='bg-success'>Password changed, you may now login.</h3>";
							break;
					}

				}
				?>
				<div class="panel panel-login">
					<div class="panel-heading">
						<div class="row">
							<div class="col-xs-6 login-active">
								<a href="#" class="active" id="login-form-link">Login</a>
							</div>
							<div class="col-xs-6">
								<a href="#" id="register-form-link">Register</a>
							</div>
						</div>
						<hr>
					</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-lg-12">
								<form id="login-form" action="backend/login_backend.php" method="post" role="form" style="display: block;">
									<div class="form-group">
										<input type="email" name="email" id="email" tabindex="1" class="form-control" placeholder="E-mail ID" value="" required>
									</div>
									<div class="form-group">
										<input type="password" name="password" id="password" tabindex="2" class="form-control" placeholder="Password" required>
									</div>
									
									<div class="form-group">
										<div class="row">
											<div class="col-sm-6 col-sm-offset-3">
												<input type="submit" name="login-submit" id="login-submit" tabindex="4" class="form-control btn btn-login" value="Log In" style="background-color:#e22727">
											</div>
										</div>
									</div>
									<div class="form-group">
										<div class="row">
											<div class="col-lg-12">
												<div class="text-center">
													<a href="reset.php" tabindex="5" class="forgot-password">Forgot Password?</a>
												</div>
												<div class="col-md-3"></div><div class="col-md-6" style="text-align: center; margin-top: 10px;">
												<a href="fb.php" class="btn btn-block btn-social btn-facebook">
												  <span class="fa fa-facebook"></span>
												  Log in with facebook
												</a></div>
											</div>

												
											<!-- <a href="fb.php"><span class="fa fa-fb"><button>Log In</button></span></a> -->

										</div>
									</div>
								</form>
								
								<form id="register-form" action="backend/register_backend.php" method="post" role="form" style="display: none;">
									<div class="form-group">
										<input type="text" name="name" id="name" tabindex="1" class="form-control" placeholder="Name" value="" required>
									</div>
									<div class="form-group">
										<input type="email" name="email" id="email" tabindex="2" class="form-control" placeholder="Email Address" value="" required>
									</div>
									<div class="form-group">
										<input type="password" name="password" id="password" tabindex="3" class="form-control" placeholder="Password" required>
									</div>
									<div class="form-group">
										<input type="password" name="confirm-password" id="confirm-password" tabindex="4" class="form-control" placeholder="Confirm Password" required>
									</div><center>
									<div class="form-group" >
									<div class="g-recaptcha" data-sitekey="6LcqOG0UAAAAACozY8_9IlmGyDy_u4k7ddjVx_co"></div>
									</div></center>
									<div class="form-group">
										<div class="row">
											<div class="col-sm-6 col-sm-offset-3">
												<input type="submit" name="register-submit" id="register-submit" tabindex="4" class="form-control btn btn-register" value="Register Now" style="background-color: #e22727">
											</div>
										</div>
									</div>

									
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<footer class="well col-sm-12" style="margin:0px; padding:18px;margin-top:12px; background-color: #D7D9DA;">
        <p class="small" style="margin-bottom:0px; font-size: 20px;" align="center">&copy; Spandan Music <br />
                </p>
</footer>
</body>
<script>
	$(function() {

    $('#login-form-link').click(function(e) {
		$("#login-form").delay(100).fadeIn(100);
 		$("#register-form").fadeOut(100);
		$('#register-form-link').removeClass('active');
		$(this).addClass('active');
		e.preventDefault();
	});
	$('#register-form-link').click(function(e) {
		$("#register-form").delay(100).fadeIn(100);
 		$("#login-form").fadeOut(100);
		$('#login-form-link').removeClass('active');
		$(this).addClass('active');
		e.preventDefault();
	});

});


</script>
</html>