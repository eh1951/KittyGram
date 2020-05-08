<?php
	require './includes/header.php';
	echo "<main>";
	if(isset($_SESSION['folder'])){
		echo "<h2>Click on an image to view it in a separate window.</h2>";
		echo "<ul>";

		// This script lists the images in the uploads directory.
		// This version now shows each image's file size and uploaded date and time.
			
		// Set the default timezone:
		date_default_timezone_set('America/New_York');
		$mainDir = '../../KG_uploads';
		$subDirectories = scandir($mainDir);
		unset($subDirectories[0]);
		unset($subDirectories[1]);
		
		foreach($subDirectories as $subDirectory) {
			foreach(glob($mainDir.'/'.$subDirectory.'/*') as $file){
			if (!substr($file, 0, 1) != '.') {
				$image_size = getimagesize("$mainDir/$subDirectory/$file");
				$image_name = basename($file);
				
				$directory = dirname($file);
				echo "<img src=\"show_image.php?image=$image_name&imgLocation=$directory\">";
			}
		}
		
}
		echo '</ul></main>';
	} //end isset
		else {
			echo "<h2>We are sorry, but you must be logged in as a registered user to view images</h2>";
			echo "<h3>Use the Login link at the left to login</h3></main>";	
		}
include ('./includes/footer.php');
?>
