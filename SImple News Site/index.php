<?php
    require 'database.php';
    include 'functions.php';
	session_start();
	// direct to the user's news page if the user didn't leave the session
	if (isset($_SESSION['user_id'])) {
		back2NewsPage();
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Welcome</title>
	<link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body>
<header>
    <!-- Register button -->
    <form action="register.php" method="POST">
    <p><input type="submit" class="signbutton" value="Register"/></p>
    </form>
    <!-- Login as Guest -->
    <form action="news.php" method="POST">
    <p><input type="submit" class="signbutton" value="Login as Guest"/></p>
    </form>
</header>
<main>
    <!-- username and password -->
	<div class="box-margin">
		<h1>Welcome to News Site</h1>
		<form action="login.php" method="POST">
			<div id="index-username">
				<label for="uname">Username:</label>
				<input type="text" name="username" id="uname"/>
			</div>
			<div id="index-password">
				<label for="pswd">Password:</label>
				<input type="password" name="password" id="pswd"/>
			</div>
			<div id="index-login">
			<input class="signbutton" type="submit" name="action" value="Sign in"/>
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
</main>
</body>
</html>
