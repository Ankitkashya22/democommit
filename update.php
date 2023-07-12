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
    <title>Update</title>
    <!-- <link rel="stylesheet" type="text/css" href="sign.css"> -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <?php
        $id = $_GET['ID'];
        $mysqli = new mysqli("localhost","root","","crud");

        if ($mysqli -> connect_errno) {
          echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
          exit();
        }
        $query = "SELECT * FROM `person` WHERE  `ID` = $id";
         $result = $mysqli -> query($query);
        

         if(mysqli_num_rows($result)>0){
            while($rows=mysqli_fetch_assoc($result)){
        ?>
    <form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST" style="border:1px solid #ccc">
        <div class = "title">
           UPDATE
        </div>
        <br>
        <div class="form">
            <div class="input_field">
                <label>First Name</label>
                <input type="hidden" class="input" name="ID" value="<?php echo $rows['ID'];?>"> 
                <input type="text" class="input" name="fname" value="<?php echo $rows['firstname'];?>">  
            </div><br>
            <div class="input_field">
                <label>Last Name</label>
                <input type="text" class="input"  name="lname" value="<?php echo $rows['lastname'];?>">   
            </div><br>
            <div class="input_field">
                <label>Email</label>
                <input type="email" class="input"  name="email" value="<?php echo $rows['email'];?>">   
            </div><br>
            <div class="input_field">
                <label>Contact</label>
                <input type="number" class="input"  name="contact" value="<?php echo $rows['contact'];?>">   
            </div><br>
            <div class="input_field">
                <label>Date of Birth</label>
                <input type="date" class="input"  name="dob" value="<?php echo $rows['dob'];?>">   
            </div><br>
            <div class="input_field">
            <!-- <?php echo $rows['languages'].'<br>'; ?> -->
                <label>LANGUAGES KNOWN: </label>
                <?php  
                    $language = $rows['languages'];
                    $language1 = explode(",", $language); 
                ?>
                <input type="checkbox" name="r1[]" value="php"
                <?php
                if(in_array('php',$language1))
                {
                    echo"checked";
                }
                ?> 
                >  
                <label style="margin-left: 15px;">php</label>
                <input type="checkbox" name="r1[]" <?php
                if(in_array('python',$language1))
                {
                    echo"checked";
                }
                ?>  value="python"><label style="margin-left: 15px;">python</label>
                <input type="checkbox" name="r1[]" <?php
                if(in_array('c++',$language1))
                {
                    echo"checked";
                }
                ?>  value="c++"><label style="margin-left: 15px;">c++</label> <br>           
                <br>
            <div class="input_field">
                <label>Gender</label>
                <select name="gender">
                    <option value="">SELECT</option>
                    <option value="M"
                    <?php
                    if($rows['gender']=='M'){
                        echo"selected";
                    }
                    ?>
                    >MALE</option>
                    <option value="F"  <?php
                    if($rows['gender']=='F'){
                        echo"selected";
                    }
                    ?>>FEMALE</option>
                </select>  
            </div><br>
    
            <!-- <div class="input_field">
                <label>Confirm password</label>
                <input type="password" class="input">   
            </div><br> -->
             <div class="input_field">
                <label>Address</label>
               <input type="textarea" name="address" value="<?php echo $rows['address']; ?>">   
            </div><br>
            <div class="clearfix">
      <button type="submit" name="update" class="signupbtn">UPDATE</button>
    </div>
    </div>
    <?php
            }
        }
    ?>       
</form>
</body>
</html>

<?php
if(isset($_POST['update'])){
    $id = $_POST['ID'];
    $fname= $_POST['fname'];
    $lname= $_POST['lname'];
    $email= $_POST['email'];
    $contact= $_POST['contact'];
    $dob = $_POST['dob'];
    $lang=$_POST['r1'];
    $lang1 = implode(",",$lang);
    $gender= $_POST['gender'];

    $address= $_POST['address'];

    $mysqli = new mysqli("localhost","root","","crud");

    if ($mysqli -> connect_errno) {
        echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
        exit();
    }
    $query = "UPDATE `person` SET `firstname` = '$fname',`lastname` = '$lname',`email`='$email',`contact`='$contact',`dob`='$dob',`languages`='$lang1',`gender`='$gender',`address`='$address' WHERE `ID`='$id'";

    $mysqli -> query($query);
    header("location: http://localhost/crud/view.php");


}
?>