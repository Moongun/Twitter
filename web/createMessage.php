<?php 
session_start();

require '../src/User.php';
require '../src/Message.php';

if($_SERVER['REQUEST_METHOD']=='POST'){
    if(isset($_POST['recId']) && isset($_POST['insertedMessage'])){
        $recId=$_POST['recId'];
        $insertedMessage=$_POST['insertedMessage'];
        $newMessage=new Message();
        $newMessage->setSendId($_SESSION['id']);
        $newMessage->setReceiveId($recId);
        $newMessage->setMsg($insertedMessage);
        $newMessage->setCreationDate(date("Y-m-d H:i:s"));

    }
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>TWITTER</title>
    </head>
    <body>
        <div>
            <h1>Create new Message</h1>
        </div>
        <?php 
        echo $_SESSION['username'].', communicate with other users!';
        ?>
        <ul>
            <li><a href="MainPage.php">Main Page</a></li>
            <li><a href="yourProfile.php">Edit your Profile</a></li>
            <li><a href="logout.php">logout</a></li>
            <li><a href="messagesPage.php">your Messages</a></li>
            <li><a href="createMessage.php">create new Message</a></li>
        </ul>
        
        <div>
            <h3>send a Message to 
                
                <?php if($_SERVER['REQUEST_METHOD']=='GET'){
                    if(isset($_GET['userId'])){
                        $recId=$_GET['userId'];
                        $recname=  User::loadUserById($db, $recId);
                        echo $recname->getUsername();
                    }
                }  ?>
            </h3>
            <form action="#" method="POST">
                <textarea style="width:800px; height:200px;" name="insertedMessage"></textarea>
                <?php
                
                echo '<input type="hidden" name="recId" value="'.$recId.'">'; 
                ?>
                <br/>
                <input type="submit" name="sendMessage" value="send a Message">
            </form>
            <?php
            $newMessage= new Message();
            if($newMessage->saveMessageToDB($db)){
                echo "new Message sent.";
            }else{
                echo "Cannot to send your Message.";
            }
            ?>
</div>
    </body>
</html>
