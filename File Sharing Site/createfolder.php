<?php
	include "functions.php";
	session_start();

	// Get the foldername and make sure it is valid
	$foldername = $_POST["foldername"];
	if( !checkFileName($foldername) ){
		$_SESSION["msg"] = "Invalid foldername (valid characters: 0-9, a-z, A-Z, -, _, .)";
		back2FilePage();
	}

	$full_path = sprintf("%s%s/%s", $_SESSION["base_dir"], $_SESSION["user_dir"], $foldername);

	if (file_exists($full_path)) {
		$_SESSION["msg"] = "Folder exists";
	} elseif (!mkdir($full_path)) {
		$_SESSION["msg"] = "Failed to create a folder";
	} else {
		$_SESSION["msg"] = "Created successfully";
	}
	back2FilePage();
?>