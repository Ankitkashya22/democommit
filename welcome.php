<?php
session_start();

if(!isset($_SESSION['user_admin'])){
    header("location: http://localhost/crud/admin_login.php");
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php
     echo"<h1> WELCOME BACK </h1>";
    ?>
    <center><a href="login.php"><input type="button" value="LogOuT"/></a></center>
</body>
</html>
