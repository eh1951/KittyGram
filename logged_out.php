<?php 
session_start();
//require_once '../secure_conn.php';
?>

	<?php if (isset($_SESSION['fn']))  {
			$firstname = $_SESSION['fn'];
			$_SESSION = array();
			session_destroy();
			(setcookie('PHPSESSID',time()-3600,'/'));
			require_once '../reg_conn.php';
			$message = "Thanks";
			$message2 = "You are now logged out";
		} else { 
			$message = 'Thanks';
			$message2 = 'You are now logged out';	
		}
		require 'includes/header.php';
		// Print the message
		echo "<main>";
		echo '<h2>'.$message.'</h2>';
		echo '<h3>'.$message2.'</h3>';
		?>
	</main>
	<?php // Include the footer and quit the script:
	include ('./includes/footer.php'); 
	?>
	