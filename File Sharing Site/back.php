<?php
    include "functions.php";
    session_start();
    $slashpos = strrpos($_SESSION["user_dir"], "/");
    $_SESSION["user_dir"] = substr($_SESSION["user_dir"], 0, $slashpos);
    back2FilePage();
?>