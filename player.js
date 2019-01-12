
var songs;
var song_name_pass;
var songTitle = document.getElementById('songTitle');
var songSlider = document.getElementById('songSlider');
var currentTime = document.getElementById('currentTime');
var duration = document.getElementById('duration');
// var volumeSlider = document.getElementById('volumeSlider');
// var nextSongTitle = document.getElementById('nextSongTitle');
var flag_for_function=0;
var song = new Audio();
var currentSong = 0;
function call_to_start(current,songname)
{
	//songs=NULL;
	jQuery.ajax({
		type: "POST",
		url: 'set_sess_song.php',
		datatype: 'json',
		data: {arguments: [current]},
	});
	flag_for_function=0;
	currentSong=current;
	loadSong_single_song(currentSong,songname);
}
function call_to_start_playlist(all_songs,songname)
{
	console.log(all_songs[0]);
	flag_for_function=1;
	currentSong=0;
	songs=all_songs.slice();
	song_name_pass=songname.slice();
	loadSong();
}
function loadSong_single_song (currentSong,songname) {
	song.src = "songs/" + currentSong+".mp3";
	songTitle.textContent = songname;
	duration.textContent = showDuration;
	song.playbackRate = 1;
	// song.volume = volumeSlider.value;
	playOrPauseSong();
	setTimeout(showDuration, 1000);
}
function loadSong () {
	if(flag_for_function==1)
	{
	song.src = "songs/" + songs[currentSong]+".mp3";
	songTitle.textContent = (currentSong + 1) + ". " + song_name_pass[currentSong];
	// nextSongTitle.innerHTML = "<b>Next Song: </b>" + songs[currentSong + 1 % songs.length];
	song.playbackRate = 1;
	// song.volume = volumeSlider.value;
	song.play();
	setTimeout(showDuration, 1000);
	}
}

setInterval(updateSongSlider, 1000);

function updateSongSlider () {
	var c = Math.round(song.currentTime);
	songSlider.value = c;
	currentTime.textContent = convertTime(c);
	if(song.ended){
		next();
	}
}

function convertTime (secs) {
	var min = Math.floor(secs/60);
	var sec = secs % 60;
	min = (min < 10) ? "0" + min : min;
	sec = (sec < 10) ? "0" + sec : sec;
	return (min + ":" + sec);
}

function showDuration () {
	var d = Math.floor(song.duration);
	songSlider.setAttribute("max", d);
	duration.textContent = convertTime(d);
}

function playOrPauseSong () {
	song.playbackRate = 1;
	if(song.paused){
		if(flag_for_function==0){
		jQuery.ajax({
			type: "POST",
			url: 'get_last_played_song_time.php',
			datatype: 'json',
			data: {arguments: [currentSong]},
			success: function(data) {
				if(data>song.duration)
					data=0;
    		song.currentTime = data;//play with mod
    		console.log(data); //alert isn't for debugging
			}
		});
		songSlider.value=song.currentTime;
		}
		song.play();
		// img.src = "images/playerimg/pause.png";
	}else{
		if(flag_for_function==0){
		
		 jQuery.ajax({
            type: "POST",
            url: 'add_song_pause_in_db.php',
            dataType: 'json',
            data: {arguments: [currentSong,song.currentTime]},
            
        });
		}
		song.pause();
		// img.src = "images/playerimg/play.png";
	}
}

function next(){
	if(flag_for_function==1)
	{
	currentSong = (currentSong + 1)% songs.length;
	loadSong();
	}
}

function previous () {
	if(flag_for_function==1)
	{
	currentSong--;
	currentSong = (currentSong < 0) ? songs.length - 1 : currentSong;
	loadSong();
	}
}

function seekSong () {
	song.currentTime = songSlider.value;
	currentTime.textContent = convertTime(song.currentTime);
}

// function adjustVolume () {
// 	song.volume = volumeSlider.value;
// }

function increasePlaybackRate () {
	songs.playbackRate += 0.5;
}

function decreasePlaybackRate () {
	songs.playbackRate -= 0.5;
}


