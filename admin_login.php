<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Admin-login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
</head>
<body>
<form action="<?php $_SERVER['PHP_SELF'];?>" method="post" style="border:1px solid #ccc">
  <div class="container">
    <h1>Hii! ADMIN</h1>
    <p></p>
    <hr>
    <label for="admin"><b>ADMIN ID</b></label>
    <input type="text"  name="admin" required><br><br>

    <label for="apassword"><b>Password</b></label>
    <input type="password" name="apassword" required><br><br>
    <div class="clearfix">
      <button type="submit"  name="login" class="signupbtn">login</button>
    </div>
  </div>
</form>
</body>
</html>
<?php
if(isset($_POST['login'])){
    $username= $_POST['admin'];
    $password = $_POST['apassword'];

    $mysqli = new mysqli("localhost","root","","crud");
    
    if ($mysqli -> connect_errno) {
      echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
      exit();
    }
    $savequery = "SELECT `user_admin`,`pass_admin` FROM `admin` WHERE `user_admin` = '$username' AND `pass_admin` ='$password'";
    $result = $mysqli->query($savequery);
    if(mysqli_num_rows($result)>0){
      while($store=mysqli_fetch_assoc($result)){
        session_start();
        $_SESSION['user_admin'] = $store['user_admin'];
        $_SESSION['pass_admin'] = $store['pass_admin'];

        header("location: http://localhost/crud/view.php");
      } 
    }else{
    echo "userID and password not matched";
    }
}
?>
