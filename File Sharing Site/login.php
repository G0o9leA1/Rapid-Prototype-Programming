<?php
	include "functions.php";
	session_start();

	$username = $_POST["username"];
	if ($username == NULL) {
		$_SESSION["msg"] = "Please enter a username";
		back2IndexPage();
	}	
	if (!checkUserName($username)) {
		$_SESSION["msg"] = "Invalid username (valid characters: 0-9, a-z, A-Z, -, _)";
		back2IndexPage();
	}

	$users_list = getUsersList();
	if ($_POST["action"] == "Sign in") {
		if (in_array($username, $users_list)) {
			$_SESSION["username"] = $username;
			back2FilePage();
		} else {
            $_SESSION["msg"] = "Please register first";
            back2IndexPage();
		}
	} elseif ($_POST["action"] == "Register") {
		if (in_array($username, $users_list)) {
			$_SESSION["msg"] = "Username exists";
		} else {
			$file = fopen("/home/group/users.txt", "a");
			// add the username to users.txt and make a new directory
			fwrite($file, $username."\n");
			$full_path = sprintf("%s%s", $_SESSION["base_dir"], $username);

			if (!mkdir($full_path)) {
				$_SESSION["msg"] = "Failed to register";
			} else {
				$_SESSION["msg"] = "Registered successfully";
			}
			fclose($file);
		}
		back2IndexPage();
	}
?>