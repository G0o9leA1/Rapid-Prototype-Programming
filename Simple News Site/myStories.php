<?php
    include 'functions.php';
    session_start();
    if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] == 0) {
        echo "No access to this page!\n";
        exit;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>My Stories</title>
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
}
?>
</div>
</header>
<hr>
<main>
<div class="box-margin">
<h1>My Stories</h1>
<?php
list_stories($_SESSION['user_id']);
?>
</div>
</main>
</body>
</html>