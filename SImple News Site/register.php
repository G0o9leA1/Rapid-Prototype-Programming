<?php
	session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Register</title>
	<link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body>
	<form action="index.php" method="POST">
    <p><input type="submit" class="signbutton" value="Back to Login"/></p>
	</form>
	<div class="box-margin">
		<h1>Register</h1>
		<form action="adduser.php" method="POST">
			<div id="register-username">
				<label for="uname">Username:</label>
				<input type="text" name="username" id="uname"/>
			</div>
			<div id="register-password">
				<label for="pswd">Password:</label>
				<input type="password" name="password" id="pswd"/>
			</div>
			<div id="register-reg">
			<input class="signbutton" type="submit" name="action" value="Register"/>
			</div>
		</form>
	</div>
	<?php
		// display message
		if (isset($_SESSION['msg'])) {
			printf("<p class=\"message\">%s</p>\n", $_SESSION["msg"]);
			unset($_SESSION['msg']);
		}
	?>
</body>
</html>