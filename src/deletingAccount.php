<?php
session_start();

//something's wrong -> after deleting account, when you try to login on the deleted account, logging.php breaks...

if($_SERVER['REQUEST_METHOD']== 'POST'){
    if(isset($_POST['delete'])){
        $db=new mysqli('localhost', 'root', 'coderslab', 'Twitter');

        if($db->connect_error){
            die("Connection failed. Error: ".$db->connect_error);
        }
    }
    $usrId=$_SESSION['id'];
    $del=$db->query("DELETE FROM Users WHERE id='$usrId'");
    
    session_unset();
    $db->close();
//    exit('Account deleted');
    
    header("Location: ../web/index.php");
    
}



