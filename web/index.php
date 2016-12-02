<?php
session_start();

if(isset($_SESSION['logged']) && $_SESSION['logged'] == true){
    header ("Location: MainPage.php");
    exit();
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
            <h1>LOG TO TWITTER:</h1>
        </div>
        
        <?php
        if(isset($_SESSION['blad'])){
            echo $_SESSION['blad'];
        }
        ?>
        
        <form action="../src/logging.php" method="POST">
            <input type="email" name="email" placeholder="email">
            <br/>
            <input type="password" name="password" placeholder="password">
            <br/>
            <input type="submit" value="log in">
        </form>
        <div>
            <a href="createUser.php">create new account</a>
        </div>
    </body>
</html>
