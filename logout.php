<?php
$mysqli = new mysqli("localhost","root","","crud");
    
if ($mysqli -> connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
    exit();
}

session_start();

session_unset();

session_destroy();


header("location: http://localhost/crud/admin_login.php");

?>