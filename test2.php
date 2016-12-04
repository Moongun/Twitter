<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <form action="#" method="POST">
            <label>Do you really want to delete your Account?
                <input type="checkbox" name="delete">
            </label>
            <input type="submit" value="delete my Account">
        </form>
        
        <?php
        if($_SERVER['REQUEST_METHOD']== 'POST'){
            if(isset($_POST['delete'])){
                var_dump($_POST['delete']);
            }
        }
        ?>
        
    </body>
</html>
