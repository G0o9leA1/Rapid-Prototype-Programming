<?php
	include "functions.php";
	session_start();

	$filename = $_POST["filename"];
	$sender = $_SESSION["username"];
	$receiver = $_POST["receiver"];
	if( !checkUserName($receiver) ){
		$_SESSION["msg"] = "Invalid username for the receiver (valid characters: 0-9, a-z, A-Z, -, _)";
		back2FilePage();
	}
	// users cannot send file to themselves
	if ($receiver == $sender) {
		$_SESSION["msg"] = "Please do not enter your own username";
		back2FilePage();
	}
	// check if the receiver is a registered user
	$users_list = getUsersList();
	if (!in_array($receiver, $users_list)) {
		$_SESSION["msg"] = "Please send your file to a registered user";
		back2FilePage();
	} 

	$src_path = sprintf("%s%s/%s", $_SESSION["base_dir"], $_SESSION["user_dir"], $filename);
	$dest_folder = sprintf("%s%s/from_%s/", $_SESSION["base_dir"], $receiver, $sender);

	if (!is_dir($dest_folder)) {
		if (!mkdir($dest_folder)) {
			$_SESSION["msg"] = "Failed to send";
			back2FilePage();
		}
	}

	if (!copy($src_path, $dest_folder.$filename)) {
		$_SESSION["msg"] = "Failed to send";
	} else {
		$_SESSION["msg"] = "Sent successfully";
	}
	back2FilePage();
?>