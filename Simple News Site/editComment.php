<?php
    include 'functions.php';
    session_start();
    if (!isset($_POST['story_id']) || !isset($_POST['comment_id'])) {
        echo "No access to this page!\n";
        exit;
    }
    $story_id = $_POST['story_id'];
    $comment_id = $_POST['comment_id'];
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
<div class="box-margin">
<form action="story.php" method="POST">
<input type="hidden" name="story_id" value="<?php echo $story_id;?>"/>
<input type="submit" class="btn-reset" value="Back"/>
</form>
<h1>Edit a Story</h1>
<form action="commentHandler.php" method="POST">
<input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
<input type="hidden" name="action" value="edit"/>
<input type="hidden" name="story_id" value="<?php echo $story_id; ?>"/>
<input type="hidden" name="comment_id" value="<?php echo $comment_id; ?>"/>
<textarea name="comment" id="edit-comment"><?php echo get_comment($comment_id); ?></textarea>
<input type="submit" value="Submit"/>
</form>
</div>
</main>
</body>
</html>