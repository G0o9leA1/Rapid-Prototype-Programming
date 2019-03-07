<?php
    //Return to news.php
	function back2NewsPage() {
		header('Location: news.php');
		exit;
    }
    
    //Return to index.php
	function back2IndexPage() {
		header('Location: index.php');
		exit;
    }
    
    //Return to register.php
    function back2RegisterPage() {
		header('Location: register.php');
		exit;
    }
    
    //Return to myStories.php
	function back2MyPage() {
		header('Location: myStories.php');
		exit;
    }

	function checkUserName($username) {
		if( !preg_match('/^[\w_\-]+$/', $username) ){
			return false;
		} else {
			return true;
		}
    }

    function logout() {
        header('Location: logout.php');
    }

    //Check whether username already exists
    function userExists($username) {
        require 'database.php';
        $stmt = $mysqli->prepare("SELECT COUNT(*) FROM users WHERE username=?");
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $stmt->bind_result($cnt);
        $stmt->fetch();
        $stmt->close();
        return $cnt != 0 ? true : false;
    }
    
    //Display comments associated with a story
    function list_comments($story_id){
        require 'database.php';
        $stmt = $mysqli->prepare("SELECT comment,username,comments.user_id,comments.id,timestamp FROM comments join users on (comments.user_id=users.id) WHERE story_id=? ORDER BY timestamp DESC");
        $stmt->bind_param('i', $story_id);
        $stmt->execute();
        $stmt->bind_result($comment,$author,$user_id,$comment_id,$datetime);
        echo "<h1>Comments</h1>\n";
        echo "<div class='flex-container'>";
        while ($stmt->fetch()){
            echo "<div class='flex-item'>";
            printf("<p><u><i>%s</i> last edited on %s</u></p>", $author, $datetime);
            if ($user_id==$_SESSION['user_id']){
                echo "
                <form action='editComment.php' method='POST'>
                <input type='hidden' name='story_id' value=$story_id>
                <input type='hidden' name='comment_id' value=$comment_id>
                <input class='btn-reset' type='submit' value='Edit'/>
                </form>
                ";
                $token = $_SESSION['token'];
                echo "
                <form action='commentHandler.php' method='POST'>
                <input type='hidden' name='token' value=$token>
                <input type='hidden' name='story_id' value=$story_id>
                <input type='hidden' name='action' value='delete'/>
                <input type='hidden' name='comment_id' value=$comment_id>
                <input class='btn-reset' type='submit' value='Delete'/>
                </form>
                ";
            }
            $comment = str_replace("\n", "<br>", htmlentities($comment));
            printf("<br><p>%s</p>", $comment);
            echo "</div>";
            echo "<hr>";
        }
        echo "</div>";
    }
    
    function add_comment($story_id,$comment){
        require 'database.php';
        $user_id = $_SESSION['user_id'];
        $stmt = $mysqli->prepare("insert into comments (user_id, story_id, comment) values (?, ?, ?)");
        if(!$stmt){
            printf("Query Prep Failed: %s\n", $mysqli->error);
            exit;
        }
        $stmt->bind_param('iis', $user_id, $story_id, $comment);
        if(!$stmt->execute()) 
        {  
            $stmt->close();
            return false;
        }
        $stmt->close();
        return true;
    }
    
    //edit comment
    function update_comment($comment_id,$comment){
        require 'database.php';
        $stmt = $mysqli->prepare("UPDATE comments SET comment=?, timestamp=CURRENT_TIMESTAMP WHERE id=?");
        if(!$stmt){
            printf("Query Prep Failed: %s\n", $mysqli->error);
            exit;
        }
        $stmt->bind_param('si', $comment,$comment_id);
        if(!$stmt->execute()) 
        {  
            $stmt->close();
            return false;
        }
        $stmt->close();
        return true;
    }

    function update_story($story_id,$title,$story,$link){
        require 'database.php';
        $stmt = $mysqli->prepare("UPDATE stories SET title=?,story=?,link=?, timestamp=CURRENT_TIMESTAMP WHERE id=?");
        if(!$stmt){
            printf("Query Prep Failed: %s\n", $mysqli->error);
            exit;
        }
        $stmt->bind_param('sssi', $title,$story,$link,$story_id);
        if(!$stmt->execute()) 
        {  
            $stmt->close();
            return false;
        }
        $stmt->close();
        return true;
    }

    function delete_comment($comment_id){
        require 'database.php';
        $stmt = $mysqli->prepare("DELETE from comments WHERE id=?");
        if(!$stmt){
            printf("Query Prep Failed: %s\n", $mysqli->error);
            exit;
        }
        $stmt->bind_param('i', $comment_id);
        if(!$stmt->execute()) 
        {  
            $stmt->close();
            return false;
        }
        $stmt->close();
        return true;
    }
    
    function delete_story($story_id){
        require 'database.php';
        if(!delete_comments($story_id)) return false;
        $stmt = $mysqli->prepare("DELETE from stories WHERE id=?");
        if(!$stmt){
            printf("Query Prep Failed: %s\n", $mysqli->error);
            exit;
        }
        $stmt->bind_param('i', $story_id);
        if(!$stmt->execute()) 
        {  
            $stmt->close();
            return false;
        }
        $stmt->close();
        return true;
    }

    function delete_comments($story_id){
        require 'database.php';
        $stmt = $mysqli->prepare("DELETE from comments WHERE story_id=?");
        if(!$stmt){
            printf("Query Prep Failed: %s\n", $mysqli->error);
            exit;
        }
        $stmt->bind_param('i', $story_id);
        if(!$stmt->execute()) 
        {  
            $stmt->close();
            return false;
        }
        $stmt->close();
        return true;
    }


    //return a specific comment
    function get_comment($comment_id){
        require 'database.php';
        $stmt = $mysqli->prepare("SELECT comment FROM comments WHERE id=?");
        $stmt->bind_param('i', $comment_id);
        $stmt->execute();
        $stmt->bind_result($comment);
        if(!$stmt->fetch()) 
        {  
            $stmt->close();
            return false;
        }
        $stmt->close();
        return $comment;
    }

    function get_username($user_id) {
        require 'database.php';
        $stmt = $mysqli->prepare("SELECT username FROM users WHERE id=?");
        $stmt->bind_param('i', $user_id);
        $stmt->execute();
        $stmt->bind_result($username);
        $stmt->fetch();
        $stmt->close();
        return $username;
    }

    //Display all stories posted by specific user
    function list_stories($user_id) {
        require 'database.php';
        //$user_id!=0 means login as guest
        if ($user_id != 0) {
            $stmt = $mysqli->prepare("SELECT user_id, title, story, link, id, timestamp FROM stories WHERE user_id=? ORDER BY timestamp DESC");
            $stmt->bind_param('i', $user_id);
        } else {
            $stmt = $mysqli->prepare("SELECT user_id, title, story, link, id, timestamp FROM stories ORDER BY timestamp DESC");
        }
        $stmt->execute();
        $stmt->bind_result($uid, $title, $story, $link, $story_id, $ts);
        echo "<hr>\n";
        echo "<div class=\"flex-container\">\n";
        while ($stmt->fetch()) {
            $author = get_username($uid);
            printf("\t<div class=\"flex-item\">");
            printf("<form action=\"story.php\" method=\"POST\">\n");
            printf("<input type=\"hidden\" name=\"story_id\" value=\"%d\"/>\n", $story_id);
            printf("<input class=\"btn-reset\" id=\"news-title\" type=\"submit\" value=\"%s\"/>\n", htmlentities($title));
            printf("</form>\n");
            $cnt_comment = get_comment_num($story_id);
            if ($cnt_comment > 1) {
                $cnt_string = $cnt_comment." comments";
            } else {
                $cnt_string = $cnt_comment." comment";
            }
            printf("<br><p class=\"story-info\"><u><i>%s</i> last edited on %s | %s</u></p><br>", htmlentities($author), $ts, $cnt_string);
            if (!empty($link)) {
                printf("<a href=\"%s\">%s</a><br>\n", htmlentities($link), htmlentities($link));
            }
            $story = str_replace("\n", "<br>", htmlentities($story));
            $str = substr($story,0,255);
            if (strlen($story) > 255) {
                $str .= "...";
            }
            printf("<br><p>%s</p>", $str);
            printf("</div>\n");

            echo "<hr>\n";
        }
        echo "</div>\n";
        $stmt->close();
    }
    
    //Display a formatted story
    function list_a_story($story_id) {
        require 'database.php';
        $stmt = $mysqli->prepare("SELECT stories.id,stories.user_id,title,story,link,timestamp,users.username FROM stories join users on stories.user_id=users.id WHERE stories.id=?");
        if(!$stmt){
            printf("Query Prep Failed: %s\n", $mysqli->error);
            exit;
        }
        $stmt->bind_param('i', $story_id);
        $stmt->execute();
        $stmt->bind_result($story_id,$user_id,$title, $story, $link, $ts, $author);
        $stmt->fetch();
        $stmt->close(); 
        if ($user_id==$_SESSION['user_id']){
            echo "
            <form action='editStory.php' method='POST'>
            <input type='hidden' name='story_id' value=$story_id>
            <input class='btn-reset' type='submit' value='Edit'>
            </form>
            ";
            $token = $_SESSION['token'];
            echo "
            <form action='storyHandler.php' method='POST'>
            <input type='hidden' name='token' value=$token>
            <input type='hidden' name='story_id' value=$story_id>
            <input type='hidden' name='action' value='delete'>
            <input class='btn-reset' type='submit' value='Delete'>
            </form>
            ";
        }
        printf("<h1>%s</h1>", htmlentities($title));
        echo'<br>';
        $cnt_comment = get_comment_num($story_id);
        if ($cnt_comment > 1) {
            $cnt_string = $cnt_comment." comments";
        } else {
            $cnt_string = $cnt_comment." comment";
        }
        printf("<p class=\"story-info\"><i>%s</i> last edited on %s | %s</p><br>", htmlentities($author), $ts, $cnt_string);
        if (!empty($link)) {
            printf("<a href=\"%s\">%s</a><br>\n", htmlentities($link), htmlentities($link));
        }
        printf("<hr>\n");
        $story = str_replace("\n", "<br>", htmlentities($story));
        printf('<p>%s</p>', $story);
        printf('<hr>');
    }
    
    //Return a story in array format
    function get_story($story_id){
        require 'database.php';
        $stmt = $mysqli->prepare("SELECT title,story,link FROM stories WHERE id=?");
        if(!$stmt){
            printf("Query Prep Failed: %s\n", $mysqli->error);
            exit;
        }
        $stmt->bind_param('i', $story_id);
        $stmt->execute();
        $stmt->bind_result($title, $story, $link);
        if(!$stmt->fetch()) 
        {  
            $stmt->close();
            return false;
        }
        $stmt->close();
        return array($title, $story, $link);
    }

    function add_story($title,$story,$link) {
        require 'database.php';
        $stmt = $mysqli->prepare("insert into stories (user_id, title, story, link) values (?, ?, ?, ?)");
        if(!$stmt){
            printf("Query Prep Failed: %s\n", $mysqli->error);
            exit;
        }
        $stmt->bind_param('isss', $_SESSION['user_id'], $title, $story, $link);
        if(!$stmt->execute()) 
        {  
            $stmt->close();
            return false;
        }
        $stmt->close();
        return true;
    }

    //Return numbers of comments 
    function get_comment_num($story_id) {
        require 'database.php';
        $stmt = $mysqli->prepare("SELECT COUNT(*) FROM comments WHERE story_id=?");
        if(!$stmt){
            printf("Query Prep Failed: %s\n", $mysqli->error);
            exit;
        }
        $stmt->bind_param('i', $story_id);
        $stmt->execute();
        $stmt->bind_result($cnt);
        $stmt->fetch();
        $stmt->close();
        return $cnt;
    }
    
    //left headler info construstor
    function list_header_left() {
        printf("<p>Hello, %s!</p>\n", htmlentities($_SESSION['username'])); // hello message
        echo "<br>\n";
        echo '<a href="logout.php" id="sign-out">Sign out</a>';
    }

    //right headler info construstor
    function list_header_right() {
        echo '<a href="addStory.php" id="link-to-add-story">Add a Story</a>
        <span>|</span>
        <a href="news.php" id="link-to-all-stories">All Stories</a>
        <span>|</span>
        <a href="myStories.php" id="link-to-my-stories">My Stories</a>
        <span>|</span>
        <a href="setting.php" id="link-to-setting">Setting</a>';
    }

    function list_header_right_guest() {
        echo '<a href="news.php" id="link-to-all-stories">All Stories</a>';
    }

    function update_username($uid,$newUsername){
        require 'database.php';
        $stmt = $mysqli->prepare("UPDATE users SET username=? WHERE id=?");
        if(!$stmt){
            printf("Query Prep Failed: %s\n", $mysqli->error);
            exit;
        }
        $stmt->bind_param('si', $newUsername,$uid);
        if(!$stmt->execute()) 
        {  
            $stmt->close();
            return false;
        }
        $stmt->close();
        $_SESSION['username']=$newUsername;
        return true;
    }
    function update_passwd($uid,$oldPwd,$newPwd){
        require 'database.php';
        $stmt = $mysqli->prepare("SELECT hashed_password FROM users WHERE id=?");
        // Bind the parameter
        $stmt->bind_param('s', $uid);
        $stmt->execute();

        // Bind the results
        $stmt->bind_result($pwd_hash);
        $stmt->fetch();
        $stmt->close();
        // Compare the submitted password to the actual password hash
        if(password_verify($oldPwd, $pwd_hash)){
            $stmt = $mysqli->prepare("UPDATE users SET hashed_password=? WHERE id=?");
            // Bind the parameter
            $hashed_password=password_hash($newPwd, PASSWORD_DEFAULT);
            $stmt->bind_param('ss', $hashed_password,$uid);
            if($stmt->execute()){
                $stmt->close();
                return true;
            }
            else{
                $stmt->close();
                return false;
            }
        }
        else{
            return false;
        }
    }

?>