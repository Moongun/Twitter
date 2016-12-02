<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>TWITTER</title>
    </head>
    <body>
        
        <div>
            <h1>Create Account:</h1>
        </div>
        <form action="#" method="POST">
            <input type="text" name="username" placeholder="Username"/>
            <br/>
            <input type="email" name="email" placeholder="email"/>
            <br/>
            <input type="password" name="password" placeholder="password"/>
            <br/>
            <input type="submit" value="Create Account"/>
        </form>
        
        <?php
        //VALIDATION OF RECEIVE METHOD
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['username']) == true && 
                isset($_POST['email']) == true && 
                isset($_POST['password']) == true) {
        //COLLECTING DATA        
                    $username = trim($_POST['username']);
                    $email = trim($_POST['email']);
                    $password = trim($_POST['password']);
            } else {
                echo('Brak przekazanych danych albo złe dane');
            }
        }
        //CONNECTING TO BASE
        include '../src/User.php';
        
        //ADDING NEW USER
        $newUser= new User();
        $newUser->setEmail($email);
        $newUser->setUsername($username);
        $newUser->setPassword($password);
        if($newUser->saveToDB($db)){
            echo '<span style="color:green">User is saved.</span>';
        }else{
            echo '<span style="color:red">User saving failed.Use another email.</span>';
        }
        

        ?>
        <br/>
        <a href="index.php">Go to the logging Page</a>
    </body>
</html>
