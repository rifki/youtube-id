<form action="" method="post">
    <input type="text" name="video" placeholder="input URL Youtube">
    <input type="submit" name="submit" value="submit">
</form>

<hr />	

<?php 
require_once 'src/youtubeID.php';

if (isset($_POST['submit'])) {

	$url = trim($_POST['video']); 
	$id = YoutubeID::getVideoID($url);

	echo "Youtube ID : $id <br />";
	echo "Image : <br /> <img src='".YoutubeID::getThumbs($id)."'> <br />";
	echo "Video : <br /> ".YoutubeID::getEmbed($id, 560, 315);
}
?>
