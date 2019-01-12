<?php 
session_start();
if(!isset($_SESSION['uid']))
{
  header("Location: index.php");
  die();
}
require('play_the_queue.php');
include('includes/connection.php');
$uid=$_SESSION['uid'];
$q = "UPDATE `user_details` SET `msg_notification`='0' WHERE uid = '$uid' ";
$r = mysqli_query($con, $q);
?>
<!DOCTYPE html>
<html>
<head>
<title>Spandan Music</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"> -->
        <!--  <script type="text/javascript" src="player.js"></script> -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
	<link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-blue-grey.css">
	<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Open+Sans'>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <?php include('local_headers.php');?>
	<link rel="stylesheet" type="text/css" href="css/dashboardstyles.css">
  <link rel="stylesheet" type="text/css" href="css/styles.css">
</head>
<body>
    <!-- HEADER -->

    <?php include 'includes/header.php' ?>
    <!-- HEADER -->

    <!-- Beginning of side menu-->
    <div class="col-md-2 backcolor" style="margin-top:51px; padding:0px;">
    <div class=" w3-sidebar w3-bar-block w3-card w3-animate-left" style="background-color:rgb(35,35,35); color:white; padding:5px;" id="leftMenu">
      <button onclick="closeLeftMenu()" class="w3-bar-item w3-button w3-large" id="close">Close &times;</button>
      <a href="dashboard.php" class="w3-bar-item w3-button" style="text-decoration:none;" ><i class="iconmenu fa fa-home" ></i>  &nbsp;   Home</a>
      <?php echo "<a class='w3-bar-item w3-button' style='text-decoration:none;' onclick='call_to_start_playlist(".json_encode($song_id_queue_list).",".json_encode($song_name_queue_list).")'>"; ?> <i class="iconmenu fa fa-play" ></i>  &nbsp;    Play the queue</a>
      <a href="all_songs_fetch.php" class="w3-bar-item w3-button" style="text-decoration:none;"><i class="iconmenu fa fa-music"></i>  &nbsp;    My songs</a><hr>
      <div style="padding:5px; color:grey;">OPTIONS</div>
      <a href="#" class="w3-bar-item w3-button"  data-toggle="modal" data-target="#Modal3"  style="text-decoration:none;"><i class="iconmenu fa fa-upload"></i> &nbsp;  Upload</a>
      <a href="all_albums_fetch.php" class="w3-bar-item w3-button"  style="text-decoration:none;"><i class="iconmenu fa fa-book"></i> &nbsp;   Albums</a>
      
          <a href="chat.php" class="w3-bar-item w3-button" style="text-decoration:none;" id="active1"><i style="color:red;" class="iconmenu fa fa-edit"></i> &nbsp;Chat</a>
    
      <a href="edit_the_queue.php" class="w3-bar-item w3-button" style="text-decoration:none;"><i class="iconmenu fa fa-edit"></i> &nbsp;   Edit Queue</a>
    </div>
     <div class="w3-teal" id="collapse-button">
      <button class="w3-button w3-teal w3-xlarge w3-left" onclick="openLeftMenu()">&#9776;</button>
    </div>
</div>







    <div class="col-md-8" >
    <div class='container card' style="background-color:white; overflow:scroll; width:100%; height:500px; border-radius:10px; margin-top:60px;">
<div class='row' style='padding:10px;'>
  <?php
    $query = "SELECT * FROM `messages` WHERE 1";
    $result = mysqli_query($con, $query);
    while($row=mysqli_fetch_array($result))
    {
      $sender_id=$row['sender_id'];
      $q = "SELECT name FROM `user_details` WHERE uid='$sender_id' ";
      $r = mysqli_query($con, $q);
      $r = mysqli_fetch_array($r);
      $name = $r['name'];
      $msg_content=$row['message'];
      $date=$row['msg_time'];
      if($uid==$sender_id)
      {
        echo"
        <div class='container' style='width:100%; padding:0;'>
        <div class='well' style='width:60%; float:right; background-color:#4d636f; color:white;padding:5px; padding-bottom:0;padding-left:10px;margin-bottom:8px;'>
        <p style='font-size:19px; text-align:left;'>$msg_content</p>
        <p style='font-size:13px; float:right;'>$date</p>
        </div>
        </div>
        ";
      }
      else
      {
        echo"
        <div class='container' style='width:100%; padding:0;'>
        <div class='well' style='width:60%; float:left;padding:5px; padding-left:20px;margin-bottom:8px;'>
        <div style='font-size:15px; float:left;font-weight:bold;'>$name</div>
        <div style='font-size:13px; float:right;'>$date</div>
        <br>
        <p style='font-size:19px; float:left;'>$msg_content</p>
        </div>
        </div>
        ";
      }
    }



?>
</div>
</div>
<form action="backend/send_msg.php" method="post" id="send_msg">
<div class="form-group" style="width: 100%;">
  <input type="text" class="form-control form-group" placeholder="Send a message" name="message">
    <button class="btn btn-md btn-primary" type="submit" style="float: right;" name="send-msg">Send</button>
</div>
</form>
</div>

    <!-- Beginning of right bar -->
    <div class=" col-md-2 backcolor" >
    
    <!--End of right bar -->
    <script>
    function openLeftMenu() {
        document.getElementById("leftMenu").style.display = "block";
    }
    function closeLeftMenu() {
        document.getElementById("leftMenu").style.display = "none";
    }
    function openRightMenu() {
        document.getElementById("rightMenu").style.display = "block";
    }
    function closeRightMenu() {
        document.getElementById("rightMenu").style.display = "none";
    }
    </script>
               
    <!-- End of side menu -->

       
    </div>

</body>
</html>