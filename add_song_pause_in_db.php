<?php
session_start();
include('includes/connection.php');
if(!isset($_SESSION['uid']))
{
	header('Location:index.php');
	die();
}
$uid=$_SESSION['uid'];
if(!isset($_POST['arguments'][0])||!isset($_POST['arguments'][1]))
{
	header('Location:index.php');
	die();
}
$last_paused=$_POST['arguments'][1];
$song_id=$_POST['arguments'][0];
$query="UPDATE user_song_map SET last_paused='$last_paused' WHERE uid='$uid' AND song_id='$song_id'";
mysqli_query($con,$query);

?>
<script type="text/javascript">console.log(10);</script>