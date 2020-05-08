<?php
require './includes/header.php';
require_once ('../../mysqli_connect.php');
?>

<?php if(isset($_SESSION['emailDelete'])) {
	$emailDelete = $_SESSION['emailDelete'];
	$sql = "DELETE from KG_users where email = ?";
	$stmt = mysqli_prepare($dbc, $sql);
	mysqli_stmt_bind_param($stmt, 's', $emailDelete);
	mysqli_stmt_execute($stmt);
	if (mysqli_stmt_affected_rows($stmt)) {
		echo "<main><h2>We have deleted the admin: $emailDelete</h2></main>";
		mysqli_free_result($stmt);
	}
	else {
		echo "<main><h3>There was a problem deleting from the database</h3></main>";
		echo $emailDelete;
		exit;
	}
	
}
	include('./includes/footer.php');
?>