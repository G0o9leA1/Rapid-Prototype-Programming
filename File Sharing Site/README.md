# Module2: File Sharing Site

![alt text](https://img.shields.io/badge/HTML-5.0-green.svg)  
![alt text](https://img.shields.io/badge/CSS-red.svg)
![alt text](https://img.shields.io/badge/php-7.0-blue.svg)
![alt text](https://img.shields.io/badge/apache-2.0-green.svg)
![alt text](https://img.shields.io/badge/W3C-passed-blue.svg)
#

## Required Features

### File Management (25 Points):
- Users should not be able to see any files until they enter a username and log in (4 points)
- Remember that users.txt should be stored in a secure location on your filesystem. That is, you should not be able to type any URL into your browser and see the raw users.txt file!
- Users can see a list of all files they have uploaded (4 points)
- Users can open files they have previously uploaded (5 points)
Note: Users should be able to open not only plain text files but also other file formats: images, spreadsheets, etc.
- Users can upload files (4 points)
Note: Like users.txt, uploaded files should be stored in a secure location on your filesystem. That is, do not keep your uploads directory underneath a directory served by Apache!
- Users can delete files. If a file is "deleted", it should actually be removed from the filesystem (4 points)
- The directory structure is hidden. Users should not be able to access or view files by manipulating a URL. (2 points)
- Users can log out (2 points)
Note: If using session variables, you must actually log out the user by destroying their session; i.e., don't just redirect them to the login screen.
### Best Practices (10 Points):
- Code is well formatted and easy to read, with proper commenting (4 points)
- The site follows the FIEO philosophy (3 points)
- All pages pass the W3C validator (3 points)
### Usability (5 Points):
- Site is intuitive to use and navigate (4 points)
- Site is visually appealing (1 point)

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

http://ec2-3-17-140-54.us-east-2.compute.amazonaws.com/~group/module2/index.php
