<?php
	
	session_start();
	$server_name_curr = $_SERVER['SERVER_NAME'];
	if($server_name_curr == "localhost")
	{
		$server_name_curr = "127.0.0.1";
	}
	$value=$_SESSION['omega'];
	$fb_share_link="https://www.facebook.com/sharer/sharer.php?kid_directed_site=0&sdk=joey&u=https%3A%2F%2F".$server_name_curr."%2Fmusic%2Fdownload.php%3Ffile%3Dsongs%252F".$value.".mp3&display=popup&ref=plugin&src=share_button";
	echo $fb_share_link;
	header("Location: $fb_share_link");

?>