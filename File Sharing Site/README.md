# Module2-Group

![alt text](https://img.shields.io/badge/php-7.0-blue.svg)
![alt text](https://img.shields.io/badge/apache-2.0-green.svg)
#
http://ec2-3-17-140-54.us-east-2.compute.amazonaws.com/~group/module2/index.php

## Required Features
* Log in: enter your username and click "Sign in"
* A list of files is displayed.
* Open file: click "View" beside the file you want to open
* Upload file: choose the file you want to upload and click "Upload"
* Delete file: click "Delete" beside the file you want to delete
* The directory structure is hidden.
* Log out: click "Sign out"

## Creative Portion
1. Folder
	* Create: enter the valid folder name and click "Create" to create a folder at the current location
	* Enter: click "Enter" beside the folder to visit the folder
	* Back: click "Back" beside the current location to change directory up one level
	* Delete: click "Delete" beside the folder to delete the entire folder

2. Registration
	* Users can register as a new user for the site: enter the valid username and click "Register", and then login with that username.

3. File Sending
	* Users can send a file to an existing user: enter the valid username beside the file you want to send and click "Send". If user1 sends a file to user2, the file will be saved under the folder /user2/from_user1.

## Login Details
* **Preset username: user1, user2, user3, user4**
* Valid username: the username is only allowed to contain letters within "0-9, a-z, A-Z, _, -"
* Valid filename (and foldername): the filename or the foldername is only allowed to contain letters within "0-9, a-z, A-Z, _, ., -"
* The prompt message (e.g. error message) is displayed at the bottom.
