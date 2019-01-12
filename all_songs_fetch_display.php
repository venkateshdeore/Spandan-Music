<?php
	if(!isset($_SESSION['uid']))
		echo "<script>alert('Access Denied');window.location='../index.php';</script>";
	$db=mysqli_connect("localhost","root","","spandan_music");
	$uid=$_SESSION['uid'];
	// $uid=1;
	$query="SELECT * FROM user_song_map WHERE uid='$uid' ORDER BY album_id DESC";
	$result=mysqli_query($db,$query);
	$nrow=mysqli_num_rows($result);
	echo "<div class='col-md-12 container ' id='main_songs_head'><div class='row'><div class='col-md-7'><h2><strong>My songs</strong></h2></div><div class='col-md-5'><input id='myInput' type='text' class='form-control' placeholder='search songs' style='margin-top:15px;'></div></div><hr>";
	for($i=1;$i<=$nrow;$i++)
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

		<div class='col-md-3 col-sm-6' id="song_card" style="margin-bottom: 10px;">
			<div class="card" style="padding: 10px;">
	  	<img src='images/album_art/<?php echo $album_art;?>' style='width:100%; height:200px;' class="img-responsive">
	  	<p class='title'><?php echo substr($song_name,0,15); ?>...</p>
	  	
	  	<button class='btn btn-default' data-toggle="tooltip" data-placement="top" title="Play Song" onclick="call_to_start('<?php echo $song_id; ?>','<?php echo $song_name; ?>')" style='background-color:#e22727;'>
            <i class='glyphicon glyphicon-music'></i>
          </button>
          <a href='download.php?file=songs/<?php echo $song_id ?>.mp3' ><button data-toggle="tooltip" data-placement="top" title="Download" class='btn btn-default' style='background-color:#e22727;'>
            <i class='glyphicon glyphicon-download'></i>
          </button></a>
          <button class='btn btn-default' style='background-color:#e22727;' class="w3-bar-item w3-button"  data-toggle="modal" data-target="#rename" onclick="send_id_to_modala('<?php echo $song_id; ?>')" id="rename_butt">
            <i class='glyphicon glyphicon-pencil' data-toggle="tooltip" data-placement="top" title="Rename"></i>
          </button>
          <a href='make_a_queue.php?song_id=<?php echo $song_id ?>' ><button data-toggle="tooltip" data-placement="top" title="Add to queue" class='btn btn-default' style='background-color:#e22727;'>
            <i class='glyphicon glyphicon-plus'></i>
          </button></a>
          <?php
          if($is_private == 1)
          {
          		echo "<a href='check_private.php?song_id=".$song_id."&p=1'><button class='btn btn-default' style='background-color:#0CC100;' class='w3-bar-item w3-button' data-toggle='tooltip' data-placement='bottom' title='Remove from private' >
            <i class='fa fa-user-secret'></i>
          	</button></a>";
          }
          else
          {
          		echo "<a href='check_private.php?song_id=".$song_id."&p=1'><button class='btn btn-default' style='background-color:#e22727;' class='w3-bar-item w3-button' data-toggle='tooltip' data-placement='bottom' title='Make private' >
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
<!-- for filter -->
<script>
$(document).ready(function(){
  $("#myInput").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#main_songs_head #song_card").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});
</script>
<div class="modal fade" id="rename" tabindex="-1" role="dialog" aria-labelledby="Modal" aria-hidden="true" >
  <div class="modal-dialog" role="document">
    <div class="modal-content" style="background-color: #191919; color:white;">
      <div class="modal-header">
        <h3 class="modal-title" id="exampleModalLongTitle">Rename</h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      		<div class="panel-body">
						<div class="row">
							<div class="col-lg-12">
								<form id="login-form" action="rename.php" method="get" role="form" style="display: block;" enctype="multipart/form-data">
									<input type="text" name="song_id" id="song_id_abc" value="" tabindex="1" class="form-control" style="display: none;">
									<div class="form-group">
										<input type="text" name="rename" id="rename_name" tabindex="2" class="form-control" placeholder="Name you want">
									</div>
								
									<div class="form-group">
										<div class="row">
											<div class="col-sm-6 col-sm-offset-3">
												<input type="submit" id="rename" tabindex="4" class="form-control btn btn-login" value="Rename" style="background-color:#e22727">
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
	function send_id_to_modal(aid){
		$("#song_id_abc").attr("value",aid);
	}
	function delete_confirm(song_id, song_name)
	{
		var r = confirm("Are you sure you want to delete "+song_name+" ?");
		if(r == true)
		{
			window.location='delete_song.php?song_id='+song_id+'&p=1';
		}
	}
</script>
<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip(); 
});
</script>