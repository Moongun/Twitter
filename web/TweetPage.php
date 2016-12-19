<?php
session_start();

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>TWITTER</title>
    </head>
    <body>
        <h1>Tweet Page</h1>
        <?php 
        echo $_SESSION['username'].', check out your Messages!';
        ?>
        <ul>
            <li><a href="MainPage.php">Main Page</a></li>
            <li><a href="yourProfile.php">Edit your Profile</a></li>
            <li><a href="logout.php">logout</a></li>
            <li><a href="messagesPage.php">your Messages</a></li>
            <li><a href="createMessage.php">create new Message</a></li>
        </ul>
        
        <?php
        require '../src/Tweet.php';
        require '../src/User.php';
        require '../src/Message.php';
        require '../src/Comment.php';
        
        
        if($_SERVER['REQUEST_METHOD']=='POST'){
            if(isset($_POST['tweetId'])){
                $tweetId=$_POST['tweetId'];
            }
        }
//        COLLECTING INFO ABOUT AUTHOR OF CHOOSEN TWEET
        $thisTweet=Tweet::loadTweetById($db, $tweetId);
        $authorId=$thisTweet->getUserId();
        $tweetText=$thisTweet->getText();
        $author=  User::loadUserById($db, $authorId);
        $authorName=$author->getUsername();
        
        echo "<h3>USER: </h3><h4>$authorName</h4><br><h3>POSTED: </h3><h4>$tweetText<br/><br/><br/><br/>";
        
//       GENERATING TABLE WITH COMMENTS TO CHOOSEN TWEET
        $loadedComments=Comment::loadAllCommentsByTweetId($db, $tweetId);
        if($loadedComments!=false){
        echo "ANSWERS:<br/><br/>"
            . "<table style='border:solid 1px'>";
        foreach ($loadedComments as $comment){
            $comAuthorId=User::loadUserById($db, $comment->getUserId());
            $comAuthorName=$comAuthorId->getUsername();
            $comText=$comment->getText();
            $comDate=$comment->getCreationDate();
            echo "<tr><td style='border:solid 1px '>$comAuthorName</td><td style='border:solid 1px '>$comText</td><td style='border:solid 1px '>$comDate</td></tr>";
        }
        echo "</table>";
        }else{
            echo "<br><br><br><br>lack of comments.<br><br><br><br>";
        }
        
        ?>
        
        
        <div>Add your comment:
            <form action ="#" method="POST">
                <textarea style="width:400px; height:100px;" name="Comment" value="Wpisz komentarz" maxlength="60"></textarea><br/>
                    <?php echo '<input type="hidden" name="tweetId" value='.$tweetId.'>';?>
                    <input type="submit" name="sendComment" value="Send your Comment">
            </form>
        </div>
        <?php
//      CREATING NEW COMMENT
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (!empty($_POST['sendComment'])) {
                $newCommentText = $_POST['Comment'];

                $newComment = new Comment();
                $newComment->setUserId($_SESSION['id']);
                $newComment->setPostId($_SESSION['tweetId']);
                $newComment->setText($newCommentText);
                $newComment->setCreationDate(date("Y-m-d H:i:s"));
                if ($newComment->saveToDB($db)) {
                    header('Location: ../web/TweetPage.php');
                } else {
                    echo "Cannot insert new comment.";
                }
            }
        }
        ?>
    </body>
</html>
