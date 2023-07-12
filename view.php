<?php
session_start();

if(!isset($_SESSION['user_admin'])){
    header("location: http://localhost/crud/admin_login.php");
}
?>
<!DOCTYPE html>  
<html>  
<head>  
<meta name="viewport" content="width=device-width, initial-scale=1"> 
</head>
<body>
 <center><h1> <b>WELCOME ADMIN<b> </h1></center>
 <center><a href="signup.php"><input type="button" value="Add" /></a></center>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
<?php 
$conn = mysqli_connect("localhost","root","","crud") or die("connection failed");
$sql = "SELECT * FROM `person`";
$result = mysqli_query($conn, $sql) or die("query failed.");
if(mysqli_num_rows($result) > 0){
?>
<table border="2px" width="100%" class="table">
    <thead>
        <th>ID</th>
        <th>Firstname</th>
        <th>Lastname</th>
        <th>email</th>
        <th>contact</th>
        <th>Date of Birth</th>
        <th>gender</th> 
        <th>language</th> 
        <th>password</th>
        <th>address</th>
        <th>Action</th>
        <th><input type="submit" name="delete" value="delete"></th>
    </thead>
    <tbody>
        <?php  
        while($rows = mysqli_fetch_assoc($result)){
        ?>
        <td><?php echo $rows['ID'];?></td>
        <td><?php echo $rows['firstname'];?></td>
        <td><?php echo $rows['lastname'];?></td>
        <td><?php echo $rows['email'];?></td>
        <td><?php echo $rows['contact'];?></td>
        <td><?php echo $rows['dob'];?></td>
        <td><?php echo $rows['gender'];?></td>
        <td><?php echo $rows['languages'];?></td>
        <td><?php echo $rows['password'];?></td>
        <td><?php echo $rows['address'];?></td>
        <td><a href="delete.php?ID=<?php echo $rows['ID']; ?>"><input type="button" value="Delete"></a></td>
        <td><a href="update.php?ID=<?php echo $rows['ID']; ?>"><input type="button" value="Update"></a></td>
        <td>
            <input type="checkbox" name="checkbox[]" value="<?php echo $rows['ID']; ?>" >
        </td>
</tbody>
<?php } ?>
</table>

<center><a href="admin_login.php"><input type="button" value="LogOuT"/></a></center>
</form>
<?php }
else{
    echo "No record found.";
} ?>

<!-- <a href="logout.php"><button onclick="alert('You are logout successfully....')" type="submit"> logout </button></a> -->
</body>
</html>

<?php
if(isset($_POST['delete'])){
    $checkbox = $_POST['checkbox'];
    for($i=0;$i<count($checkbox); $i++){
        $del_id = $checkbox[$i];
        $sql1 = "DELETE FROM `person` WHERE `ID` = '$del_id'";
        $result1 = mysqli_query($conn, $sql1) or die("query failed.");
    }
    if($result1){
        header("location: http://localhost/crud/view.php");
    }
}

mysqli_close($conn);
?>