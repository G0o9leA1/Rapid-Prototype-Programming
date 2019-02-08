<?php
	include "functions.php";
	session_start();

	// Get the filename and make sure it is valid
	$filename = basename($_FILES['uploadedfile']['name']);
	if( !checkFileName($filename) ){
		$_SESSION["msg"] = "Invalid filename (valid characters: 0-9, a-z, A-Z, -, _, .)";
		back2FilePage();
	}

	$full_path = sprintf("%s%s/%s", $_SESSION["base_dir"], $_SESSION["user_dir"], $filename);

	if (file_exists($full_path)) {
		$_SESSION["msg"] = "File exists";
	} elseif (!move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $full_path) ){
		$_SESSION["msg"] = "Failed to upload";
	} else {
		$_SESSION["msg"] = "Uploaded successfully";
	}
	back2FilePage();
?>