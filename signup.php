   
<?php
//  ********this is for testing*********

require_once('connection.php');
include 'vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
if(isset($_POST['submit'])){
$fname= $_POST['fname'];
$lname= $_POST['lname'];
$email= $_POST['email'];
$email_otp = rand(100000,999999);
$to= $_POST['email'];
$verify_status = 0;
$contact= $_POST['contact'];
$dob = $_POST['dob'];

 $lang = $_POST['r1'];
$lang1 = implode(",",$lang);

// this is testing purpose


$gender= $_POST['gender'];
$password= $_POST['password'];
$cpassword= $_POST['cpassword'];
$address= $_POST['address'];

if($fname!="" && $lname!="" && $contact!="" && $dob!="" && $gender!="" && $password!="" && $address!="" )
 {
// $conn = mysqli_connect("localhost","root","","crud") or die("connection failed.");
$sql="SELECT  `email`,`contact` FROM `person`";
$result = mysqli_query($connection,$sql) or die("query failed");
if(mysqli_num_rows($result)){
    while($rows =mysqli_fetch_assoc($result)){
        $exit_phone[]=$rows['contact'];
        $exit_email[]=$rows['email'];
    }  
}
if(in_array($contact, $exit_phone)){
    echo"<script>alert('phone number already exist')</script>";
}elseif(in_array($email, $exit_email)){
    echo"<script>alert('email already exist')</script>";
}
if($password==$cpassword){
    $query = "INSERT INTO `person` (`firstname`,`lastname`,`email`,`email_otp`,`email_verify_status`,`contact`,`dob`,`languages`,`gender`,`password`,`address`) VALUES ('$fname','$lname','$email','$contact','$dob','$lang1','$gender','$password','$address,'$email_otp','$verify_status')";
    $result1 = mysqli_query($connection, $query);
    $user_id = mysqli_insert_id($connection);
    if($result1){
        echo "<script>alert('form successfully submitted')</script>";
        $mail = new PHPMailer(true);
try {
// $mail->SMTPDebug = 2;                                      
$mail->isSMTP();                                           
$mail->Host       = 'smtp.gmail.com';                   
$mail->SMTPAuth   = true;                            
$mail->Username   = 'ankit427401@gmail.com';                
$mail->Password   = 'ankit@4321';                       
// $mail->SMTPSecure = 'tls';                             
$mail->Port       = 587;           
$mail->addAddress($to);

$mail->isHTML(true);                                 
$mail->Subject = 'Otp Verification';
$mail->Body    = "Your Email otp verification code.$email_otp.";
$mail->AltBody = 'Body in plain text for non-HTML mail clients';
$mail->send();
echo "Mail has been sent successfully!";
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
header("Location: verification_user.php?uid=".base64_encode($user_id));
    }
}else{
    echo "<script>alert('password didn\'t match')</script>";
}
mysqli_close($connection);
}else{
    echo "<script>alert('please fill all section')</script>";
}
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>signup</title>
    <link rel="stylesheet" href="sign.css">
    <!-- <link rel="stylesheet" type="text/css" href="sign.css"> -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
</head>
<body>
    <div class="container">
    <form action="" method="POST" style="border:1px solid #ccc">
        <div class = "title">
            Registration form
        </div>
        <br>
        <div class="form">
            <div class="input_field">
                <label>First Name</label>
                <input type="text" class="input" value="<?php if(isset($_POST['fname'])) { echo $_POST['fname']; } else { echo ''; } ?>" name="fname">   
            </div><br>
            <div class="input_field">
                <label>Last Name</label>
                <input type="text" class="input" value="<?php if(isset($_POST['lname'])) { echo $_POST['lname']; } else { echo ''; } ?>" name="lname">   
            </div><br>
            <div class="input_field">
                <label>Email</label>
                <input type="email" class="input" value="<?php if(isset($_POST['email'])) { echo $_POST['email']; } else { echo ''; } ?>" name="email" required>   
            </div><br>
            <div class="input_field">
                <label>Contact</label>

                <input type="number" class="input" value="<?php if(isset($_POST['contact'])) { echo $_POST['contact']; } else { echo ''; } ?>" name="contact">   
            </div><br>
            <div class="input_field">
                <label>Date of Birth</label>
                <input type="date" class="input" value="<?php if(isset($_POST['dob'])) { echo $_POST['dob']; } else { echo ''; } ?>" name="dob">   
            </div><br>
            <div class="input_field">
                <label>LANGUAGES KNOWN: </label>
                <input type="checkbox" name="r1[]" value="php"<?php if(isset($_POST['r1']))
                if(in_array("php", $_POST['r1']))
                { echo "checked"; } else { echo ''; } ?>><label style="margin-left: 15px;">php</label>
                <input type="checkbox" name="r1[]" value="python"<?php if(isset($_POST['r1']))
                 if(in_array("python", $_POST['r1'])) 
                 { echo "checked"; } else { echo ''; } ?>><label style="margin-left: 15px;">python</label>
                <input type="checkbox" name="r1[]" value="c++"<?php if(isset($_POST['r1'])) if(in_array("c++", $_POST['r1']))
                { echo "checked"; } else { echo ''; } ?>><label style="margin-left: 15px;">c++</label> <br>    
                <br>
            <div class="input_field">
                <label>Gender</label>
                <select name="gender">
                    <option value="">SELECT</option>
                    <option value="M"
                    <?php if(isset($_POST['gender']) && $_POST['gender']== "M") { echo "selected"; } else { echo ''; } ?>
                    >MALE</option>
                    <option value="F"
                    <?php if(isset($_POST['gender']) && $_POST['gender']== "F") { echo "selected"; } else { echo ''; } ?>
                    >FEMALE</option>
                </select>  
            </div><br>
            <div class="input_field">
                <label>Password</label>
                <input type="password" class="input" value="<?php if(isset($_POST['password'])) { echo $_POST['password']; } else { echo ''; } ?>" name="password">   
            </div><br>
            <div class="input_field">
                <label>Confirm password</label>
                <input type="password" class="input" value="<?php if(isset($_POST['cpassword'])) { echo $_POST['cpassword']; } else { echo ''; } ?>" name="cpassword">   
            </div><br>
             <div class="input_field">
                <label>Address</label>
              <input type="textarea" name="address" value="<?php if(isset($_POST['address'])) { echo $_POST['address']; } else { echo ''; } ?>" >  
            </div><br>
            <div class="clearfix">
            
      <button type="submit" name="submit" class="signupbtn">Register</button>
    </div>
    </div>   
</form>
</body>
</html>


