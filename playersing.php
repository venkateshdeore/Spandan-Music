
		<div class="audio-player-cont" id="player-height" >
			<div class="logo col-md-2">
				<img id="player-img-id" src="images/playerimg/audio-player.jpg" style="width:100px;height:100px;" />
			</div>
			<div class="player col-md-10">
				<div id="songTitle" class="song-title"> Song Title</div>
				<input id="songSlider" class="song-slider" type="range" min="0" step="1" onchange="seekSong()" />
				<div>
					<div id="currentTime" class="current-time">00:00</div>
					<div id="duration" class="duration">00:00</div>
				</div>
				<center>
				<div class="controllers" style="">
					<button class='btn btn-default' style='background-color:black; padding:8px;' onclick="previous()" >
            			<i class='glyphicon glyphicon-step-backward' style="color:white;"></i>
          			</button>
					<button class='btn btn-default' style='background-color:black;  padding:8px;' onclick="decreasePlaybackRate();" >
            			<i class='glyphicon glyphicon-backward' style="color:white;"></i>
          			</button>
					<button class='btn btn-default toggleBtn' style='background-color:black;  padding:8px;' onclick="playOrPauseSong(this);" >
            			<i class='glyphicon glyphicon-pause' style="color:white;"></i>
          			</button>
					<button class='btn btn-default' style='background-color:black;  padding:8px;' onclick="increasePlaybackRate()" >
            			<i class='glyphicon glyphicon-forward' style="color:white;"></i>
          			</button>
					<button class='btn btn-default' style='background-color:black; padding:8px;' onclick="next();" >
            			<i class='glyphicon glyphicon-step-forward' style="color:white;"></i>
          			</button>
          			<div class="fb-share-button" style="background-color: #3B5998; float: right;padding: 5px; border-radius: 5px; margin-top: 6px;margin-left: 5px;"  data-layout="button" data-size="small" data-mobile-iframe="true"><a target="_blank" href="share_song.php" class="fa fa-facebook">&nbsp;&nbsp;Share</a></div>
					<!-- <img src="images/volume-down.png" width="15px" /> -->
					<!-- <input id="volumeSlider" class="volume-slider" type="range" min="0" max="1" step="0.01" onchange="adjustVolume()" /> -->
					<!-- <img src="images/playerimg/volume-up.png" width="15px" style="margin-left:2px;" /> -->
				</div>
				</center>
				<!-- <div id="nextSongTitle" class="song-title"><b>Next Song :</b>Next song title goes here...</div> -->
			</div>
		</div>
		<script type="text/javascript" src="player.js"></script>
		<script>
$(".toggleBtn").on('click',function(){
    $(this).children('.glyphicon-play, .glyphicon-pause').toggleClass("glyphicon-play glyphicon-pause");
});
</script>