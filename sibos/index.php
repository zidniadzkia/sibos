<?php
session_start();
error_reporting(0);
include_once './core/bos.php';
include_once './core/library.php';
include_once './kanal/kanal.php';
$bos = new Database();
$level = $_SESSION['level'];
//cek apakah sudah login
if(!$bos->get_sesi()){
    header('location:login.php');
}    

//logout
if($_GET['aksi']=='keluar'){
    $bos->logout();
    header('location:login.php');
}
?>
// nitip komentar
// code di bawah ini adalah HTML
<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="assets/images/BOS.jpg" type="image/x-icon">

    <title>:: SIBOS ::</title>

    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="assets/css/dashboard.css" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>
    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Kanal</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
            <a class="navbar-brand" href="index.php"><i class="glyphicon glyphicon-"></i> SIBOS</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
              <li><a href="index.php"><i class="glyphicon glyphicon-th-large"></i> Dashboard</a></li>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="glyphicon glyphicon-list"></i> Kanal</a>
                <ul class="dropdown-menu">
                    <?php echo LevKan($level);?>
                </ul>
            </li>
            <li>
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                    <img src="assets/images/admin.jpg" width="23" class="img-circle img-thumbnail"> 
                        <?php echo $_SESSION['nama']?></a>
                <ul class="dropdown-menu">
                    <li><a href="?kanal=profil&id=<?php echo $_SESSION['id'];?>"><i class="glyphicon glyphicon-user"></i> Profil</a></li>
                    <li><a href="?aksi=keluar"><i class="glyphicon glyphicon-log-out"></i> Keluar</a></li>
                </ul>
            </li>
          </ul>
            <form class="navbar-form navbar-right" method="POST" action="<?php echo "$_SERVER[PHP_SELF]?kanal=$_GET[kanal]";?>">
                <input type="hidden" name="do" value="find">
                <input type="text" class="form-control" name="key" placeholder="Search...">
          </form>
        </div>
      </div>
    </nav>

    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
          <ul class="nav nav-sidebar">
            <li><a href="index.php"><i class="glyphicon glyphicon-th-large"></i> Dashboard</a></li>
            <?php echo LevKan($level);?>
          </ul>
        </div>
          
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <?php
          if(isset($_GET['kanal'])){
            echo PageKan($level);
          }else{
          ?>  
          <h1 class="page-header">Dashboard</h1>

          <div class="row placeholders">
            <div class="col-xs-6 col-sm-3 placeholder">
                <img src="assets/images/1.png" width="200" height="200" class="img-responsive img-circle" alt="Generic placeholder thumbnail">
              <h4>Beasiswa</h4>
              <span class="text-muted">Dapatkan beasiswamu</span>
            </div>
            <div class="col-xs-6 col-sm-3 placeholder">
              <img src="assets/images/ji.png" width="200" height="200" class="img-responsive img-circle" alt="Generic placeholder thumbnail">
              <h4>Kedisiplinan</h4>
              <span class="text-muted">Teguhkan niatmu</span>
            </div>
            <div class="col-xs-6 col-sm-3 placeholder">
                <img src="assets/images/ap.png" width="200" height="200" class="img-responsive img-circle" alt="Generic placeholder thumbnail">
              <h4>Prestasi</h4>
              <span class="text-muted">Tunjukkan dirimu</span>
            </div>
            <div class="col-xs-6 col-sm-3 placeholder">
              <img src="assets/images/hy.png" width="200" height="200" class="img-responsive img-circle" alt="Generic placeholder thumbnail">
              <h4>Pemikiran</h4>
              <span class="text-muted">Dunia tanganmu</span>
            </div>
          </div>

          <h2 class="sub-header"><?php echo "Hallo <i>".$_SESSION['nama']."</i>" ?></h2>
          <div class="table-responsive">
              <?php echo InfoDash($level);?>
          </div>
          <?php }?>
        </div>
      </div>
    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    </body>
</html>
