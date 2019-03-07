<?php
    require 'database.php';
    include 'functions.php';
    session_start();

    $username = $_POST['username'];
    $password = $_POST['password'];

    // check username
	if ($username == NULL || $password == NULL) {
		$_SESSION['msg'] = "Please enter both username and password";
		back2RegisterPage();
    }
	if (!checkUserName($username)) {
		$_SESSION['msg'] = "Invalid username (valid characters: 0-9, a-z, A-Z, -, _)";
		back2RegisterPage();
	}
    if (userExists($username)) {
        $_SESSION['msg'] = "Username exists";
		back2RegisterPage();
    }

    // registration: add to the users table
    $stmt = $mysqli->prepare("insert into users (username, hashed_password) values (?, ?)");
    if(!$stmt){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }
    $stmt->bind_param('ss', $username, password_hash($password, PASSWORD_DEFAULT));
    $stmt->execute();
    $stmt->close();
    
    $_SESSION['msg'] = "Registered successfully";
    back2IndexPage();
?>