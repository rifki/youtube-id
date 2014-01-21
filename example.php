<form action="" method="post">
    <input type="text" name="video" placeholder="input URL Youtube">
    <input type="submit" name="submit" value="submit">
</form>

<hr />

<?php require_once 'youtubeID.php';
if (isset($_POST['submit'])) : ?>
	
	<?php $id = $_POST['video']; ?>
	<p>Youtube ID: <?php echo YoutubeID::getVideoID($id); ?></p>
	<p>Image: <br /><img src="<?php echo YoutubeID::thumbImg($id, 3, 'small') ?>"></p>
	<p>Video: </p>
	<iframe width="420" height="315" src="//www.youtube.com/embed/<?php echo YoutubeID::getVideoID($id); ?>" frameborder="0" allowfullscreen></iframe>

<?php endif; ?>
