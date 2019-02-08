<?php
	function back2FilePage() {
		header("Location: file.php");
		exit;
	}

	function back2IndexPage() {
		header("Location: index.php");
		exit;
	}

	function checkUserName($username) {
		if( !preg_match('/^[\w_\-]+$/', $username) ){
			return false;
		} else {
			return true;
		}
	}

	function checkFileName($filename) {
		if( !preg_match('/^[\w_\.\-]+$/', $filename) ){
			return false;
		} else {
			return true;
		}
	}

	function delete($path, $counter = 0) {
		if (!is_dir($path)) {
			if (!unlink($path)) {
				$_SESSION["msg"] = "Failed to delete";
				back2FilePage();
			}
		} else {
			$directory = opendir($path);
			while (($file = readdir($directory)) !== false) {
				$full_path = $path . '/'. $file;
				if ($file == '.' || $file == '..') {
					continue;
				} else {
					delete($full_path, counter+1);
				}
			}
			closedir($directory);
			if (!rmdir($path)) {
				$_SESSION["msg"] = "Failed to delete";
				back2FilePage();
			} 
		}
		if ($counter == 0) {
			$_SESSION["msg"] = "Deleted successfully";
			back2FilePage();
		}
	}

	function getUsersList() {
		$file = fopen("/home/group/users.txt", "r");
		$list = array();
		while (!feof($file)) {
			array_push($list, trim(fgets($file)));
		}
		array_pop($list); // remove the empty line
		fclose($file);
		return $list;
	}
?>
