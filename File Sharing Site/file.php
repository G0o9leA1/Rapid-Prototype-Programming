<?php
    include "functions.php";
    session_start();
    // make sure the user signs in from the login page
    if (!isset($_SESSION["username"])) {
        $_SESSION["validUser"] = false;
        $_SESSION["msg"] = "Sorry, no Access to this page";
    } else {
        $_SESSION["validUser"] = true;
        $username = $_SESSION["username"];
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>File</title>
    <link rel="stylesheet" type="text/css" href="style.css" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
</head>
<body>
<!-- Logout button -->
<form action="logout.php" method="POST">
    <p><input type="submit" class="signbutton" value="Sign out"/></p>
</form>
<?php
if (!$_SESSION["validUser"]) {
    echo "</body>\n";
    echo "</html>\n";
    exit;
}
// display the file list associated with the login user
// print hello msg
printf("<div>\n");
printf("<h1>Hello, %s!</h1>\n", htmlentities($username));
if (!isset($_SESSION["user_dir"])) {
    $_SESSION["user_dir"] = $username; 
}
$current_dir = $_SESSION["base_dir"].$_SESSION["user_dir"];

// print the current directory
printf("<p>Current Location: /%s</p>\n", $_SESSION["user_dir"]);
// back button
if (strpos($_SESSION["user_dir"], "/") != false) {
    printf("<form action=\"back.php\" method=\"POST\">\n");
    printf("<input type=\"submit\" value=\"Back\">\n");
    printf("</form>\n");
}
printf("<hr>\n");
list_files($current_dir);
printf("<hr>\n");
?>
<!-- create folder button -->
<div class="left">
<form action="createfolder.php" method="POST">
    <label for="folder_input">Create a new folder:</label>
    <input type="text" name="foldername" id="folder_input" placeholder="Folder Name"/>
    <input type="submit" value="Create"/> 
</form>
</div>
<!-- upload button -->
<div class="left">
<form enctype="multipart/form-data" action="upload.php" method="POST">
    <label for="uploadfile_input">Choose a file to upload:</label>
    <input type="file" name="uploadedfile" id="uploadfile_input"/>
    <input type="submit" value="Upload"/> 
</form>
</div>
</div>
<?php
// display message
if (isset($_SESSION["msg"])) {
    printf("<p class=\"message\">%s</p>\n", $_SESSION["msg"]);
    unset($_SESSION["msg"]);
}
?>
</body>
</html>

<?php
function list_files($path) {
    printf("<div class=\"left\">\n");
    $directory = opendir($path);
    $files = array();
    while (($file = readdir($directory)) !== false) {
        $full_path = $path . "/" . $file;
        if ($file == '.' || $file == '..') {
            continue;
        } elseif (is_dir($full_path)) { // folder
            printf("<div class=\"left item\"><p><i class=\"fas fa-folder\"></i>%s</p>\n", $file);
            printf("<form action=\"enter.php\" method=\"POST\">\n");
            printf("<input type=\"hidden\" value=\"%s\" name=\"dir\" />\n", $file);
            printf("<input type=\"submit\" value=\"Enter\" />\n");
            printf("</form>\n");
            printf("<form action=\"delete.php\" method=\"POST\" >\n");
            printf("<input type=\"hidden\" value=\"%s\" name=\"deletedfile\" />\n", $file);
            printf("<input type=\"submit\" value=\"Delete\" />\n");
            printf("</form>\n");
            printf("</div>\n");
        } else { // file
            array_push($files, $file);
        }
    }
    // display files
    for ($i = 0; $i < count($files); $i++) {
        printf("<div class=\"left item\"><p><i class=\"fas fa-file\"></i>%s</p>\n", $files[$i]);
        printf("<form action=\"view.php\" method=\"POST\" target=\"_blank\">\n");
        printf("<input type=\"hidden\" value=\"%s\" name=\"filename\" />\n", $files[$i]);
        printf("<input type=\"submit\" value=\"View\" />\n");
        printf("</form>\n");
        printf("<form action=\"delete.php\" method=\"POST\">\n");
        printf("<input type=\"hidden\" value=\"%s\" name=\"deletedfile\" />\n", $files[$i]);
        printf("<input type=\"submit\" value=\"Delete\" />\n");
        printf("</form>\n");
        printf("<form action=\"sender.php\" method=\"POST\">\n");
        printf("<label for=\"uname%d\">Send to:</label>\n", $i);
        printf("<input type=\"text\" name=\"receiver\" placeholder=\"User Name\" id=\"uname%d\" />\n", $i);
        printf("<input type=\"hidden\" value=\"%s\" name=\"filename\" />\n", $files[$i]);
        printf("<input type=\"submit\" value=\"Send\" />\n");
        printf("</form>\n");
        printf("</div>\n");
    }
    closedir($directory);
    printf("</div>\n");
}
?>