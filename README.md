# Youtube-API-V3
Simple and Fast script to get all you need from the new Youtube API v3


###### I have been using Youtube API V2 and everything was good, until the new API we had to set two requests to get all details about videos. However calling `Search` and `Video` requests takes time (around 10.2Sec for 50 results #'Huge'#), I had to reduce the time because visitors can't wait all 10 seconds.


## How to get videos with custom Duration:

- simply you add this parameters to your URL callback: `Type` and `VideoDuration`.
  ** Example: 'https://www.googleapis.com/youtube/v3/search?part=id&q='.$your_query.'&maxResults=3&type=video&videoDuration=short&key='.$your_cc_key;

Make sure to use `Type` paramtere or else the URL callback will return an ERROR.
