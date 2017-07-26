<?php
session_start();
error_reporting(0);
include_once '../core/bos.php';
include_once '../core/library.php';

$kon = new Database();
$rapbs = new Rapbs();
$user = new User();

//cek apakah sudah login
if(!$konek->get_sesi()){
    header('location:../login.php');
}

?>
<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="assets/images/BOS_logo.jpg" type="image/x-icon">

    <title>::Laporan::</title>

    <!-- Bootstrap core CSS -->
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .page-header{
            border-top: 2px double #000;
            border-bottom: 2px double #000;
        }
        th{
            background: #eee;
        }
    </style>
  </head>
  <body>      
<div class="container">
    <div class="table-responsive">
	<?php if($_GET['kanal']=='rapbs' and $_SESSION['level']){?>
        <div class="page-header text-center"><h2>LAPORAN RAPBS TAHUN 2016</h2></div>
        <table class="table table-bordered table-condensed">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>ID RAPBS</th>
                    <th>ID NSS</th>
                    <th>Tahun</th>
                    <th>Koefisien 1</th>
                    <th>Koefisien 2</th>
                    <th>Koefisien 3</th>
                    <th>Koefisien 4</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $arrayrapbs = $rapbs->TampilRs(0,30); 
            $no=1;
            foreach ($arrayrapbs as $data){
                
                echo"<tr>"
                . "<td>$no.</td>"
                . "<td>$data[id_rapbs]</td>"
                . "<td>$data[nss]</td>"
                . "<td>$data[tahun]</td>"
                . "<td>$data[koefisien1]</td>"
                . "<td>$data[koefisien2]</td>"
                . "<td>$data[koefisien3]</td>"
                . "<td>$data[koefisien4]</td>"
                . "</tr>";
                $no++;
            }
            ?>
            </tbody>    
        </table>
        <footer class="pull-right"><p><?php echo date("d F Y");?></p></footer>
        <!--laopran user khusus super admin-->
        <?php }else if($_GET['kanal']=='user' and $_SESSION['level']=='superadmin'){?>
	<div class="page-header text-center"><h2>LAPORAN DATA USER </h2></div>
        <table class="table table-bordered table-condensed">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Username</th>
                    <th>Password</th>
                    <th>Level</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $arrayuser = $user->TampilUs(0,20); 
            $no=1;
            foreach ($arrayuser as $data){
                
                echo"<tr>"
                . "<td>$no.</td>"
                . "<td>$data[username]</td>"
                . "<td>$data[password]</td>"
                . "<td>$data[level]</td>"
                . "</tr>";
                $no++;
            }
            ?>
            </tbody>    
        </table>
        <footer class="pull-right"><p><?php echo date("d F Y");?></p></footer>
		
		<?php
		}else{
				echo "Tidak ada data yang dicetak";
		}	
		?>
    </div>
</div>
</body>
</html>