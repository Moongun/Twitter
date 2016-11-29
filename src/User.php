<?php

$db=new mysqli('localhost', 'root', 'coderslab', 'Twitter');

if($db->connect_error){
    die("Connection failed. Error: ".$db->connect_error);
}else{
    echo "Connected.<br><br>";
}


class User{
    private $id;
    private $username;
    private $email;
    private $hashedPassword;
    
    
    public function __construct() {
        $this->id=-1;
        $this->username="";
        $this->email="";
        $this->hashedPassword="";
    }
    
    public function setUsername($username){
        $this->username = $username;
    }
    
    public function setEmail($email) {
        $this->email = $email;
    }

    public function setPassword($newPassword){
        $newHashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
        $this->hashedPassword=$newHashedPassword;
    }
    
    public function getId(){
        return $this->id;
    }
    
    public function getUsername(){
        return $this->username;
    }
    
    public function getHashedPassword(){
        return $this->hashedPassword;
    }
    
    public function getEmail(){
        return $this->email;
    }
    
    public function saveToDB(mysqli $connection){
        if($this->id==-1){
            $sql = "INSERT INTO Users (username, email, hashed_password) VALUES ('$this->username', '$this->email', '$this->hashedPassword')";
            
            $result = $connection->query($sql);
            
            if($result==true){
                $this->id = $connection->insert_id;
                return true;
            }
        }else{
            $sql = "UPDATE Users SET username='$this->username', email='$this->email', hashed_password='$this->hashedPassword' where id=$this->id";
            
            $result=$connection->query($sql);
            if($result == true){
                return true;
            }
        }
        return false;
    }
    
    static public function loadUserById(mysqli $connection, $id){
        $sql = "SELECT * FROM Users WHERE id=$id";
        
        $result = $connection->query($sql);
        if($result==true && $result->num_rows==1){
            $row=$result->fetch_assoc();
            
            $loadedUser = new User();
            $loadedUser->id = $row['id'];
            $loadedUser->username = $row['username'];
            $loadedUser->hashedPassword=$row['hashed_password'];
            $loadedUser->email = $row['email'];
            
            return $loadedUser;
            
        }
        return null;
    }
    
    static public function loadAllUsers(mysqli $connection){
        $sql = "SELECT * FROM Users";
        $ret = [];
        
        $result = $connection->query($sql);
        if($result==true && $result->num_rows!=0){
            foreach($result as $row){
                $loadedUser = new User();
                $loadedUser->id = $row['id'];
                $loadedUser->username = $row['username'];
                $loadedUser->hashedPassword=$row['hashed_password'];
                $loadedUser->email = $row['email'];

                $ret[]=$loadedUser;
            }
        }
        return $ret;
    }
    
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
//$testUser= new User();
//$testUser->setEmail("test3@op.pl");
//$testUser->setUsername("Testname3");
//$testUser->setPassword("TestPass3");
//if($testUser->saveToDB($db)){
//    echo "User is saved.";
//}else{
//    echo "User saving failed";
//}


//---TEST OF USER LOADING (single)---
//$user_id=2;
//$loadingTest=User::loadUserById($db, $user_id);
//if($loadingTest==true){
//    echo "User ".$loadingTest->getUsername()." is loaded.<br>";
//}else{
//    echo "Cannot to load user with id number: ".$user_id;
//}
//
//var_dump($loadingTest);


//---TEST OF USER LOADING (all)---
//$loadingTestAll=User::loadAllUsers($db);
//if($loadingTestAll==true){
//    echo "All Users are loaded.";
//}else{
//    echo "Loading of all users failed.";
//}
//var_dump($loadingTestAll);


//---TEST OF USER MODIFY---
//$test=User::loadUserById($db, 1);
//var_dump($test);
//$test->setEmail("newtest@op.pl");
//$test->setUsername("newname");
//$test->saveToDB($db);
//var_dump($test);

//---TEST OF USER DELETING---
//$testDel=User::loadUserById($db, 1);
//$testDel->delete($db);

