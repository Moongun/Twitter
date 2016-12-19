<?php
session_start();
include_once 'LogToDB.php';

//username edition
if($_SERVER['REQUEST_METHOD']== 'POST'){
    if(!empty($_POST['username'])){
        $newUsername=trim($_POST['username']);
        $oldUsername=$_SESSION['username'];
        $sql1="UPDATE Users SET username='$newUsername' WHERE username='$oldUsername'";
        if($db->query($sql1)){
            $_SESSION['nameEdited']= true;
            $_SESSION['username']=$newUsername;
            header('Location: ../web/yourProfile.php');
        }
    }
    
    
    if(!empty($_POST['email'])){
        $newEmail=trim($_POST['email']);
        $oldEmail=$_SESSION['email'];
        $sql2="UPDATE Users SET email='$newEmail' WHERE email='$oldEmail'";
        if($db->query($sql2)){
            $_SESSION['email']=$newEmail;
            $_SESSION['emailEdited']= true;
            header('Location: ../web/yourProfile.php');
        }
    }
    if(!empty($_POST['password'])){
        $newPassword=trim($_POST['password']);
        $hashedNewPass=  password_hash($newPassword, PASSWORD_BCRYPT);
        $oldPassword=$_SESSION['hashed_password'];
        $sql3="UPDATE Users SET hashed_password='$hashedNewPass' WHERE hashed_password='$oldPassword'";
        if($db->query($sql3)){
            $_SESSION['hashed_password']=$hashedNewPass;
            $_SESSION['passwordEdited']= true;
            header('Location: ../web/yourProfile.php');
        }    
    }
}
?>