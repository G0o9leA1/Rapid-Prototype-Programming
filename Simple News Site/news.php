<?php
    include 'functions.php';
    session_start();
    if (!isset($_SESSION['user_id'])) {
        $_SESSION['user_id'] = 0; // user_id for guest user
        $_SESSION['username'] = "Guest";
    } else {
        $_SESSION['token'] = bin2hex(random_bytes(32));
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>News</title>
    <link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body>
<header>
<div class="header-left">
<?php
    list_header_left();
?>
</div>
<div class="header-right">
<?php
if ($_SESSION['user_id'] != 0) {
    list_header_right();
} else {
    list_header_right_guest();
}
?>
</div>
</header>
<hr>
<main>
<div class="box-margin">
<h1>Stories</h1>
<?php
list_stories(0);
?>
</div>
</main>
</body>
</html>