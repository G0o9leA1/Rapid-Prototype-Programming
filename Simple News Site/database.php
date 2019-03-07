<?php
$mysqli = new mysqli('localhost', 'module3', 'module3', 'news');

if($mysqli->connect_errno) {
	printf("Connection Failed: %s\n", $mysqli->connect_error);
	exit;
}
?>