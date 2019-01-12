<?php
	if(!isset($_SESSION['uid']))
		echo "<script>alert('Access Denied');window.location='index.php';</script>";
	$db=mysqli_connect("localhost","root","","spandan_music");
	$uid=$_SESSION['uid'];
	// $uid=1;
	$query="SELECT * FROM album_details WHERE uid='$uid' ORDER BY album_id DESC LIMIT 4";
	$result=mysqli_query($db,$query);
	$nrow=mysqli_num_rows($result);
	echo "<div class='row '><h2><strong>Albums</strong><a href='all_albums_fetch.php' ><button class='btn btn-default' style='background-color:#e22727;'>
             See all <i class='glyphicon glyphicon-th'></i>
          </button></a></h2><hr>";
	for($i=1;$i<=min(4,$nrow);$i++)
	{
		$row=mysqli_fetch_array($result);
		$album_art=$row['album_art'];
		$album_name=$row['album_name'];
		$album_id=$row['album_id'];
		$query1="SELECT * FROM user_song_map WHERE uid='$uid' and album_id='$album_id'";
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
	<div class=' col-md-3 col-sm-6'>
		<div class="card" style="padding: 10px;">
	  <img src='images/album_art/<?php echo $album_art; ?>' style='width:100%; height:200px' class="img-responsive">
	  <p class='title'><?php echo substr($album_name,0,15);?></p>
	 <?php echo "<button class='btn btn-default' onclick='call_to_start_playlist(".json_encode($song_id_list).",".json_encode($song_name_list).")' data-placement='top' title='Play all songs' data-toggle='tooltip' style='background-color:#e22727;'>" ?>
            <i class='glyphicon glyphicon-music'></i>
          </button>
          <a href="album_details.php?album_id=<?php echo $album_id; ?>&album_name=<?php echo $album_name; ?>";>
          <button data-placement='top' title='Album details' data-toggle='tooltip' class='btn btn-default' style='background-color:#e22727;'>
            <i class='glyphicon glyphicon-list'></i>
          </button></a>
	</div>
	</div>
	<?php
	}
	echo "</div>";

?>