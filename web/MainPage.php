<!DOCTYPE html>
<html>
    <head>
        <title>TWEETER</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <div>
            <h1>TWEETER</h1>
        </div>
        <div>
            <?php
            include '../src/Tweet.php';

            echo "<table>";
            echo "<td>";
            echo "<tr>Tweet::loadAllTweets($connection)</tr>";



            echo "</table>";
            ?>
        </div>

    </body>
</html>
