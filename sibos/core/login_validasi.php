<?php
session_start();
error_reporting(0);
include_once './bos.php';
$bos = new Database();

//jika sudah login 
    if($bos->get_sesi()){
        header('location:../index.php');
    }

//cek login user
    $user = strip_tags($_POST['username']);
    $pswd = strip_tags($_POST['password']);
    $cek = $bos->ValLog($user, $pswd);
    if($cek){
        header('location:../index.php');
    }  else {
        header('location:../login.php?info=gagal');
    }