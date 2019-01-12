<?php

include('includes/connection.php');
	if(!isset($_SESSION['uid']))
		echo "<script>alert('Access Denied');window.location='../index.php';</script>";
	$db=mysqli_connect("localhost","root","","spandan_music");
	$uid=$_GET['profile_id'];
	$my_sess_id = $_SESSION['uid'];
	// $uid=1;
	$query="SELECT * FROM user_song_map WHERE uid='$uid' and is_private='0' ORDER BY album_id DESC ";
	$result=mysqli_query($db,$query);
	$nrow=mysqli_num_rows($result);
	// echo "<div class='row '><h2><strong>My songs</strong></h2><hr>";
	echo "<div class='col-md-12 container ' id='main_songs_heads'><div class='row'><hr><div class='col-md-7'><h2><strong>Songs</strong></h2></div><div class='col-md-5'><input id='myInputs' type='text' class='form-control' placeholder='Search Songs' style='margin-top:10px;'></div></div><hr>";
	for($i=1;$i<=$nrow;$i++)
	{
		$row=mysqli_fetch_array($result);
		$song_id=$row['song_id'];
		$album_id = $row['album_id'];
		$query1 = "SELECT * FROM album_details WHERE uid='$uid' AND album_id='$album_id'";
		$res1 = mysqli_query($db, $query1);
		$row1 = mysqli_fetch_array($res1);
		$album_art = $row1['album_art'];
		// $song_name=$row['custom_name'];
		$qr = "SELECT song_name FROM song_details WHERE song_id='$song_id'";
		$rq = mysqli_query($con, $qr);
		$rg = mysqli_fetch_array($rq);
		$song_name = $rg['song_name'];
	?>

		<div class='col-md-3 col-sm-6'  id="song_cards" style="margin-bottom: 10px;">
			<div class="card" style="padding:10px;">
	  	<img src='images/album_art/<?php echo $album_art;?>' style='width:100%; height:200px' class="img-responsive">
	  	<p class='title'><?php echo substr($song_name,0,15); ?></p>
	  	<button class='btn btn-default' onclick="call_to_start('<?php echo $song_id; ?>','<?php echo $song_name; ?>')" style='background-color:#e22727;' data-toggle="tooltip" data-placement="top" title="Play this song">
            <i class='glyphicon glyphicon-music'></i>
          </button>
          
          <button class='btn btn-default' style='background-color:#e22727;' class="w3-bar-item w3-button"  data-toggle="modal" data-target="#import" onclick="send_id_to_modal('<?php echo $song_id; ?>')" id="import_button" data-placement="top" title="Import">
            <i data-placement="top" title="Import" data-toggle="tooltip" class='glyphicon glyphicon-share-alt'></i>
          </button>
		</div>
	</div>
	<?php
	}
	echo "</div><hr>";   

?>

<script>
$(document).ready(function(){
  $("#myInputs").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#main_songs_heads #song_cards").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});
</script>
<!-- Modal for rename-->
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
									<input type="text" name="song_id" id="song_id_abc" value="" tabindex="1" class="form-control" style="display: none;">
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
									  	$query = "SELECT * FROM `album_details` WHERE uid='$my_sess_id'";
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
												<input type="submit" name="import" id="import" tabindex="4" class="form-control btn btn-login" value="import" style="background-color:#e22727">
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
<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip(); 
});
</script>
