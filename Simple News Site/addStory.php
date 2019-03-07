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
    <title>Add a Story</title>
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
<h1>Add a Story</h1>
<div>
<form method='POST' action='storyHandler.php'>
    <input type="hidden" name="action" value="add"/>
    <input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
    <div>
        <input type="text" name="title" id="title-input" placeholder="Your title here"/> 
    </div>
    <div>
        <input type="url" name="link" id="link-input" placeholder="Your link here"/> 
    </div>
    <div>
        <textarea name="story" id="story-input" placeholder="Your story here"></textarea> 
    </div>
    <div>
        <input type="submit" name="addstory" value="Add a Story"/>
    </div>
</form>
</div>
</div>
</main>
</body>
</html>