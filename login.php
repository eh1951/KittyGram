<?php //This is the login page for registered users
require 'includes/header.php';
require_once '../secure_conn.php';
if (isset($_POST['send'])) {
	$errors = array();
		if (!empty($_POST['email'])){
			$valid_email = filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL);
			if (!$valid_email) 
				$errors['invalid_email'] = "<span class=\"warn\">Invalid Email:</span>";

			else
				$email = filter_var($valid_email, FILTER_SANITIZE_EMAIL);//returns a string or null if empty or false if not valid	
		}
		else 
			$errors['missing_email'] = "<span class=\"warn\">Missing Email:</span>";
		if(!empty($_POST['password'])) 
				$password = filter_var(trim($_POST['password']), FILTER_SANITIZE_STRING);	
		else
			$errors['pass'] = "<span class=\"warn\">Missing Password:</span>";

	while (!$errors){ 
		require_once ('../../mysqli_connect.php'); // Connect to the db.
		// Make the query:
		$sql = "SELECT fName, email, password, type, folder FROM KG_users WHERE email = ?";
		$stmt = mysqli_prepare($dbc, $sql);
		mysqli_stmt_bind_param($stmt, 's', $email);
		mysqli_stmt_execute($stmt);
		$result=mysqli_stmt_get_result($stmt);
		$rows = mysqli_num_rows($result);
		mysqli_free_result($stmt);
		if ($rows==0) 
			$errors[] = 'no_email';
		else { // email found, validate password
			$result=mysqli_fetch_assoc($result); //convert the result object pointer to an associative array 
			$pw_hash=$result['password'];
			if (password_verify($password, $pw_hash )) { //passwords match
				if ($result['type'] === 'admin'){
					$firstName = $result['fName'];
					//$folder = $result['folder'];
					//$_SESSION['folder'] = $folder;
					$_SESSION['type'] = $result['type'];
					$_SESSION['fn'] = $firstName;
					$_SESSION['email'] = $email;
					header('Location: site_image.php');
					exit;
					}
				else
				$firstName = $result['fName'];
				//your code here
				$folder = $result['folder'];
				$_SESSION['folder'] = $folder;
				$_SESSION['fn'] = $firstName;
				$_SESSION['email'] = $email;
				header('Location: logged_in.php');
				exit;
			}
			else {
				$errors['passWrong']="<span class=\"warn\">Wrong password:</span>";
			}
		} 
	   } // end while 	
 }//end isset $_POST['send']
?>
	<main>
        <h2>Login to KittyGram</h2>
        <form method="post" action="login.php">
			<fieldset>
				<legend>Registered Users Login</legend>
				<?php if ($errors) { ?>
				<p class="warning">Please fix the item(s) indicated.</p>
				<?php } ?>
            <p>
				
                <label for="email">Please enter your email address:</label>
				
				<?php if(isset($errors['invalid_email'])) echo $errors['invalid_email'] . "<br>"; 	elseif(isset($errors['missing_email'])) echo $errors['missing_email'] . "<br>"; ?>

                <input name="email" id="email" type="text"
				<?php if (isset($email) && !$errors['email']) {
                    echo 'value="' . htmlspecialchars($email) . '"';
                } ?>>
            </p>
			<p>
				<?php if(isset($errors['pass'])) echo $errors['pass'] . "<br>"; 
					elseif(isset($errors['passWrong'])) echo $errors['passWrong'] . "<br>"; ?>
                <label for="pw">Password:</label> 
                <input name="password" id="pw" type="password">
            </p>
			
            <p>
                <input name="send" type="submit" value="Login">
            </p>
		</fieldset>
        </form>
	</main>
<?php include './includes/footer.php'; ?>