<?php
	
	echo $abc = "python2 pyacoustic/script.py 'songs/3.mp3' 'title' 2>&1";
	echo shell_exec($abc);

?>