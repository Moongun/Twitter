<?php

$db=new mysqli('localhost', 'root', 'coderslab', 'Twitter');

if($db->connect_error){
    die("Connection failed. Error: ".$db->connect_error);
}else{
    echo "Connected.<br><br>";
}


class Tweet{
    private $id;
    private $userId;
    private $text;
    private $creationDate;
    
        public function __construct() {
        $this->id=-1;
        $this->userId="";
        $this->text="";
        $this->creationDate="";
    }
    
    public function setUserId($userId) {
        $this->userId = $userId;
    }

    public function setText($text) {
        $this->text = $text;
    }

    public function setCreationDate($creationDate) {
        $this->creationDate = $creationDate;
    }

    public function getId() {
        return $this->id;
    }

    public function getUserId() {
        return $this->userId;
    }

    public function getText() {
        return $this->text;
    }

    public function getCreationDate() {
        return $this->creationDate;
    }

    public function saveToDB(mysqli $connection){
        if($this->id==-1){
            $sql = "INSERT INTO Tweets (user_id, tweet_text, creation_date) VALUES ('$this->userId', '$this->text', '$this->creationDate')";
            
            $result = $connection->query($sql);
            
            if($result==TRUE){
                $this->id = $connection->insert_id;
                return true;
            }
        }
        return false;
    }
    
    static public function loadTweetById(mysqli $connection, $id){
        $sql = "SELECT * FROM Tweets WHERE id=$id";
        
        $result = $connection->query($sql);
        if(result == true && $result->num_rows==1){
            $row=$result->fetch_assoc();
            
            $loadedTweet = new Tweet();
            $loadedTweet->id = $row['id'];
            $loadedTweet->userId = $row['user_id'];
            $loadedTweet->text = $row['tweet_text'];
            $loadedTweet->creationDate = $row['creation_date'];
            
            return $loadedTweet;
        }
        return null;
    }
    
    static public function loadAllTweetsbyUserId(mysqli $connection, $userId){
        $sql = "SELECT * FROM Tweets WHERE user_id=$userId";
        $ret =[];
        
        $result = $connection->query($sql);
        if($result==true && $result->num_rows!=0){
            foreach($result as $row){
                $loadedTweet=new Tweet();
                $loadedTweet->id = $row['id'];
                $loadedTweet->userId = $row['user_id'];
                $loadedTweet->text = $row['tweet_text'];
                $loadedTweet->creationDate = $row['creation_date'];
                
                $ret[]=$loadedTweet;
            }
        }
        return $ret;
    }
    
    static public function loadAllTweets(mysqli $connection){
        $sql = "SELECT * FROM Tweets";
        $ret=[];
        
        $result=$connection->query($sql);
        if($result ==true && $result->num_rows!=0){
            foreach($result as $row){
                $loadedTweet=new Tweet();
                $loadedTweet->id = $row['id'];
                $loadedTweet->userId = $row['user_id'];
                $loadedTweet->text = $row['tweet_text'];
                $loadedTweet->creationDate = $row['creation_date'];
                
                $ret[]=$loadedTweet;
            }
        }
        return $ret;
    }

}






//---TEST OF SAVING TWEETS---
//$test = new Tweet();
//$test->setUserId(8);
//$test->setText("tests of saving456");
//$test->setCreationDate("2015-11-14 00:00:00");
//if($test->saveToDB($db)){
//    echo "tweet dodany";
//}else{
//    echo "problem z tweetem";
//}
//var_dump($test);


//---TEST OF LOADING TWEETS (all from one user)---
//$test=Tweet::loadAllTweetsbyUserId($db, 6);
//var_dump($test);


//---TEST OF LOADING TWEETS (all)---
//$test=  Tweet::loadAllTweets($db);
//var_dump($test);

?>


