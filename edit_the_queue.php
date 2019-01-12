<?php 
session_start();
require('play_the_queue.php');
if(!isset($_SESSION['uid']))
{
  header("Location: logout.php");
  die();
}
include('includes/connection.php');
$uid=$_SESSION['uid'];
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
  <style>
  div.upload {
    width: 157px;
    height: 57px;
    background: url(https://lh6.googleusercontent.com/-dqTIJRTqEAQ/UJaofTQm3hI/AAAAAAAABHo/w7ruR1SOIsA/s157/upload.png);
    /*overflow: hidden;*/
}

div.upload input {
    display: block !important;
    width: 157px !important;
    height: 57px !important;
    opacity: 0 !important;
    overflow: hidden !important;
}
</style>

</head>
<body>
    <!-- HEADER -->

    <?php include 'includes/header.php' ?>
    <!-- HEADER -->
    <div class="row">
    <!-- Beginning of side menu-->
    <div class="col-md-2 backcolor" style="padding:0px;margin-top:51px;">
    <div class=" w3-sidebar w3-bar-block w3-card w3-animate-left" style="background-color:rgb(35,35,35); color:white; padding:5px;" id="leftMenu">
      <button onclick="closeLeftMenu()" class="w3-bar-item w3-button w3-large" id="close">Close &times;</button>
      <a href="dashboard.php" class="w3-bar-item w3-button" style="text-decoration:none;" id=""><i class="iconmenu fa fa-home" ></i>  &nbsp;   Home</a>
      <?php echo "<a class='w3-bar-item w3-button' style='text-decoration:none;' onclick='call_to_start_playlist(".json_encode($song_id_queue_list).",".json_encode($song_name_queue_list).")'>"; ?> <i class="iconmenu fa fa-play" ></i>  &nbsp;    Play the queue</a>
      <a href="all_songs_fetch.php" class="w3-bar-item w3-button" style="text-decoration:none;"><i class="iconmenu fa fa-music"></i>  &nbsp;    My songs</a><hr>
      <div style="padding:5px; color:grey;">OPTIONS</div>
      <a href="#" class="w3-bar-item w3-button"  data-toggle="modal" data-target="#Modal3"  style="text-decoration:none;"><i class="iconmenu fa fa-upload"></i> &nbsp;  Upload</a>
      <a href="all_albums_fetch.php" class="w3-bar-item w3-button"  style="text-decoration:none;"><i class="iconmenu fa fa-book"></i> &nbsp;   Albums</a>
      <?php 
      $query = "SELECT msg_notification FROM `user_details` WHERE uid='$uid'";
      $result = mysqli_query($con, $query);
      $res = mysqli_fetch_array($result);
      $res = $res['msg_notification'];
      if($res == 1)
      {
          echo '<a href="chat.php" class="w3-bar-item w3-button" style="text-decoration:none;background-color:green;" id="msg"><i class="iconmenu fa fa-edit"></i> &nbsp;   Chat</a>';
      }
      else
      {
          echo '<a href="chat.php" class="w3-bar-item w3-button" style="text-decoration:none;" id="msg"><i class="iconmenu fa fa-edit"></i> &nbsp;   Chat</a>';
      }
      ?>
      <a href="edit_the_queue.php" class="w3-bar-item w3-button" style="text-decoration:none;" id="active1" ><i style="color:red;" class="iconmenu fa fa-edit"></i> &nbsp;   Edit Queue</a>
    </div>
     <div class="w3-teal" id="collapse-button">
      <button class="w3-button w3-teal w3-xlarge w3-left" onclick="openLeftMenu()">&#9776;</button>
    </div>
</div>





	<!-- container -->
    <div class="col-md-8" >
      <h3 style='background-color:black; padding:15px; border-radius:5px;margin-top: 60px; color:white; text-align: center;'><strong>Edit Queue</strong></h3>
    <div class='container card' style='overflow:scroll;background-color:white; padding:6px; height:560px; width:100%; margin-top: 0px;border-radius: 5px;'>

      <?php
          $qid = $uid;
          $query = "SELECT * FROM `queue_details` WHERE queue_id='$qid'";
          $result = mysqli_query($con, $query);
          while($row = mysqli_fetch_array($result))
          {
              $song_id = $row['song_id'];
              $qr = "SELECT * FROM `user_song_map` WHERE uid='$uid' AND song_id='$song_id'";
              $rq = mysqli_query($con, $qr);
              $rg = mysqli_fetch_array($rq);
              $song_name = $rg['custom_name'];
              echo "<div class='well container' style='width:100%; padding: 10px;'>
             <h3 class='display-3' style='float: left;margin-left: 20px;'> <span class='glyphicon glyphicon-music' style='margin-right: 15px;'></span><b>".$song_name."</b> </h3><a href='delete_from_queue.php?song_id=".$song_id."'><span style='float:right; margin-right:15px;margin-top:15px;color:red;' class='glyphicon glyphicon-remove' data-toggle='tooltip' data-placement='left' title='Remove from queue'></span></a></div>";
          }
      ?>
        
</div>
</div>

</div>

    <!-- Beginning of right bar -->
    <div class=" col-md-2 backcolor" ></div></div>
   
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

<?php include('song_modal.php') ?>
</body>

</html>