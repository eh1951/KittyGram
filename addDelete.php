<?php
require_once '../../mysqli_connect.php';
require_once '../secure_conn.php';
require 'includes/header.php';
	if (isset($_POST['submit'])) {
		if (!empty($_POST['fName']))
			$fName = filter_var(trim($_POST['fName']), FILTER_SANITIZE_STRING);
		else
			$errors['fName'] = "<span class=\"warn\">A first name is required:</span>";
		if (!empty($_POST['lName']))
			$lName = filter_var(trim($_POST['lName']), FILTER_SANITIZE_STRING);
		else
			$errors['lName'] = "<span class=\"warn\">A last name is required:</span>";
		if (!empty($_POST['email'])){
			$email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
			if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
 			 $errors['emailInvalid'] = "<span class=\"warn\">Invalid email format</span>";
			}}
		else
			$errors['email'] = "<span class=\"warn\">An email is required:</span>";

		if (!empty($_POST['address']))
			$address = filter_var(trim($_POST['address']), FILTER_SANITIZE_STRING);
		else
			$errors['address'] = "<span class=\"warn\">An address is required:</span>";
		if (!empty($_POST['pass']) && ($_POST['pass'] === $_POST['passConf']))
			$pass = $_POST['pass'];
		else
			$errors['pass'] = "<span class=\"warn\">The passwords either do not match or were not entered:</span>";
		if (!empty($_POST['passConf']) && ($_POST['pass'] === $_POST['passConf']))
			$passConf = $_POST['passConf'];
		if (isset($_POST['gender']))
			$gender = $_POST['gender'];
		else
			$errors['gender'] = "<span class=\"warn\">A gender is required:</span>";
		if ($errors) { 
			echo 'You forgot some items:<br>';
			//output the contents of the $missing array
		}
		else {
			$emailCheck = "SELECT * FROM KG_users where email = ?";
			$stmt = mysqli_prepare($dbc, $emailCheck);
			mysqli_stmt_bind_param($stmt, 's', $email);
			mysqli_stmt_execute($stmt);
			$result = mysqli_stmt_get_result($stmt);
			if($result){
				if (mysqli_num_rows($result) > 0){
					echo "<main><h2>There is already someone with that email, go back and try again with a different email or login to make changes</h2></main>";
					include 'includes/footer.php';
					exit;
			}
			else
			mysqli_free_result($result);
}		
			$type = "admin";
			//$sql = "INSERT INTO KG_users (fName, lName, email, address, password, gender)  VALUES ('$fName', '$lName', '$email', '$address', '$password', '$gender')";
			$stmt = $dbc->prepare("INSERT INTO KG_users (fName, lName, email, address, password, gender, type)  VALUES (?, ?, ?, ?, ?, ?, ?)");
			$pass = password_hash($pass, PASSWORD_DEFAULT);
			$stmt->bind_param("sssssss", $fName, $lName, $email, $address, $pass, $gender, $type);
			$test = $stmt;
			$stmt->execute();
			$stmt->close();
			//$result = mysqli_query($dbc, $sql);
			//Form was filled out completely and submitted. Print the submitted information:
			echo "<p>Thank you, $fName $lName , for registering:<br>";
			echo "You entered <strong>$email</strong> for your email and <strong>$gender</strong> for your gender<br>";
			echo 'If anything is incorrect, please <a href="survey.php" style="color=#9732a8;"">return to our survey and try again</a></p>';
			include('includes/footer.php');
			exit;
		}
	}
?>

