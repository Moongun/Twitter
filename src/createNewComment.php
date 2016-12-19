<?php
session_start();

require_once 'Comment.php';
require_once 'LogToDB.php';




//      CREATING NEW COMMENT
if($_SERVER['REQUEST_METHOD']=='POST'){
    if(!empty($_POST['sendComment'])){
        $newCommentText=$_POST['Comment'];

        $newComment = new Comment();
        $newComment->setUserId($_SESSION['id']);
        $newComment->setPostId($_SESSION['tweetId']);
        $newComment->setText($newCommentText);
        $newComment->setCreationDate(date("Y-m-d H:i:s"));
        if($newComment->saveToDB($db)){
            header('Location: ../web/TweetPage.php');
        }else{
            echo "Cannot insert new comment.";
        }

    }
}
?>