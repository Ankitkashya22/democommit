<?php
session_start();

if(!isset($_SESSION['user_admin'])){
    header("location: http://localhost/crud/admin_login.php");
}

?>
