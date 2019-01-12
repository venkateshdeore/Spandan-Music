<?php
include('includes/connection.php');
if(!isset($_SESSION['uid']))
		echo "<script>alert('Access Denied');window.location='logout.php';</script>";
$uid=$_SESSION['uid'];
$query="SELECT * FROM user_song_map WHERE uid='$uid'";
$result=mysqli_query($con,$query);
$hash_map=array();
while($row=mysqli_fetch_array($result))
{
	$song_id=$row['song_id'];
	$query1="SELECT * FROM song_details WHERE song_id='$song_id'";
	$result1=mysqli_query($con,$query1);
	$row1=mysqli_fetch_array($result1);
	$key=$row1['genre'];
	if(array_key_exists($key, $hash_map))
	{
		$hash_map[$key]++;
	}
	else
		$hash_map[$key]=1;

}
arsort($hash_map);
$flag_to_break=0;
$count_songs_init=0;
$flag_to_check_if_there_are_recommendations=0;
echo "<div class='row '><h2><strong>Recommendations</strong></h2><hr>";
foreach ($hash_map as $genre => $count) {
	$query2="SELECT * FROM song_details WHERE genre='$genre'";
	$result2=mysqli_query($con,$query2);
	while($row=mysqli_fetch_array($result2))
	{

		$flag_to_check_if_there_are_recommendations=1;
		$song_id=$row['song_id'];
		$song_name=$row['song_name'];
		$query3="SELECT * FROM user_song_map WHERE uid='$uid' AND song_id='$song_id'";
		$result3=mysqli_query($con,$query3);
		if(mysqli_num_rows($result3)==0)
		{$count_songs_init++;
			?><div class='col-md-3' >
				<div class="card" style="padding:10px; margin-bottom: 10px;">
	  	<img src='images/album_art/No-album-art-itunes.jpg' style='width:100%px; height:200px;' class="img-responsive">
	  	<p class='title'><?php echo substr($song_name,0,15); ?>..</p>
	  	<button class='btn btn-default' onclick="call_to_start('<?php echo $song_id; ?>','<?php echo $song_name; ?>')" style='background-color:#e22727;' data-placement='top' title='Play Song' data-toggle='tooltip'>
            <i class='glyphicon glyphicon-music'></i>
          </button>

          <button class='btn btn-default' style='background-color:#e22727;' class="w3-bar-item w3-button"  data-toggle="modal" data-target="#import" onclick="send_id_to_modal('<?php echo $song_id; ?>')" id="import_button">
            <i class='glyphicon glyphicon-share-alt' data-placement='top' title='Import' data-toggle='tooltip'></i>
          </button>
		</div>
	</div>
		<?php }
		if($count_songs_init>=8)
		{
			$flag_to_break=1;
			break;
		}
	}
	if($flag_to_break==1)
		break;
}
if($flag_to_check_if_there_are_recommendations==0)
{
	$count_recommend_songs=0;
	$query4="SELECT * FROM song_details ";
	$result4=mysqli_query($con,$query4);
	$count_rows=mysqli_num_rows($result4);
	while($row4=mysqli_fetch_array($result4))
	{
		$song_id=$row4['song_id'];
		$song_name=$row4['song_name'];
		$query5="SELECT * FROM user_song_map WHERE uid='$uid' AND song_id='$song_id'";
		$result5=mysqli_query($con,$query5);
		if(mysqli_num_rows($result5)==0)
		{
			?><div class='col-md-3 col-sm-6'>
				<div class="card" style="padding: 10px;">
	  	<img src='images/album_art/No-album-art-itunes.jpg' style='width:100%; height:200px;' class="img-responsive">
	  	<p class='title'><?php echo substr($song_name,0,15); ?>..</p>
	  	<button class='btn btn-default' onclick="call_to_start('<?php echo $song_id; ?>','<?php echo $song_name; ?>')" style='background-color:#e22727;'>
            <i class='glyphicon glyphicon-music'></i>
          </button>
        <button class='btn btn-default' style='background-color:#e22727;' class="w3-bar-item w3-button"  data-toggle="modal" data-target="#import" onclick="send_id_to_modal('<?php echo $song_id; ?>')" id="import_button">
            <i class='glyphicon glyphicon-share-alt'></i>
          </button>
		</div></div><?php
		$count_recommend_songs++;
		}
		if($count_recommend_songs>=4)
			break;
	}
}
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
								<form id="login-form" action="song_import_recomm.php" method="post" role="form" style="display: block;" enctype="multipart/form-data">
									<fieldset>
										<legend style="color:white; ">Song:</legend>
									
									<input type="text" name="song_id" id="song_id_abcd" value="" tabindex="1" class="form-control" style="display:none ;">
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
		$("#song_id_abcd").attr("value",aid);
	}
</script>