from mp3_tagger import MP3File, VERSION_1, VERSION_2, VERSION_BOTH
import sys
song_name=sys.argv[1]
option=sys.argv[2]
mp3 = MP3File("songs/"+song_name)
tags = mp3.get_tags()
print(tags['ID3TagV1'][option])