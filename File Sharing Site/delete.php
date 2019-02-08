<?php
	include "functions.php";
	session_start();

	$fileorfolder = $_POST["deletedfile"];
	$full_path = sprintf("%s%s/%s", $_SESSION["base_dir"], $_SESSION["user_dir"], $fileorfolder);
	delete($full_path);
?>