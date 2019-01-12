
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
<?php
	if(!isset($_SESSION['uid']))
		echo "<script>alert('Access Denied');window.location='../index.php';</script>";
	$db=mysqli_connect("localhost","root","","spandan_music");
	$uid=$_SESSION['uid'];
	// $uid=1;
	$query="SELECT * FROM user_song_map WHERE uid='$uid' ORDER BY album_id DESC LIMIT 4";
	$result=mysqli_query($db,$query);
	$nrow=mysqli_num_rows($result);
	echo "<div class='row '><h2><strong>My songs</strong><a href='all_songs_fetch.php'><button class='btn btn-default' style='background-color:#e22727;'>
             See all <i class='glyphicon glyphicon-th'></i>
          </button></a></h2><hr>";
	for($i=1;$i<=min(4,$nrow);$i++)
	{
		$row=mysqli_fetch_array($result);
		$song_id=$row['song_id'];
		$album_id = $row['album_id'];
		$is_private = $row['is_private'];
		$query1 = "SELECT * FROM album_details WHERE uid='$uid' AND album_id='$album_id'";
		$res1 = mysqli_query($db, $query1);
		$row1 = mysqli_fetch_array($res1);
		$album_art = $row1['album_art'];
		$song_name=$row['custom_name'];
	?>

		<div class='col-md-3 col-sm-6 ' >
			<div class="card" style="padding: 10px;">
	  	<img src='images/album_art/<?php echo $album_art;?>' style='width:100%; height:200px;' class="img-responsive">
	  	<p class='title'><?php echo substr($song_name,0,15); ?>...</p>
	  	
	  	<button class='btn btn-default' data-toggle="tooltip" data-placement="top" title="Play Song" onclick="call_to_start('<?php echo $song_id; ?>','<?php echo $song_name; ?>')" style='background-color:#e22727;'>
            <i class='glyphicon glyphicon-music'></i>
          </button>
          <a href='download.php?file=songs/<?php echo $song_id ?>.mp3' ><button data-toggle="tooltip" data-placement="top" title="Download" class='btn btn-default' style='background-color:#e22727;'>
            <i class='glyphicon glyphicon-download'></i>
          </button></a>
          <button class='btn btn-default' style='background-color:#e22727;' class="w3-bar-item w3-button"  data-toggle="modal" data-target="#Rename5" onclick="send_id_to_modala5('<?php echo $song_id; ?>')" id="rename_butt5">
            <i class='glyphicon glyphicon-pencil' data-toggle="tooltip" data-placement="top" title="Rename"></i>
          </button>
          <a href='make_a_queue.php?song_id=<?php echo $song_id ?>' ><button data-toggle="tooltip" data-placement="top" title="Add to queue" class='btn btn-default' style='background-color:#e22727;'>
            <i class='glyphicon glyphicon-plus'></i>
          </button></a>
          <?php
          if($is_private == 1)
          {
          		echo "<a href='check_private.php?song_id=".$song_id."&p=0'><button class='btn btn-default' style='background-color:#0CC100;' class='w3-bar-item w3-button' data-toggle='tooltip' data-placement='bottom' title='Remove from private' >
            <i class='fa fa-user-secret'></i>
          	</button></a>";
          }
          else
          {
          		echo "<a href='check_private.php?song_id=".$song_id."&p=0'><button class='btn btn-default' style='background-color:#e22727;' class='w3-bar-item w3-button' data-toggle='tooltip' data-placement='bottom' title='Make private' >
            <i class='fa fa-user-secret'></i>
          	</button></a>";
          }
          ?><button class='btn btn-default' style='background-color:#e22727;' onclick="delete_confirm(<?php echo $song_id; ?>, '<?php echo $song_name; ?>')" data-toggle='tooltip' data-placement='bottom' title='Delete Song'>
            <i class='glyphicon glyphicon-trash'></i>
          </button>
		</div>
	</div>
	<?php
	}
	echo "</div><hr>";   

?>

<div class="modal fade" id="Rename5" tabindex="-1" role="dialog" aria-labelledby="Modal" aria-hidden="true" >
  <div class="modal-dialog" role="document">
    <div class="modal-content" style="background-color: #191919; color:white;">
      <div class="modal-header">
        <h3 class="modal-title" id="exampleModalLongTitle5">Rename</h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      		<div class="panel-body">
						<div class="row">
							<div class="col-lg-12">
								<form id="login-form5" action="rename.php" method="get" role="form" style="display: block;" enctype="multipart/form-data">
									<input type="text" name="song_id" id="song_id_abcd5" value="" tabindex="1" class="form-control" style="display: none;">
									<div class="form-group">
										<input type="text" name="rename" id="rename_name5" tabindex="2" class="form-control" placeholder="Name you want">
									</div>
								
									<div class="form-group">
										<div class="row">
											<div class="col-sm-6 col-sm-offset-3">
												<input type="submit" id="rename5" tabindex="4" class="form-control btn btn-login" value="Rename" style="background-color:#e22727">
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
<script>
	function send_id_to_modala5(aid){
		$("#song_id_abcd5").attr("value",aid);
	}

	function delete_confirm(song_id, song_name)
	{
		var r = confirm("Are you sure you want to delete "+song_name+" ?");
		if(r == true)
		{
			window.location='delete_song.php?song_id='+song_id+'&p=0';
		}
	}

</script>
<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip(); 
});
</script>