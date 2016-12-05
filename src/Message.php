<?php
//+-----------------+------------------+------+-----+---------+----------------+
//| Field           | Type             | Null | Key | Default | Extra          |
//+-----------------+------------------+------+-----+---------+----------------+
//| id              | int(11) unsigned | NO   | PRI | NULL    | auto_increment |
//| send_user_id    | int(11) unsigned | NO   | MUL | NULL    |                |
//| receive_user_id | int(11) unsigned | NO   | MUL | NULL    |                |
//| creation_date   | datetime         | YES  |     | NULL    |                |
//| text            | varchar(256)     | NO   |     | NULL    |                |
//| seen            | int(11) unsigned | NO   |     | NULL    |                |
//+-----------------+------------------+------+-----+---------+----------------+

$db=new mysqli('localhost', 'root', 'coderslab', 'Twitter');

if($db->connect_error){
    die("Connection failed. Error: ".$db->connect_error);
}else{
//    echo "Connected.<br><br>";
}


class Message{
    private $id;
    private $sendId;
    private $receiveId;
    private $msg;
    private $seen;
    private $creationDate;

    
    public function __construct() {
        $this->id=-1;
        $this->sendId="";
        $this->receiveId="";
        $this->msg="";
        $this->seen=0;
        $this->creationDate="";
    }
    
    function setSendId($sendId) {
        $this->sendId = $sendId;
    }

    function setReceiveId($receiveId) {
        $this->receiveId = $receiveId;
    }

    function setMsg($msg) {
        $this->msg = $msg;
    }

    function setSeen($seen) {
        $this->seen = 1;
    }
    
    function getSendId() {
        return $this->sendId;
    }

    function getReceiveId() {
        return $this->receiveId;
    }

    function getMsg() {
        return $this->msg;
    }

    function getSeen() {
        return $this->seen;
    }

    
    
    public function saveMessageToDB(mysqli $connection){
        if($this->id==-1){
            $sql="INSERT INTO Messages (send_user_id, receive_user_id, text, seen, creation_date) VALUES ($this->sendId,$this->receiveId,'$this->msg',$this->seen,'$this->creationDate')";
                  
            $result=$connection->query($sql);
            if($result==true){
                $this->id=$connection->insert_id;
                return true;
            }   
        }
        return false;
        
    } 
    static public function loadMessageById(mysqli $connection,$id){
        $sql="SELECT * FROM Messages WHERE id=$id";
        $result=$connection->query($sql);
        if($result==true&&$result->num_rows==1){
            $row=$result->fetch_assoc();
            $loadedMessage=new Message();
            $loadedMessage->id=$row['id'];
            $loadedMessage->sendId=$row['send_user_id'];
            $loadedMessage->receiveId=$row['receive_user_id'];
            $loadedMessage->msg=$row['text'];
            $loadedMessage->seen=$row['seen'];
            $loadedMessage->creationDate=$row['creation_date'];
            return $loadedMessage;
        }
        return null;
        
    }
    static public function loadAllReceivedMessage(mysqli $connection, $idRec){
        $sql="SELECT * FROM Messages WHERE receive_user_id=$idRec";
        $result=$connection->query($sql);
        $receivedMessages=[];
        if($result==true&&$result->num_rows>0){
            while($row=$result->fetch_assoc()){
                $loadedMessage=new Message();
                $loadedMessage->id=$row['id'];
                $loadedMessage->sendId=$row['send_user_id'];
                $loadedMessage->msg=$row['text'];
                $loadedMessage->seen=$row['seen'];
                $loadedMessage->creationDate=$row['creation_date'];
                $receivedMessages[]=$loadedMessage;
            }
            return $receivedMessages;
        }
        return null;
    }
    static public function loadAllSendMessage(mysqli $connection, $idSend){
        $sql="SELECT * FROM Messages WHERE send_user_id=$idSend";
        $result=$connection->query($sql);
        $senderMessages=[];
        if($result==true&&$result->num_rows>0){
            while($row=$result->fetch_assoc()){
                $loadedMessage=new Message();
                $loadedMessage->id=$row['id'];
                $loadedMessage->receiveId=$row['receive_user_id'];
                $loadedMessage->msg=$row['text'];
                $loadedMessage->seen=$row['seen'];
                $loadedMessage->creationDate=$row['creation_date'];
                $sendMessages[]=$loadedMessage;
            }
            return $sendMessages;
        }
        return null;
        
    }
    public function deleteMessage(mysqli $connection){
        if($this->id!=-1){
            $sql="DELETE FROM Messages WHERE id=$this->id";
            $result->$connection->query($sql);
            if($result==true){
                $this->id=-1;
                return true;
            }
            return false;    
        }
        return true;
    }
    public function updateMessage(mysqli $connection){
        if($this->id!=-1){
            $sql="UPDATE Messages SET seen=$this->seen WHERE id=$this->id";
            $result=$connection->query($sql);
            if($result==true){
                return true;
            }
        }
        return false;
    }
}



            
                