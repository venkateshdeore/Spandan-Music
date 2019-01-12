<?php
	if(!isset($_SESSION['uid']))
		echo "<script>alert('Access Denied');window.location='../index.php';</script>";
	$db=mysqli_connect("localhost","root","","spandan_music");
	$uid=$_GET['profile_id'];
	// $uid=1;
	$query="SELECT * FROM album_details WHERE uid='$uid' ORDER BY album_id DESC ";
	$result=mysqli_query($db,$query);
	$nrow=mysqli_num_rows($result);
	// echo "<div class='row '><h2><strong>Albums</strong></h2><hr>";
	echo "<div class='col-md-12 container ' id='main_songs_head'><div class='row'><div class='col-md-7' style='margin-top:10px;'><h2><strong>Albums</strong></h2></div><div class='col-md-5'><input id='myInput' type='text' class='form-control' placeholder='Search Albums' style='margin-top:20px;'></div></div><hr>";
	for($i=1;$i<=$nrow;$i++)
	{
		$row=mysqli_fetch_array($result);
		$album_art=$row['album_art'];
		$album_name=$row['album_name'];
		$album_id=$row['album_id'];
		$query1="SELECT * FROM user_song_map WHERE uid='$uid' and album_id='$album_id' and is_private='0'";
		$result1=mysqli_query($db,$query1);
		$j=0;
		$song_name_list=array();
		$song_id_list=array();
		while($row3=mysqli_fetch_array($result1))
		{
			array_push($song_id_list,(int)$row3['song_id']);
			array_push($song_name_list,$row3['custom_name']);
		}
		?>
	<div class='col-md-3 col-sm-6' id="song_card" style="margin-bottom: 10px;">
		<div class="card" style="padding:10px;">
	  <img src='images/album_art/<?php echo $album_art; ?>' style='width:100%; height:200px;' class="img-responsive">
	  <p class='title'><?php echo substr($album_name,0,15);?></p>
	 <?php echo "<button class='btn btn-default' onclick='call_to_start_playlist(".json_encode($song_id_list).",".json_encode($song_name_list).")' style='background-color:#e22727;'>" ?>
            <i class='glyphicon glyphicon-music' data-placement='top' title='Play all songs' data-toggle='tooltip'></i>
          </button>
          
          <a href="album_details_profile.php?album_id=<?php echo $album_id; ?>&album_name=<?php echo $album_name; ?>&profile_id=<?php echo $profile_id ?>";>
          <button class='btn btn-default' style='background-color:#e22727;' data-placement='top' title='Album details' data-toggle='tooltip'>
            <i class='glyphicon glyphicon-list'></i>
          </button></a>
	</div>

</div>
	<?php
	}
	echo "</div>";

?>
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