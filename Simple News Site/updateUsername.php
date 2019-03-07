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
} 
?>
</div>
</header>
<hr>
<main>
<div class="box-margin">
<div id="index-username">
<?php
echo 'Old Username: '.$_SESSION['username'];
$username=$_SESSION['username'];
?>
<br>

<form action='updateUserinfo.php' method='POST'>
<input type='hidden' name='action' value='ChangeUsername'><br>
<input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
<input name='newUsername' placeholder='Please enter your new username' size="30"><br><br>

<?php
echo "
<input type='hidden' value='$username'>
";
?>
<input class='btn-reset' type='submit' value='submit'>
</form>
</div>
</div>
</main>
</body>
</html>