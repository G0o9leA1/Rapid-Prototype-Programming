<?php
    require 'database.php';
    include 'functions.php';
    session_start();

    if(!hash_equals($_SESSION['token'], $_POST['token'])){
        die("Request forgery detected");
    }

    if ($_POST['action'] == "add_story") {
        $title = $_POST['title'];
        $story = $_POST['story'];
        $link = $_POST['link'];
        $stmt = $mysqli->prepare("insert into stories (user_id, title, story, link) values (?, ?, ?, ?)");
        if(!$stmt){
            printf("Query Prep Failed: %s\n", $mysqli->error);
            exit;
        }
        $stmt->bind_param('isss', $_SESSION['user_id'], $title, $story, $link);
        $stmt->execute();
        $stmt->close();

        back2NewsPage();
    }
?>