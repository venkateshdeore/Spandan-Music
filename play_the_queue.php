<?php
include('includes/connection.php');
if(!isset($_SESSION['uid']))
{
	header('Location:logout.php');
	die();	
}
$uid=$_SESSION['uid'];
$query="SELECT * FROM user_details WHERE uid='$uid'";
$result=mysqli_query($con,$query);
$row=mysqli_fetch_array($result);
$has_queue=$row['has_queue'];
// if($has_queue==0)
// {
// 	echo "<script>alert('No song in queue');window.location='dashboard.php';</script>";
// 	die();
// }
$query1="SELECT * FROM queue_details WHERE queue_id='$uid'";
$result1=mysqli_query($con,$query1);
$song_id_queue_list=array();
$song_name_queue_list=array();
while($row1=mysqli_fetch_array($result1))
		{
			$song_id=$row1['song_id'];
			$query2="SELECT * FROM user_song_map WHERE uid='$uid' AND song_id='$song_id'";
			$result2=mysqli_query($con,$query2);
			$row2=mysqli_fetch_array($result2);
			array_push($song_id_queue_list,(int)$row1['song_id']);
			array_push($song_name_queue_list,$row2['custom_name']);
		}

?>