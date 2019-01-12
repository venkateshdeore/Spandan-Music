<?php   
include('includes/connection.php');
session_start();
// error_reporting(0);
if(!isset($_SESSION['uid']))
{
	echo "<script>alert('Login to download the song.');window.open('logout.php', '_self')</script>";
	die();
}
$uid = $_SESSION['uid'];
if (isset($_GET['file'])) { 

	$song_id = $_GET['file'];
	$song_id = substr($song_id, 6, strlen($song_id)-10);
	$query = "SELECT * FROM user_song_map WHERE uid='$uid' and song_id='$song_id'";
	$result = mysqli_query($con, $query);
	if(mysqli_num_rows($result)==0)
	{
		header('Location: logout.php');
		die();
	}
    $file = $_GET['file'] ;
        if (file_exists($file) && is_readable($file) && preg_match('/\.mp3$/',$file))  { 
            header('Content-type: application/mp3');  
            header("Content-Disposition: attachment; filename=\"$file\"");   
            readfile($file); 
        } 
    } 
else 
{ 
    // header("HTTP/1.0 404 Not Found"); 
    echo "<h1>Error 404: File Not Found <br /></h1>"; 
}
?>