<?php 
session_start();
if(!isset($_SESSION['uid']))
{
  header("Location: logout.php");
  die();
}
include('includes/connection.php');
$uid=$_SESSION['uid'];
if(!isset($_GET['album_id'])||!isset($_GET['album_name']) || $_GET['album_id']=="" || $_GET['album_name']=="")
  {
    header("Location: logout.php");
    die();
  }
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
    <?php


  $album_id=$_GET['album_id'];
  $query1="SELECT * FROM user_song_map WHERE album_id='$album_id' AND uid='$uid'";
  $result1=mysqli_query($con,$query1);
  $query2="SELECT * FROM album_details WHERE album_id='$album_id' AND uid='$uid'";
  $result2=mysqli_query($con,$query2);
  $album_name=$_GET['album_name'];
  if(mysqli_num_rows($result2)==0)
  {
      header('Location: dashboard.php');
  }
  $qr = "SELECT * FROM album_details WHERE album_id='$album_id' AND album_name='$album_name' AND uid='$uid'";
  $rq = mysqli_query($con, $qr);
  if(mysqli_num_rows($rq) == 0)
  {
      header('Location: dashboard.php');
  }

?>

    <?php include 'includes/header.php' ?>
    <!-- HEADER -->
    <div class="row">
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
      <h3 style='background-color:black; padding:15px; border-radius:5px;margin-top: 60px; color:white; text-align: center;'><strong><?php echo $album_name; ?></strong></h3>
    <div class='container card' style='overflow:scroll;background-color:white; padding:6px; height:560px; width:100%; margin-top: 0px;border-radius: 5px;'>

<?php
		          
            while($row = mysqli_fetch_array($result1))
            {
              $song_id=$row['song_id'];
              $song_name=$row['custom_name'];
              echo "<div class='well container' style='width:100%; padding: 10px;'>
             <h3 class='display-3' style='float: left;margin-left: 20px;'> <span class='glyphicon glyphicon-music' style='margin-right: 15px;'></span><b>".$row['custom_name']."</b> </h3>
              <a href='#' data-toggle='modal' data-target='#modify'><button type='button' style='background-color:black; color:white; border-radius:5px; float:right; margin-right: 50px;margin-top: 10px;' onclick='send_id_to_modal(".$song_id.")' id='modify_butt'><i class='fa fa-comment'></i>Modify Album</button></a>
              </div>";
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

       
<div class="modal fade" id="modify" tabindex="-1" role="dialog" aria-labelledby="Modal" aria-hidden="true" >
  <div class="modal-dialog" role="document">
    <div class="modal-content" style="background-color: #191919; color:white;">
      <div class="modal-header">
        <h3 class="modal-title" id="exampleModalLongTitle">Modify Album</h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      		<div class="panel-body">
						<div class="row">
							<div class="col-lg-12">
								<form id="login-form" action="modify_album.php" method="post" role="form" style="display: block;" enctype="multipart/form-data">
									
								<fieldset>
										<legend  style="color:white; ">Album:</legend>
										<input type="text" name="song_id" id="song_id_abc" value="" tabindex="1" class="form-control" style="display: none;">
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
									<!-- <h4 style="text-align: center;">---OR---</h4> -->
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
												<input type="submit" name="modify" id="upload" tabindex="4" class="form-control btn btn-login" value="Modify" style="background-color:#e22727">
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

	function send_id_to_modal(aid){
		$("#song_id_abc").attr("value",aid);
	}
</script>
<?php include('song_modal.php') ?>
</body>

</html>