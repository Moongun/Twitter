<?php
session_start();

require '../src/User.php';
require '../src/Message.php';

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>TWITTER</title>
    </head>
    <body>
        <div>
            <h1>Messages Page</h1>
        </div>
        <?php
        echo $_SESSION["username"].', these are your all messages!';
        ?>
        <ul>
            <li><a href="MainPage.php">Main Page</a></li>
            <li><a href="#edit">Edit your Profile</a></li>
            <li><a href="logout.php">logout</a></li>
            <li><a href="messagesPage.php">your Messages</a></li>
            <li><a href="createMessage.php">create new Message</a></li>
        </ul>
        
        <div>
            <h3>received:</h3>
            <?php 
            $receivedMssgAll= Message::loadAllReceivedMessage($db, $_SESSION['id']);
            if($receivedMssgAll !=null){
                echo "<table>
                    <tr><th>from:</th><th>date:</th><th>Message:</th>";
                foreach($receivedMssgAll as $singleMssg){
                    $sendId =  User::loadUserById($db, $singleMssg->getSendId());
                    $sendName= $sendId->getUsername();
                    $seen1=$singleMssg->getSeen();
                    $seen2=$singleMssg->getSeen();
                    
                    echo '<tr>'.$seen1.'<td>'.$sendName.'</td><td>'.$singleMssg->getCreationDate().'</td><td>'.substr($singleMssg->getMsg(),0,30).'<td>'
                            . '<form action="messagePage.php" method="POST"><input type="hidden" name="messageId" value="'.$singleMssg->getId().'"><input type="submit" value="Pokaż wiadomość"></form>'
                            . $seen2.'</td></tr>';                    
                }
                echo "</table>";
            }else {
                echo "Lack of Messages received.";
            }
            ?>
        </div>
        <div>
            
        
            <h3>sent:</h3>
            <?php
//            if($_SERVER['REQUEST_METHOD']=='POST'){
//                if(isset($_POST['id'])){
//                    $userid=$_POST['id'];
//                }
//            }
            
            $sentMssgAll=Message::loadAllSendMessage($db, $_SESSION['id']);
            if($sentMssgAll!=null){
                echo "<table>
                    <tr><th>to:</th><th>date:</th><th>Message:</th>";
                foreach($sentMssgAll as $singleMssg2){
                    $recId=  User::loadUserById($db, $singleMssg2->getReceiveId());
                    $recName=$recId->getUsername();
                    $seen11=$singleMssg2->getSeen();
                    $seen22=$singleMssg2->getSeen();
                    
                    echo '<tr>'.$seen11.'<td>'.$recName.'</td><td>'.$singleMssg2->getCreationDate().'</td><td>'.substr($singleMssg2->getMsg(),0,30).'<td>'
                            . '<form action="messagePage.php" method="POST"><input type="hidden" name="messageId" value="'.$singleMssg->getId().'"><input type="submit" value="Pokaż wiadomość"></form>'
                            . $seen22.'</td></tr>'; 
                }
                echo "</table>";
            }else{
                echo "Lack of Messages sent.";
            }
            
            ?>
        </div>
    </body>
</html>
