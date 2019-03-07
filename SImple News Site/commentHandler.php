<?php
    include 'functions.php';
    session_start();
    if(!hash_equals($_SESSION['token'], $_POST['token'])){
        die("Request forgery detected");
    }
    if (!isset($_POST['story_id']) || !isset($_POST['action'])) {
        echo "No access to this page!\n";
        exit;
    }
    $story_id = $_POST['story_id'];
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
    $comment = $_POST['comment'];
    if (empty($comment)) {
        echo "<p>You cannot add an empty comment!<p>";
    } else if (add_comment($story_id, $comment)) {
        echo "<p>Commented successfully!</p>\n";
    } else {
        echo "<p>Failed to comment!</p>\n";
    }
} else if ($action === "edit") {
    $comment_id = $_POST['comment_id'];
    $comment = $_POST['comment'];
    if (empty($comment)) {
        echo "<p>You cannot update to an empty comment!<p>";
    } else if (update_comment($comment_id, $comment)) {
        echo "<p>Updated successfully!</p>\n";
    } else {
        echo "<p>Failed to update!</p>\n";
    }
} else if ($action === "delete") {
    $comment_id = $_POST['comment_id'];
    if (delete_comment($comment_id)) {
        echo "<p>Deleted successfully!</p>\n";
    } else {
        echo "<p>Failed to delete!</p>\n";
    }
}
?>
<br>
<form action="story.php" method="POST">
<input type="hidden" name="story_id" value="<?php echo $story_id; ?>"/>
<input type="submit" class="btn-reset" value="Back to Story"/>
</form>
</div>
</main>
</body>
</html>