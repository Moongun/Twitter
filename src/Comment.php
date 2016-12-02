<?php
$db=new mysqli('localhost', 'root', 'coderslab', 'Twitter');

if($db->connect_error){
    die("Connection failed. Error: ".$db->connect_error);
}else{
//    echo "Connected.<br><br>";
}


class Comment{
    private $id;
    private $userId;
    private $postId;
    private $creationDate;
    private $text;




    public function __construct() {
        $this->id=-1;
        $this->userId="";
        $this->postId="";
        $this->creationDate="";
        $this->text="";
    }
    
    public function setUserId($userId) {
        $this->userId = $userId;
    }

    public function setPostId($postId) {
        $this->postId = $postId;
    }

    public function setCreationDate($creationDate) {
        $this->creationDate = $creationDate;
    }

    public function setText($text) {
        $this->text = $text;
    }

    public function getId(){
        return $this->id;
    }
    
    public function getUserId() {
        return $this->userId;
    }

    public function getPostId() {
        return $this->postId;
    }

    public function getCreationDate() {
        return $this->creationDate;
    }

    public function getText() {
        return $this->text;
    }
    
    public function saveToDB(mysqli $connection){
        if($this->id==-1){
            $sql = "INSERT INTO Comments (user_id, post_id, creation_date, text) VALUES ('$this->userId', '$this->postId', '$this->creationDate', '$this->text')";
            
            $result = $connection->query($sql);
            
            if($result==true){
                $this->id = $connection->insert_id;
                return true;
            }
        }
        return false;
    }
    
    static public function loadCommentById(mysqli $connection, $id){
        $sql = "SELECT * FROM Comments WHERE id=$id";
        
        $result = $connection->query($sql);
        if($result==true && $result->num_rows==1){
            $row=$result->fetch_assoc();
            
            $loadedComment = new Comment();
            $loadedComment->id = $row['id'];
            $loadedComment->userId = $row['user_id'];
            $loadedComment->postId=$row['post_id'];
            $loadedComment->creationDate = $row['creation_date'];
            $loadedComment->text = $row['text'];
            
            return $loadedComment;
            
        }
        return null;
    }
    
    static public function loadAllCommentsbyUserId(mysqli $connection, $tweetId){
        $sql = "SELECT * FROM Comments WHERE post_id=$tweetId ORDER BY creation_date DESC";
        $ret =[];
        
        $result = $connection->query($sql);
        if($result==true && $result->num_rows!=0){
            foreach($result as $row){
            $loadedComment = new Comment();
            $loadedComment->id = $row['id'];
            $loadedComment->userId = $row['user_id'];
            $loadedComment->postId=$row['post_id'];
            $loadedComment->creationDate = $row['creation_date'];
            $loadedComment->text = $row['text'];
                
                $ret[]=$loadedComment;
            }
        }
        return $ret;
    }
    
//    static public function loadAllUsers(mysqli $connection){
//        $sql = "SELECT * FROM Users";
//        $ret = [];
//        
//        $result = $connection->query($sql);
//        if($result==true && $result->num_rows!=0){
//            foreach($result as $row){
//                $loadedUser = new User();
//                $loadedUser->id = $row['id'];
//                $loadedUser->username = $row['username'];
//                $loadedUser->hashedPassword=$row['hashed_password'];
//                $loadedUser->email = $row['email'];
//
//                $ret[]=$loadedUser;
//            }
//        }
//        return $ret;
//    }
    
    public function delete(mysqli $connection){
        if($this->id!=-1){
            $sql = "DELETE FROM Users WHERE id=$this->id";
            $result=$connection->query($sql);
            if($result == true){
                $this->id=-1;
                return true;
            }
            return false;
        }
        return true;
    }
    
}

//---TEST OF USER SAVING---
//$test=new Comment();
//$test->setUserId(23);
//$test->setPostId(70);
//$test->setCreationDate("2015-11-14 00:00:00");
//$test->setText("testujemy");
//
//var_dump($test);
//if($test->saveToDB($db)){
//    echo "spoko";
//}


////---TEST OF COMMENT LOADING (single)---
//$user_id=2;
//$loadingTest=  Comment::loadCommentById($db, $user_id);
//if($loadingTest==true){
//    echo "Comment ".$loadingTest->getText()." is loaded.<br>";
//}else{
//    echo "Cannot to load Comment with id number: ".$user_id;
//}
//
//var_dump($loadingTest);


//---TEST OF LOADING COMMENTS (all from one post)---
//$test=  Comment::loadAllCommentsbyUserId($db, 6);
//var_dump($test);