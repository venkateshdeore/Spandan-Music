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
?>
<!DOCTYPE html>
<html>
<head>
<title>Spandan Music</title>
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
  <style>
  input[type='file']{
  color:blue;
  font-size:10px;
}
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
  font-size: 20px;
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
  font-size: 12px;
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
    div.upload {
    width: 157px;
    height: 57px;
    background: url(https://lh6.googleusercontent.com/-dqTIJRTqEAQ/UJaofTQm3hI/AAAAAAAABHo/w7ruR1SOIsA/s157/upload.png);
    overflow: hidden;
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

    <!-- Beginning of side menu-->
    <div class="col-md-2 backcolor"  style="margin-top:51px; padding:0px;">
    <div class=" w3-sidebar w3-bar-block w3-card w3-animate-left" style="background-color:rgb(35,35,35); color:white; padding:5px;" id="leftMenu">
      <button onclick="closeLeftMenu()" class="w3-bar-item w3-button w3-large" id="close">Close &times;</button>
      <a href="dashboard.php" class="w3-bar-item w3-button" style="text-decoration:none;" id="active1"><i class="iconmenu fa fa-home" style="color:red;"></i>  &nbsp;   Home</a>
      
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






	<!-- container -->
    <div class="col-md-8" >
      <h3 style='background-color:black; padding:15px; border-radius:5px;margin-top: 60px; color:white; text-align: center;'><strong>Search results</strong></h3>
    <div class='container card' style='overflow:scroll;background-color:white; padding:6px; height:560px; width:100%; margin-top: 0px;border-radius: 5px;'>

<?php
		// search by user
        if(isset($_GET['search_user']))
        {
          $name = $_GET['search'];
          $name = trim($name);
          $query="SELECT * FROM user_details WHERE name LIKE '%$name%' and uid!='$uid'";
          $res = mysqli_query($con,$query);
            while($array = mysqli_fetch_array($res))
            {
              echo "<div class='well container' style='width:100%; padding: 10px;'>
              <a href='profile.php?profile_id=".$array['uid']."'><h3 class='display-3' style='float: left;margin-left: 20px;'> <span class='glyphicon glyphicon-user' style='margin-right: 15px;'></span><b>".$array['name']."</b> </h3></a>
              <a href='profile.php?profile_id=".$array['uid']."'><button type='button' style='background-color:black; color:white; border-radius:5px; float:right; margin-right: 50px;margin-top: 10px;'><i class='fa fa-comment'></i>Go to profile</button></a>
              </div>";
            }
        }
        // search by song
        else if(isset($_GET['search_song']))
        {
            $song =  $_GET['search'];
            $song = trim($song);
            $query = "SELECT * FROM song_details WHERE song_name LIKE '%$song%'";
            $res = mysqli_query($con,$query);
            // $qabc = "SELECT * FROM user_song_map WHERE ";
            while($array = mysqli_fetch_array($res))
            {
              $sid = $array['song_id'];
              $song_name = $array['song_name'];
              $artist = $array['artist'];
              $genre = $array['genre'];
              // users with the song
              $q = "SELECT * FROM user_song_map WHERE song_id='$sid' and uid!='$uid' and is_private='0'";
              $r = mysqli_query($con, $q);
              
              if(mysqli_num_rows($r)==0)
              {
                  continue;
              }
              echo "<div class='well container' style='width:100%; padding: 5px;'>
              <div class='col-md-6' style='float:left; text-align: left;'>
              <h4 class='display-3' style='margin-left: 15px;'> <span class='glyphicon glyphicon-music' style='margin-right: 15px;'></span><b>".$song_name."</b> </h4>
              <h5 class='display-4' style='margin-left: 15px;'><span class='glyphicon glyphicon-user' style='margin-right: 15px;'></span> <b>".$artist."</b></h5>
              <h5 class='display-4' style='margin-left: 15px;'><span class='glyphicon glyphicon-bookmark' style='margin-right: 15px;'></span><b>".$genre."</b></h5>
              
              <button class='btn btn-default' style='background-color:#e22727;margin-left:100px;' class='w3-bar-item w3-button'  data-toggle='modal' data-target='#import' onclick='send_id_to_modal(".$sid.")' id='import_button'>
            <i class='glyphicon glyphicon-share-alt'></i>
          </button>
              </div>



              <div class='col-md-6'>
              <div class='container card' style='overflow:scroll;background-color:white; padding:4px; height:125px; width:100%; margin-top: 0px;margin-left: 1px;border-radius: 5px;'>
              <p style='background-color:black; padding:2px; border-radius:5px; color:white;'><strong>Users</strong></p>";

              while($data = mysqli_fetch_array($r))
              {
                  $fetch_id = $data['uid'];
                  $myquery = "SELECT name FROM user_details WHERE uid='$fetch_id'";
                  $myres = mysqli_query($con, $myquery);
                  $ans = mysqli_fetch_array($myres);
                  $name = $ans['name'];
                  echo "<div class='well container' style='width:100%; padding:0px;'>
                  <a href='profile.php?profile_id=".$fetch_id."'><p style='float: left;margin-left: 2px;'><b>".$name."</b> </p></a>
                  </div>";
              }
              echo "</div>
              </div></div>";
              
              
            }
        } 

  ?>

        
</div>
</div>

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
    <!-- modal for song upload -->
<div class="modal fade" id="import" tabindex="-1" role="dialog" aria-labelledby="Modal" aria-hidden="true" >
  <div class="modal-dialog" role="document">
    <div class="modal-content" style="background-color: #191919; color:white;">
      <div class="modal-header">
        <h3 class="modal-title" id="exampleModalLongTitle">Import Song</h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <div class="panel-body">
            <div class="row">
              <div class="col-lg-12">
                <form id="login-form" action="song_import.php" method="post" role="form" style="display: block;" enctype="multipart/form-data">
                  <fieldset>
                    <legend style="color:white; ">Song:</legend>
                  <input type="text" name="profile_id"  value="<?php echo $uid; ?>" tabindex="1" class="form-control" style="display: none;"> 
                  <input type="text" name="song_id" id="song_id_abc" value="" tabindex="2" class="form-control" style="display: none;">
                  <div class="form-group">
                    <input type="text" name="rename" id="rename" tabindex="2" class="form-control" placeholder="Name you want">
                  </div>
                </fieldset>
                <fieldset>
                    <legend  style="color:white; ">Album:</legend>
                    <button id="exist_button" type="button" class="btn btn-primary">Existing Album</button>
                    <button id="new_album_button" type="button" class="btn btn-primary">New Album</button><hr>
                  <div class="dropdown" id="exist_album">
                    <select class="btn btn-primary dropdown-toggle" id="album_select" name="album_select">
                        <option value='-1'>Select from previous album</option>
                      <?php
                      include('includes/connection.php');
                      $query = "SELECT * FROM `album_details` WHERE uid='$uid'";
                      $result = mysqli_query($con, $query);
                      while($row = mysqli_fetch_array($result))
                      {
                        echo "<option value=".$row['album_id'].">".$row['album_name']."</option>";
                      }
                      ?>
                    </select>
                  </div>
                  <div id="new_album">
                  <h5>Create New Album</h5>
                  <div class="form-group">
                    <input type="text" name="album_name" id="album_name" tabindex="3" class="form-control" placeholder="New Album Name">
                  </div>
                  <div class="form-group">
                    Album Art:
                    <div class="upload">
                          <input type="file" name="album_art" id="album_art_input"/>
                      </div>
                  </div>
                </div><hr>
                  <div class="form-group">
                    <div class="row">
                      <div class="col-sm-6 col-sm-offset-3">
                        <input type="submit" name="import" id="import" tabindex="4" class="form-control btn btn-login" value="Import" style="background-color:#e22727">
                      </div>
                    </div>
                  </div>
                  </fieldset>
                </form>
                </div>
            </div>
          </div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  $(document).ready(function(){
    $("#exist_album").hide();
    $("#new_album").hide();

    $("#album_select").attr("required", true);
    $("#album_name").attr("required", true);
    $("#album_art_input").attr("required", true);
  })
  $("#exist_button").click(function(){
    $("#exist_album").show();
    $("#new_album").hide();
    $("#album_select").attr("required", true);
    $("#album_name").attr("required", false);
    $("#album_art_input").attr("required", false);
  });
  $("#new_album_button").click(function(){
    $("#exist_album").hide();
    $("#new_album").show();
    $("#album_select").attr("required", false);
    $("#album_name").attr("required", true);
    $("#album_art_input").attr("required", true);
  });
</script>

<script>
  function send_id_to_modal(aid){
    $("#song_id_abc").attr("value",aid);
  }
</script>
</body>

</html>