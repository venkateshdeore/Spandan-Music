<?php 
session_start();
require('play_the_queue.php');
include('includes/connection.php');
if(!isset($_SESSION['uid']))
{
  header("Location: index.php");
  die();
}
$uid=$_SESSION['uid'];
?>
<!DOCTYPE html>
<html>
<head>
<title>Music</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
      <?php include('local_headers.php');?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"> -->
        <!--  <script type="text/javascript" src="player.js"></script> -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
	<link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-blue-grey.css">
	<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Open+Sans'>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="css/dashboardstyles.css">
  <link rel="stylesheet" type="text/css" href="css/styles.css">
</head>
<body>
  <div id="fb-root"></div>
    <script>(function(d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return;
      js = d.createElement(s); js.id = id;
      js.src = 'https://connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v3.1&appId=427797701081305&autoLogAppEvents=1';
      fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>
    <!-- HEADER -->

    <?php include 'includes/header.php' ?>
    <!-- HEADER -->
    <div class="row">
    <!-- Beginning of side menu-->
    <div class="col-md-2 backcolor" style="margin-top:51px;">
    <div class=" w3-sidebar w3-bar-block w3-card w3-animate-left" style="background-color:rgb(35,35,35); color:white; padding:5px;" id="leftMenu">
      <button onclick="closeLeftMenu()" class="w3-bar-item w3-button w3-large" id="close">Close &times;</button>
      <a href="dashboard.php" class="w3-bar-item w3-button" style="text-decoration:none;" id="active1"><i class="iconmenu fa fa-home" style="color:red;"></i>  &nbsp;   Home</a>
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
      <a href="edit_the_queue.php" class="w3-bar-item w3-button" style="text-decoration:none;"><i class="iconmenu fa fa-edit"></i> &nbsp;   Edit Queue</a>
    </div>
     <div class="w3-teal" id="collapse-button">
      <button class="w3-button w3-teal w3-xlarge w3-left" onclick="openLeftMenu()">&#9776;</button>
    </div>
</div>
    <!--End of side bar -->

    <!-- Beginning of middle part -->
    <div class="col-md-9 backcolor container" style="margin-top:51px; padding:20px;">
        <!-- Caraousel -->
        <div class="" id="modal_song_id">
      <div id="myCarousel" class="carousel slide" data-ride="carousel">
        <!-- Indicators -->
        <ol class="carousel-indicators">
          <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
          <li data-target="#myCarousel" data-slide-to="1"></li>
          <li data-target="#myCarousel" data-slide-to="2"></li>
        </ol>

        <!-- Wrapper for slides -->
        <div class="carousel-inner">

          <div class="item active">
            <img src="images/eminem.jpg" alt="song" style="width:100%; ">
          </div>

          <div class="item">
            <img src="images/aleeso.jpg" alt="song" style="width:100%; ">
          </div>
        
          <div class="item">
            <img src="images/queen.jpg" alt="song" style="width:100%; ">
          </div>
      
        </div>

        <!-- Left and right controls -->
        <a class="left carousel-control" href="#myCarousel" data-slide="prev">
          <span class="glyphicon glyphicon-chevron-left"></span>
          <span class="sr-only">Previous</span>
        </a>
        <a class="right carousel-control" href="#myCarousel" data-slide="next">
          <span class="glyphicon glyphicon-chevron-right"></span>
          <span class="sr-only">Next</span>
        </a>
      </div>
       </div>
      <!-- Caraousel end -->
      <hr>
      <div style="padding:10px;">
      <?php include 'album_fetch.php' ?>
      </div>
      <hr>
      <div style="padding:10px;">
      <?php include 'song_fetch.php' ?>
      </div>
      <hr>
      <div style="padding:10px;">
      <?php include 'recommend_songs.php' ?>
      </div><br><br><br>
      <br>
      <hr>
    </div>
   
    <!-- End of middle part -->


    <!-- Beginning of right bar -->
    <div class="col-md-1">
    </div>
    <!--End of right bar -->
    </div>
    <div style="height:50px;"></div>
    <div class="row " style="height:50px;bottom:0; position:fixed; width:100%;">
      <div class="col-md-2"></div>
      <div class="col-md-9">
      <?php include 'playersing.php' ?>
      </div>
      <div class="col-md-1"></div>
    </div>
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