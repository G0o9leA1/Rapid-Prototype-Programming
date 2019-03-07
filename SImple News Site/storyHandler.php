<?php
    include 'functions.php';
    session_start();
    if(!hash_equals($_SESSION['token'], $_POST['token'])){
        die("Request forgery detected");
    }
    if (!isset($_POST['action'])) {
        echo "No access to this page!\n";
        exit;
    }
    $action = $_POST['action'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Comment</title>
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
<div>
<?php
if ($action === "add") {
    $title = $_POST['title'];
    $link = $_POST['link'];
    $story = $_POST['story'];
    if (empty($title)) {
        echo "<p>You cannot add a story with empty title!<p>";
    } else if (add_story($title, $story, $link)) {
        echo "<p>Created successfully!</p>\n";
    } else {
        echo "<p>Failed to create!</p>\n";
    }
} else if ($action === "edit") {
    $story_id = $_POST['story_id'];
    $title = $_POST['title'];
    $link = $_POST['link'];
    $story = $_POST['story'];
    if (update_story($story_id, $title, $story, $link)) {
        echo "<p>Updated successfully!</p>\n";
    } else {
        echo "<p>Failed to update!</p>\n";
    }
} else if ($action === "delete") {
    $story_id = $_POST['story_id'];
    if (delete_story($story_id)) {
        echo "<p>Deleted successfully!</p>\n";
    } else {
        echo "<p>Failed to delete!</p>\n";
    }
}
?>
<br>
<?php
    if ($action === "delete" || $action === "add") {
        echo "<form action='myStories.php' method='POST'>
        <input type='submit' class='btn-reset' value='Back to My Stories'/>
        </form>";
    } else if ($action === "edit") {
        echo "<form action='story.php' method='POST'>
        <input type='hidden' name='story_id' value=$story_id/>
        <input type='submit' class='btn-reset' value='Back to My Story'/>
        </form>";
    }
?>
</div>
</main>
</body>
</html>