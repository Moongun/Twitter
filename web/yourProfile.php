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
                <li><a href="messagesPage.php">your Messages</a></li>
                <li><a href="createMessage.php">create new Message</a></li>
            </ul>
            
        </div>
        
        <?php
        include '../src/Tweet.php';

        $usrTweets = Tweet::loadAllTweetsbyUserId($db, $_SESSION['id']);
        echo"<table style='border:solid 1px'>";
        foreach ($usrTweets as $row) {
            echo '<tr>';
                echo '<td style="border:solid 1px ">' . $_SESSION['username'] . '</td>
                <td style="border:solid 1px ">' . $row->getText() . '</td>
                <td style="border:solid 1px ">' . $row->getCreationDate() . '</td>
            </tr>';
        }
        echo "</table>";
        ?>
        
        <div>
            <a name="edit"><h3>edit profile</h3></a>
            <form action="../src/EditProfile.php" method="POST">
                <input type="text" name="username" placeholder="new username">
                <input type="email" name="email" placeholder="new email">
                <input type="password" name="password" placeholder="new password">
                <input type="submit" value="update your profile">
            </form>
            <?php
            if(isset($_SESSION['nameEdited'])){
                echo "<span style=color:green>Username is changed.</span><br/>";
            }
                
            if(isset($_SESSION['emailEdited'])){
                echo "<span style=color:green>Email is changed.</span><br/>";
            }
                
            if(isset($_SESSION['passwordEdited'])){
                echo "<span style=color:green>Password is changed.</span><br/>";
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
