<?php
session_start();
unset($_SESSION['nama']); 
unset($_SESSION['sandi']); 
unset($_SESSION['level']); 
session_destroy(); 
    header('location:../login.php');
?>