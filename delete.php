<?php
$id=$_GET['ID'];

$conn = mysqli_connect("localhost","root","","crud") or die("connection failed");
$sql = "DELETE FROM `person` WHERE `ID`={$id}";

$result = mysqli_query($conn, $sql) or die("query failed.");

header("location: http://localhost/crud/view.php");

mysqli_close($conn);

?>