<?php
    include 'functions.php';
    session_start();
    if (!isset($_POST['story_id'])) {
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
    <title>Story</title>
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
<?php
list_a_story($_POST['story_id']);
list_comments($_POST['story_id']);
if($_SESSION['user_id']!=0){
    $story_id = $_POST['story_id'];
    $token = $_SESSION['token'];
    echo"
    <form method='POST' action='commentHandler.php'>
    <input type='hidden' name='token' value=$token>
    <input type='hidden' name='action' value='add'/>
    <input type='hidden' name='story_id' value=$story_id>
    <textarea name='comment' placeholder='Your comment here' id='comment-input'></textarea><br>
    <input type='submit' value='Comment'/>
    </form> 
    ";
}
?>
</div>
</main>
</body>
</html>