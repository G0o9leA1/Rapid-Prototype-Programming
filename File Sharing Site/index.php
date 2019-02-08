<?php
	include "functions.php";
	session_start();
	$_SESSION["base_dir"] = "/home/group/file_sharing_site/"; // base directory
	// direct to the user's file page if the user didn't leave the session
	if (isset($_SESSION["username"])) {
		back2FilePage();
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Welcome</title>
	<link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body>
	<br>
	<div class="box-margin">
		<h1>Welcome to File Sharing Site</h1>
		<div>
			<form action="login.php" method="POST">
			<div class="center">
				<label for="uname">Username:</label>
				<input type="text" name="username" id="uname"/>
			</div>
			<div class="center">
				<input class="signbutton" type="submit" name="action" value="Sign in"/>
				<input class="signbutton" type="submit" name="action" value="Register"/>
			</div>
			</form>
		</div>
	</div>
	<?php
		// display message
		if (isset($_SESSION["msg"])) {
			printf("<p class=\"message\">%s</p>\n", $_SESSION["msg"]);
			unset($_SESSION["msg"]);
		}
	?>
</body>
</html>
