<?php
    include "functions.php";
    session_start();
    $_SESSION["user_dir"] .= "/".$_POST["dir"];
    back2FilePage();
?>