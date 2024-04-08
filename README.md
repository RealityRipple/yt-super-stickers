# YouTube Super Sticker List in JSON
A list of image URLs for Super Stickers on YouTube, in JSON format.  

## List
Access the active list of Emojis at  
 > `//cdn.jsdelivr.net/gh/realityripple/yt-super-stickers/list.json`  

## Updates
A cron job regularly runs `pull.php` once per 24 hours, which will find, download, commit, and push any new changes to the repository automatically. Each new version is marked with a tag representing the date (GMT) the update was retrieved.
