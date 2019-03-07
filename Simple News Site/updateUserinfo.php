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
    if($_POST['action']=='ChangeUsername'){
        if(!isset($_POST['newUsername'])){
            echo "No access to this page!\n";
            exit;
        }
        $newUsername = $_POST['newUsername'];
        $uid = $_SESSION['user_id'];
        if(userExists($username)){
            echo "username already used!";
            exit;
        }
        if(update_username($uid,$newUsername)){
            echo "Change Username Successfully!<br>
            <a href='news.php'>Click to refresh!</a>
            ";
        }
        else{
            echo "Change Username Failed!";
        }
    }else if($_POST['action']=='ChangeUserPwd'){
        if(!isset($_POST['newPasswd']) || !isset($_POST['oldPasswd'])||!isset($_POST['newRePasswd'])){
            echo "No access to this page!\n";
            exit;
        }
        $newPwd = $_POST['newPasswd'];
        $newRePwd = $_POST['newRePasswd'];
        $oldPwd = $_POST['oldPasswd'];
        if(!($newPwd===$newRePwd)){
            echo 'Different Passwords, Please check again!';
            exit;
        }
        $uid = $_SESSION['user_id'];
        if(update_passwd($uid,$oldPwd,$newPwd)){
            echo "Change Password Successfully!<br>
            <a href='news.php'>Click to refresh!</a>
            ";
        }
        else{
            echo "Change Password Failed!";
        }
    }
?>
</div>
</main>
</body>
</html>