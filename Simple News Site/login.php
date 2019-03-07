<?php
session_start();
require 'database.php';
include 'functions.php';

$username = $_POST['username'];
$pwd_guess = $_POST['password'];

// check username
if ($username == NULL || $pwd_guess == NULL) {
    $_SESSION['msg'] = "Please enter both username and password";
    back2IndexPage();
}
if (!checkUserName($username)) {
    $_SESSION['msg'] = "Invalid username (valid characters: 0-9, a-z, A-Z, -, _)";
    back2IndexPage();
}

// Use a prepared statement
$stmt = $mysqli->prepare("SELECT COUNT(*), id, hashed_password FROM users WHERE username=?");

// Bind the parameter
$stmt->bind_param('s', $username);
$stmt->execute();

// Bind the results
$stmt->bind_result($cnt, $user_id, $pwd_hash);
$stmt->fetch();

// Compare the submitted password to the actual password hash
if($cnt == 1 && password_verify($pwd_guess, $pwd_hash)){
	// Login succeeded!
    $_SESSION['user_id'] = $user_id;
    $_SESSION['username'] = $username;
    // Redirect to your target page
    back2NewsPage();
} else{
    // Login failed; redirect back to the login screen
    $_SESSION['msg'] = "Login failed";
    back2IndexPage();
}
?>