API_KEY = 'cSpUJKpD'
import acoustid
for score, recording_id, title, artist in acoustid.match(API_KEY,'songs/4.mp3'):
	print(title)