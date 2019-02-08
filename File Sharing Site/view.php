<?php
include "functions.php";
session_start();

$filename = $_POST["filename"];
$full_path = sprintf("%s/%s/%s", $_SESSION["base_dir"], $_SESSION["user_dir"], $filename);

// Now we need to get the MIME type (e.g., image/jpeg). PHP provides a neat little interface to do this called finfo.
$finfo = new finfo(FILEINFO_MIME_TYPE);
$mime = $finfo->file($full_path);

if ($mime=="inode/x-empty"){
    $_SESSION["msg"] = "Empty File cannot be viewed";
	back2FilePage();
}
// Finally, set the Content-Type header to the MIME type of the file, and display the file.
if (strpos($mime,'text')===false && strpos($mime,'image')===false && strpos($mime,'application/pdf')===false) {
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="'.basename($full_path).'"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($full_path));
}
else header("Content-Type: ".$mime);
readfile($full_path);
?>