<?php //This is the login page for registered users
//require_once '../secure_conn.php';
if (isset($_POST['send'])) {
	$errors = array();
		if (!empty($_POST['emailDelete'])){
			$valid_email = filter_var(trim($_POST['emailDelete']), FILTER_VALIDATE_EMAIL);
			if (!$valid_email) 
				$errors['invalid_email'] = "<span class=\"warn\">Invalid Email:</span>";

			else
				$emailDelete = filter_var($valid_email, FILTER_SANITIZE_EMAIL);//returns a string or null if empty or false if not valid	
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
		$sql = "SELECT fName, email, password, type FROM KG_users WHERE email = ?";
		$stmt = mysqli_prepare($dbc, $sql);
		mysqli_stmt_bind_param($stmt, 's', $emailDelete);
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
					
					$_SESSION['typeDelete'] = $result['type'];
					$_SESSION['emailDelete'] = $emailDelete;
					header('Location: adminDeleted.php');
					exit;
					}
				

			}
			else {
				$errors[]='password';
			}
		} 
	   } // end while 	
 }//end isset $_POST['send']
?>

<form method="POST" action="addDelete.php">
<fieldset>
<legend>Add an Admin</legend>
<p><?php if(isset($errors['fName'])) echo $errors['fName'] . "<br>"; ?>
	Please enter your first name<br>
	<input name="fName" <?php if(isset($fName)) echo "value=\"$fName\"";?>>
	</p>
<p><?php if(isset($errors['lName'])) echo $errors['lName'] . "<br>"; ?>
	Please enter your last name<br>
	<input name="lName" <?php if(isset($lName)) echo "value=\"$lName\"";?>>
	</p>
	<p><?php if(isset($errors['email'])) echo $errors['email'] . "<br>"; 
	if(isset($errors['emailInvalid'])) echo $errors['emailInvalid'] . "<br>"; ?>
	Please enter your email<br>
	<input name="email" <?php if(isset($email)) echo "value=\"$email\"";?>>
	</p>
<p>
				<?php if(isset($errors['address'])) echo $errors['address']."<br>"; ?> 
				*Please enter your street address:<br>
				<input name="address" <?php if(isset($address)) echo "value=\"$address\"";?>>
			</p>
	<p>
				<?php if(isset($errors['pass'])) echo $errors['pass']."<br>"; ?> 
				*Please enter your password:<br>
				<input type="password" name="pass" <?php if(isset($pass)) echo "value=\"$pass\"";?>>
			</p>
			
			<p>
				*Please enter your password again:<br>
				<input type="password" name="passConf" <?php if(isset($passConf)) echo "value=\"$passConf\"";?>>
			</p>
			
		<p><?php if(isset($errors['gender'])) echo $errors['gender']."<br>";?>Gender: 
			<label><input type="radio" name="gender" value="M" <?php if(isset($gender) && $gender == "M") echo " checked=\"checked\"";?>>Male</label>&nbsp;&nbsp;
			<label><input type="radio" name="gender" value="F" <?php if(isset($gender) && $gender == "F") echo " checked=\"checked\"";?>> Female</label>&nbsp;&nbsp;
			<label><input type="radio" name="gender" value="NA" <?php if(isset($gender) && $gender == "NA") echo " checked=\"checked\"";?>> Prefer not to answer</label>
		</p>
		<p><input type="submit" name="submit" value="register"></p>


       <form method="post" action="addDelete.php">
			<fieldset>
				<legend>Delete an Admin</legend>
				<?php if ($errors) { ?>
				<p class="warning">Please fix the item(s) indicated.</p>
				<?php } ?>
            <p>
				
                <label for="email">Please enter your email address:</label>
				
				<?php if(isset($errors['invalid_email'])) echo $errors['invalid_email'] . "<br>"; 	elseif(isset($errors['missing_email'])) echo $errors['missing_email'] . "<br>"; ?>

                <input name="emailDelete" id="email" type="text"
				<?php if (isset($emailDelete) && !$errors['missing_email']) {
                    echo 'value="' . htmlspecialchars($emailDelete) . '"';
                } ?>>
            </p>
			<p>
				<?php if(isset($errors['pass'])) echo $errors['pass'] . "<br>"; ?>
                <label for="pw">Password:</label> 
                <input name="password" id="pw" type="password">
            </p>
			
            <p>
                <input name="send" type="submit" value="Delete Admin">
            </p>
		</fieldset>
        </form>

<?php include('includes/footer.php'); ?>