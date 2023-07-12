<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOG IN USER</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <style>
      #e-mail{
        border: 2px solid green;
        border-radius: 4px;
      }
      #psd{
        border: 2px solid green;
        border-radius: 4px;
      }
      </style>
</head>
<body>
<form action="<?php $_SERVER['PHP_SELF'];?>" method="post" style="border:1px solid #ccc">
  <div class="container">
    <h1>LOG IN USER</h1>
    <p></p>
    <hr>

    <label for="email"><b>Email</b></label>
    <input type="text" placeholder="Enter Email"  id="e-mail" name="email" required><br><br>

    <label for="psw"><b>Password</b></label>
    <input type="password" placeholder="Enter Password"  id="psd" name="password" required><br><br>
    <div class="clearfix">
     <button type="submit"  name="login" class="signupbtn">login</button>
     
    </div>
  </div>
</form>
</body>
</html>
<?php
if(isset($_POST['login'])){
    $email= $_POST['email'];
    $password = $_POST['password'];

    $mysqli = new mysqli("localhost","root","","crud");
    
    if ($mysqli -> connect_errno) {
      echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
      exit();
    }
    $savequery = "SELECT `email`,`password` FROM `person` WHERE `email` = '$email' AND `password` ='$password'";
    $result = $mysqli->query($savequery);
    if(mysqli_num_rows($result)>0){
      while($store=mysqli_fetch_assoc($result)){
      session_start();
      $_SESSION['email'] = $store['email'];
      $_SESSION['password'] = $store['password'];
    header("location: http://localhost/crud/welcome.php");
      }
    }else{
    echo "email and password not matched";
    }
}
?>
