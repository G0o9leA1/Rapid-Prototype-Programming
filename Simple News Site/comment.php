<?php
    include 'functions.php';
    session_start();
    if (!isset($_POST['story_id'])) {
        echo "No access to this page!\n";
        exit;
    }
    $story_id = $_POST['story_id'];
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
    printf("<p>Hello, %s!</p>\n", htmlentities($_SESSION['username'])); // hello message
    echo "<br>\n";
    echo '<a href="logout.php" id="sign-out">Sign out</a>';
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
<main>
<div class="box-margin">
<?php
if (add_comment()) {
    echo "Comment successfully\n";
} else {
    echo "Comment failed\n";
}
?>
<form action="story.php" method="POST">
<input type="hidden" name="story_id" value="<?php echo $story_id; ?>"/>
<input type="submit" value="Back to Story"/>
</form>
</div>
</main>
</body>
</html>