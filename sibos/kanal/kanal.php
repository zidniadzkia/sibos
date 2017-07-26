<?php
session_start();
$konek = new Database();
//cek apakah sudah login
if(!$konek->get_sesi()){
    header('location:login.php');
}

//link kanal data
function PageKan($level){
    if( $level=='superadmin'){
    $knl =$_GET['kanal'];
        if($knl == 'user')
            include_once 'user.php';
        else if($knl == 'belanja')
            include_once 'belanja.php';
        else if($knl == 'satuan')
            include_once 'satuan.php';
        else if($knl == 'pajak')
            include_once 'pajak.php';    
        else if($knl == 'rekening')
            include_once 'rekening.php';
        else if($knl == 'dana')
            include_once 'dana.php';
        else if($knl == 'komponen')
            include_once 'komponen.php';
        else if($knl == 'realisasi')
            include_once 'realisasi.php';
        else if($knl == 'rapbs')
            include_once 'rapbs.php';
        else if($knl == 'sekolah')
            include_once 'sekolah.php';
        else if($knl == 'profil')
            include_once 'profil.php';
        else
            include_once '404.php';
    }else if($level=='admin') {       
    $knl =$_GET['kanal'];
        if($knl == 'dana')
            include_once 'dana.php';
        else if($knl == 'komponen')
            include_once 'komponen.php';
        else if($knl == 'realisasi')
            include_once 'realisasi.php';
        else if($knl == 'rapbs')
            include_once 'rapbs.php';
        else if($knl == 'sekolah')
            include_once 'sekolah.php';
        else if($knl == 'profil')
            include_once 'profil.php';
        else
            include_once '404.php';
    }    
}    

//pembagian kanal berdasarkan level hak akses
function LevKan($level){
    if($level=='superadmin'){
        echo"<li class='dropdown-header'>Data Master</li>
            <li><a href='?kanal=belanja'><i class='glyphicon glyphicon-shopping-cart'></i> Belanja</a></li>
            <li><a href='?kanal=pajak'><i class='glyphicon glyphicon-briefcase'></i> Pajak</a></li>
            <li><a href='?kanal=rekening'><i class='glyphicon glyphicon-list-alt'></i> Rekening</a></li>
            <li><a href='?kanal=satuan'><i class='glyphicon glyphicon-tag'></i> Satuan</a></li>
            <li><a href='?kanal=user'><i class='glyphicon glyphicon-user'></i> User</a></li>
            <li role='separator' class='divider'></li>
            <li class='dropdown-header'>Laporan</li>
            <li><a href='?kanal=dana'><i class='glyphicon glyphicon-usd'></i> Dana</a></li>
            <li><a href='?kanal=komponen'><i class='glyphicon glyphicon-road'></i> Komponen</a></li>
            <li><a href='?kanal=realisasi'><i class='glyphicon glyphicon-globe'></i> Realisasi</a></li>
            <li><a href='?kanal=sekolah'><i class='glyphicon glyphicon-education'></i> Sekolah</a></li>
            <li><a href='?kanal=rapbs'><i class='glyphicon glyphicon-book'></i> RAPBS</a></li>";
    }elseif($level=='admin'){
        echo"<li role='separator' class='divider'></li>
            <li class='dropdown-header'>Laporan</li>
            <li><a href='?kanal=dana'><i class='glyphicon glyphicon-usd'></i> Dana</a></li>
            <li><a href='?kanal=komponen'><i class='glyphicon glyphicon-road'></i> Komponen</a></li>
            <li><a href='?kanal=realisasi'><i class='glyphicon glyphicon-globe'></i> Realisasi</a></li>
            <li><a href='?kanal=sekolah'><i class='glyphicon glyphicon-education'></i> Sekolah</a></li>
            <li><a href='?kanal=rapbs'><i class='glyphicon glyphicon-book'></i> RAPBS</a></li>";
    }
}   

//info dashboard
function InfoDash(){
    if($_SESSION['level']=='superadmin'){
        echo"<div class='jumbotron alert-info'>"
            . "<h3>Selamat datang</h3>"
            . "<p>Ini adalah halaman administrator dimana anda dapat menambah,mengedit serta menghapus data yang telah ada di sistem.</p>"
            . "<p>Panduan :</p>"
            . "<ol type='1'>"
                . "<li>Isikan terlebih dahulu semua data master.</li>"
                . "<li>Untuk melihat data RAPBS yang sudah disusun oleh sekolah bisa dilihat di menu RAPBS.</li>"
                . "<li>Untuk melihat data Realisasi BOS yang sudah disusun oleh sekolah bisa dilihat di menu Realisasi.</li>"
                . "<li>Harap gunakan Sistem Informasi Dana BOS dengan sebijak mungkin.</li>"
            . "</ol>"
            . "</div>";
    }else if($_SESSION['level']=='admin'){    
        echo"<div class='jumbotron alert-warning'>"
                    . "<h3 class='media-heading'>Selamat datang</h3><hr>"
                    . "<p>Ini adalah halaman administrator dimana anda dapat menambah,mengedit serta menghapus data yang telah ada di sistem.</p>";
    }
}