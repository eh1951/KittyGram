<?php // This page displays an image uploaded by a user.
session_start();
if(!isset($_SESSION['folder'])){
	require ('./includes/header.php');
	echo "<main><h2>We are sorry, but you must be logged in to view images</h2>";
	echo "<h3>Use Login link at the left to login</h2></main>";
	include ('./includes/footer.php');
	exit;
}else {	
	$folder= $_SESSION['folder'];
	$name = FALSE; // Flag variable:

	// Check for an image name in the URL:
	if (isset($_GET['image'])) {
		// Make sure it has an image's extension:
		$ext = strtolower (substr($_GET['image'], -4));
		if (($ext == '.jpg') OR ($ext == 'jpeg') OR ($ext == '.png') OR ($ext == '.gif')) {
			// Full image path:
			$image = "{$_GET['imgLocation']}/{$_GET['image']}";
			// Check that the image exists and is a file:
			if (file_exists ($image) && (is_file($image))) {
			// Set the name as this image:
				$name = $_GET['image'];	
			} // End of file_exists() IF.
		} // End of $ext IF.	
	} // End of isset($_GET['image']) IF.
	// If there was a problem, use the default image:
	if (!$name) {
		$image = './images/unavailable.png';	
		$name = 'unavailable.png';
	}

	// Get the image information:
	$info = getimagesize($image);
	$fs = filesize($image);

	// Send the content information:
	header ("Content-Type: {$info['mime']}\n");
	header ("Content-Disposition: inline; filename=\"$name\"\n");
	header ("Content-Length: $fs\n");

	// Send the file:
	readfile ($image);
}