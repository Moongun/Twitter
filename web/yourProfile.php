<?php
session_start();
?>


<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>TWITTER</title>
    </head>
    <body>
        <div>
            <h1>Your Profile</h1>
        </div>
        <div>
            
<?php
echo $_SESSION['username'].', welcome to Twitter!'
        . ' On this site, you can edit your login, email or password. '
        . 'Also, you will see all of your activity on Twitter.';
?>
            <ul>
                <li><a href="MainPage.php">Main Page</a></li>
                <li><a href="#edit">Edit your Profile</a></li>
                <li><a href="logout.php">logout</a></li>
            </ul>
            
        </div>
        
        <?php
        include '../src/Tweet.php';
        
        $userId=$_SESSION['id'];
        $usrTweets = Tweet::loadAllTweetsbyUserId($db, $userId);
        echo"<table style='border:solid 1px'>";
        foreach ($usrTweets as $row) {
            echo '<tr>';
//                $sql=$db->query("SELECT * FROM Tweets JOIN Users ON Tweets.user_id=Users.id");
//                var_dump($sql);
//                $sql->fetch_assoc();
//                var_dump($sql);
//                echo"$sql->getUsername()";
            
            echo '<td style="border:solid 1px ">' . $row->getUserId() . '</td>
            <td style="border:solid 1px ">' . $row->getText() . '</td>
            <td style="border:solid 1px ">' . $row->getCreationDate() . '</td>
            </tr>';
        }
        echo "</table>"; 
        ?>
        
        <div>
            <a name="edit"><h3>edit profile</h3></a>
            <form action="#" method="POST">
                <input type="text" name="username" placeholder="new username">
                <input type="email" name="email" placeholder="new email">
                <input type="password" name="password" placeholder="new password">
                <input type="submit" value="update your profile">
            </form>
            
            
            <?php
            if($_SERVER['REQUEST_METHOD']== 'POST'){
                if(!empty($_POST['username'])){
                    $newUsername=trim($_POST['username']);
                    $oldUsername=$_SESSION['username'];
                    $sql1="UPDATE Users SET username='$newUsername' WHERE username='$oldUsername'";
                    if($db->query($sql1)){
                        echo "<span style=color:green>Username is changed.</span><br/>";
                        $_SESSION['username']=$newUsername;
                    }
                }
                if(!empty($_POST['email'])){
                    $newEmail=trim($_POST['email']);
                    $oldEmail=$_SESSION['email'];
                    $sql2="UPDATE Users SET email='$newEmail' WHERE email='$oldEmail'";
                    if($db->query($sql2)){
                        echo "<span style=color:green>Email is changed.</span><br/>";
                        $_SESSION['email']=$newEmail;
                    }
                }
                if(!empty($_POST['password'])){
                    $newPassword=trim($_POST['password']);
                    $hashedNewPass=  password_hash($newPassword, PASSWORD_BCRYPT);
                    $oldPassword=$_SESSION['hashed_password'];
                    $sql3="UPDATE Users SET hashed_password='$hashedNewPass' WHERE hashed_password='$oldPassword'";
                    if($db->query($sql3)){
                        echo "<span style=color:green>Password is changed.</span><br/>";
                        $_SESSION['hashed_password']=$hashedNewPass;
                    }    
                }
            }
            ?>
        </div>
        
        <br/>
        <br/>
        
        <div>
            <form action="../src/deletingAccount.php" method="POST">
                <label>Do you really want to delete your Account?
                    <input type="checkbox" name="delete">
                </label>
                    <input type="submit" value="delete my Account">
            </form>
        </div>
    </body>
</html>
