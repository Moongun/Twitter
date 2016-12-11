<?php
session_start();
if(!isset($_SESSION['logged'])){
    header('Location: index.php');
    exit();
}
include_once '../src/User.php';
?>


<!DOCTYPE html>
<html>
    <head>
        <title>TWITTER</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <div>
            <h1>Main Page</h1>
        </div>
        <div>
            
<?php
echo $_SESSION['username'].', welcome to Twitter!';
//$IdUserLogged=$_SESSION['id'];
//$UserLogged= User::loadUserById($db, $IdUserLogged);
//echo $UserLogged->getUsername();
?>
            <ul>
                <li><a href="yourProfile.php">Your Profile</a></li>
                <li><a href="logout.php">logout</a></li>
            </ul>
            
        </div>
        <div>
            <form action="#" method="POST">
                <input type="text" name="text" placeholder="put your tweet here">
                <input type="submit" value="send Tweet">
            </form>
        </div>
        <div>    
            
        <?php
        include '../src/Tweet.php';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!empty($_POST['text']) == true) {

                $text = $_POST['text'];
                $newTweet = new Tweet();
                $newTweet->setCreationDate(date("Y-m-d H:i:s"));
                $newTweet->setText($text);
                $newTweet->setUserId($_SESSION['id']);
                if ($newTweet->saveToDB($db)) {

                } else {
                    echo 'nie udalo się';
                }
            }
        } else {
        //    echo('Brak przekazanych danych albo złe dane');
        }

        $tweets = Tweet::loadAllTweets($db);

        echo"<table style='border:solid 1px'>";
        foreach ($tweets as $row) {
            $idUser= $row->getUserId();
            $username= User::loadUserById($db, $idUser);
            echo '<tr>
            <td style="border:solid 1px ">' . $username->getUsername() . '</td>
            <td style="border:solid 1px ">' . $row->getText() . '</td>
            <td style="border:solid 1px ">' . $row->getCreationDate() . '</td>
            <td style="border:solid 1px "><form action="TweetPage.php" method="POST">
                <input type="hidden" name="tweetId" value='.$row->getId().'></input>
                <input type="submit" name="tweetProfile" value="Show this tweet">
            </form></td>
            
            <td style="border:solid 1px "><form action="createMessage.php" method="GET">
                <input type="hidden" name="userId" value='.$idUser.'></input>
                <input type="submit" name="sentMsg" value="send a Message">
            </form></td>
            </tr>';
        }
        echo "</table>";
        ?>
            
        </div>

    </body>
</html>
