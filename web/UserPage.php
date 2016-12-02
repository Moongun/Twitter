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
            <h1>User Page</h1>
        </div>
        <div>
            
<?php
echo $_SESSION['username'].', welcome to Twitter!';
?>
            <ul>
                <li><a href="MainPage.php">Main Page</a></li>
                <li><a href="logout.php">logout</a></li>
            </ul>
            
        </div>
        
        <?php
        include '../src/Tweet.php';
        
        $userId=$_SESSION['id'];
        $usrTweets = Tweet::loadAllTweetsbyUserId($db, $userId);
        echo"<table style='border:solid 1px'>";
        foreach ($usrTweets as $row) {
            echo '<tr>
            <td style="border:solid 1px ">' . $row->getUserId() . '</td>
            <td style="border:solid 1px ">' . $row->getText() . '</td>
            <td style="border:solid 1px ">' . $row->getCreationDate() . '</td>
            </tr>';
        }
        echo "</table>"; 
        
        
        ?>
    </body>
</html>
