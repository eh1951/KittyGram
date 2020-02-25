

<?php
include('includes/header.php');
	if (isset($_GET['submit'])) {
		if (!empty($_GET['fName']))
			$fName = $_GET['fName'];
		else
			$errors['fName'] = "<span class=\"warn\">A first name is required:</span>";
		if (!empty($_GET['lName']))
			$lName = $_GET['lName'];
		else
			$errors['lName'] = "<span class=\"warn\">A last name is required:</span>";
		if (!empty($_GET['email']))
			$email = $_GET['email'];
		else
			$errors['email'] = "<span class=\"warn\">An email is required:</span>";
		if (!empty($_GET['address']))
			$address = $_GET['address'];
		else
			$errors['address'] = "<span class=\"warn\">An address is required:</span>";
		if (!empty($_GET['pass']) && ($_GET['pass'] === $_GET['passConf']))
			$pass = $_GET['pass'];
		else
			$errors['pass'] = "<span class=\"warn\">The passwords either do not match or were not entered:</span>";
		if (!empty($_GET['passConf']) && ($_GET['pass'] === $_GET['passConf']))
			$passConf = $_GET['passConf'];
		if (isset($_GET['gender']))
			$gender = $_GET['gender'];
		else
			$errors['gender'] = "<span class=\"warn\">A gender is required:</span>";
		if ($errors) { //
			echo 'You forgot some items:<br>';
			//output the contents of the $missing array
		}
		else {
			//Form was filled out completely and submitted. Print the submitted information:
			echo "<p>Thank you, $fName $lName , for registering:<br>";
			echo "You entered <strong>$email</strong> for your email and <strong>$gender</strong> for your gender<br>";
			echo 'If anything is incorrect, please <a href="survey.php">return to our survey and try again</a></p>';
			include('includes/footer.php');
			exit;
		}
	}
?>


<form method="get" action="registration.php" autocomplete="off">
<fieldset>
<legend>User Registration</legend>


<p><?php if(isset($errors['fName'])) echo $errors['fName'] . "<br>"; ?>
	Please enter your first name<br>
	<input name="fName" <?php if(isset($fName)) echo "value=\"$fName\"";?>>
	</p>
<p><?php if(isset($errors['lName'])) echo $errors['lName'] . "<br>"; ?>
	Please enter your last name<br>
	<input name="lName" <?php if(isset($lName)) echo "value=\"$lName\"";?>>
	</p>
	<p><?php if(isset($errors['email'])) echo $errors['email'] . "<br>"; ?>
	Please enter your email<br>
	<input name="email" <?php if(isset($email)) echo "value=\"$email\"";?>>
	</p>
<p>
				<?php if(isset($errors['address'])) echo $errors['address']."<br>"; ?> 
				*Please enter your street address for delivery:<br>
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
			<?php if(isset($missing['gender'])) echo $missing['gender']."<br>";?>
		<p>Gender: 
			<label><input type="radio" name="gender" value="M" <?php if(isset($gender) && $gender == "M") echo " checked";?>>Male</label>&nbsp;&nbsp;
			<label><input type="radio" name="gender" value="F" <?php if(isset($gender) && $gender == "F") echo " checked";?>> Female</label>&nbsp;&nbsp;
			<label><input type="radio" name="gender" value="NA" <?php if(isset($gender) && $gender == "NA") echo " checked";?>> Prefer not to answer</label>
		</p>
		<p><input type="submit" name="submit" value="register"></p>
</fieldset>
</form>
<?php include('includes/footer.php'); ?>
