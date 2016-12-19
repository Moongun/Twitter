<?php

session_start();
if((empty($_POST['email'])) || (empty($_POST['password']))){
    header('Location: ../web/index.php');
    exit();
}

include_once 'LogToDB.php';

if($_SERVER['REQUEST_METHOD']=='POST'){
    if(isset($_POST['email']) && isset($_POST['password'])){
        $email=$_POST['email'];
        $password=$_POST['password'];

        $sql="SELECT * FROM Users WHERE email='$email'";
        $result=$db->query($sql);
        if($result->num_rows>0){

            $usr = $result->fetch_assoc();
            $hashPass2 =$usr['hashed_password'];

            if(password_verify($password, $hashPass2)){

                $_SESSION['logged']=true;

                $_SESSION['id']=$usr['id'];
                $_SESSION['email']=$usr['email'];
                $_SESSION['username']=$usr['username'];
                $_SESSION['hashed_password']=$usr['hashed_password'];

                unset($_SESSION['blad']);
                $result->free_result();
                header("Location: ../web/MainPage.php");
            }else{
                $_SESSION['error'] = '<span style="color:red">nieprawidłowy email lub haslo.</span>';
                header("Location: ../web/index.php");
            }
        }else{
            $_SESSION['noUser'] = '<span style="color:red">Nie znaleziono użytkownika o podanym mailu.</span>';
                header("Location: ../web/index.php");
        }
    }

} $db->close();
