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
<?php
$story_info = get_story($story_id);
$title = $story_info[0];
$story = $story_info[1];
$link = $story_info[2];
?>
<div class="box-margin">
<form action="story.php" method="POST">
<input type="hidden" name="story_id" value="<?php echo $story_id;?>"/>
<input type="submit" class="btn-reset" value="Back"/>
</form>
<h1>Edit a Story</h1>
<div>
<form method='POST' action='storyHandler.php'>
    <input type="hidden" name="action" value="edit"/>
    <input type="hidden" name="story_id" value="<?php echo $story_id;?>"/>
    <input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
    <div>
        <input type="text" name="title" id="edit-title" value="<?php echo $title; ?>"/> 
    </div>
    <div>
        <input type="url" name="link" id="edit-link" value="<?php echo $link; ?>"/> 
    </div>
    <div>
        <textarea name="story" id="edit-story"><?php echo $story; ?></textarea> 
    </div>
    <div>
        <input type="submit" value="Submit"/>
    </div>
</form>
</div>
</div>
</main>
</body>
</html>