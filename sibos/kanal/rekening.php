<?php
$konek = new Database();
$rk = new Rekening();
$pag = new Paging();

//cek apakah sudah login
if(!$konek->get_sesi()){
    header('location:login.php');
}

if($_GET['kanal']=='rekening'){
?>
<!--************************-->  
<div class="row">
	<div class="panel-heading"><span class="glyphicon glyphicon-book"></span>&nbsp;&nbsp;DATA Rekening</div>
        <p><a href="?kanal=rekening&aksi=tambah" class="btn btn-info"><i class="glyphicon glyphicon-plus"></i> Tambah Data</a></p>
<!--************************-->

<!--Form Tambah Data-->
<?php if($_GET['kanal']=='rekening' and $_GET['aksi']=='tambah') {?>
        <form method="POST" action="?kanal=rekening&aksi=insert">
            <table class="table table-bordered table-responsive">
                <thead>
                    <tr><th colspan="2"><i class="glyphicon glyphicon-plus-sign"></i> Form insert data rekening </th></tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Nama Rekening :</td>
                        <td><input type="text" name="rkn" class="form-control" placeholder=" Nama Rekening"></td>
                    </tr>  
                    <tr>
                        <td colspan="2">
                            <input type="submit" name="simpan" class="btn btn-primary" value="Simpan"> |     
                            <input type="reset" name="batal" class="btn btn-danger" value="Batal">     
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>
<!--End-->

<!--from Edit Data-->
<?php
    }else if($_GET['kanal']=='rekening' and $_GET['aksi']=='edit'){
        $id = $_GET['id'];
?>
        <form method="POST" action="?kanal=rekening&aksi=update">
            <input type="hidden" name="id" value="<?php echo $id;?>">
            <table class="table table-bordered table-responsive">
                <thead>
                    <tr><th colspan="2"><i class="glyphicon glyphicon-plus-sign"></i> Form update data rekening </th></tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Nama Rekening :</td>
                        <td><input type="text" name="rkn" class="form-control"  value="<?php echo $rk->AmbilRk('nm_rekening', $id);?>"></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <input type="submit" name="update" class="btn btn-primary" value="Update"> |     
                            <input type="reset" name="batal" class="btn btn-danger" value="Batal">     
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>
<!--End-->

<!--Proses-->
<?php 
    }elseif ($_GET['kanal']=='rekening' and $_GET['aksi']=='insert') {
        $nm = $_POST['rkn'];
        
        $rk->TambahRk($nm);
    
    }elseif ($_GET['kanal']=='rekening' and $_GET['aksi']=='update') {
        $id = $_POST['id'];
        $nm = $_POST['rkn'];
        
        $rk->UpdateRk($id,$nm);
        
    }elseif ($_GET['kanal']=='rekening' and $_GET['aksi']=='hapus') {
        $id = $_GET['id'];
        $rk->HapusRk($id);
    }
    
    //tampil data dan paging halaman
    $batas = 10;
    $posisi = $pag->cariPosisi($batas);
    $arrayrekening = $rk->TampilRk($posisi,$batas);
    //pencarian rekening
    if($_POST['do']=='find'){
        $arrayrekening = $konek->FilterData('rekening', 'nm_rekening', $_POST['key']);
    }
    
?>
<!--End-->

<!--Tampil Data-->
    <table class="table table-bordered table-responsive table-condensed">
        <thead>
            <tr><td>NO</td>
                <td>Id Rekening</td>
                <td>Nama Rekening </td>
                <td><i class="glyphicon glyphicon-cog"></i> Opsi</td></tr>
        </thead>
    <?php
    if(count($arrayrekening)){
        $no =$posisi+1;
        foreach ($arrayrekening as $data){
            echo "<tbody>"
                . "<tr>"
                    . "<td>$no.</td>"
                    . "<td>$data[id_rekening]</td>"
                    . "<td>$data[nm_rekening]</td>"
                    . "<td align='center'>"
                    . "<a href='?kanal=rekening&aksi=edit&id=$data[id_rekening]' data-toggle='tooltip' data-placement='bottom' title='Edit data'><i class='glyphicon glyphicon-edit'></i></a> "
                    . " -- "
                    . "<a href='?kanal=rekening&aksi=hapus&id=$data[id_rekening]' data-toggle='tooltip' data-placement='bottom' title='Hapus data'><i class='glyphicon glyphicon-trash'></i></a>"
                    . "</td>"
                . "</tr>"
                . "</tbody>";
            $no++;
        }
        echo"</table>";
        //paging
        $data_jml = $pag->Jml_data('rekening');
        $hal_jml = $pag->jumlahHalaman($data_jml,$batas);
        $link_hal = $pag->navHalaman($_GET['halaman'], $hal_jml);
        echo"<div class='pager pager-sm'>"
            . "<ul>"
                . "<li>$link_hal</li>"
            . "</ul>"
            . "</div>";
    
    }else{
        echo "<div class='alert alert-danger'>"
                    . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                    . "<strong>Tidak ditemukan data dengan kata kunci ".$_POST['key']."</strong>"
                . "</div>";
    }
    ?>
    </div>
<?php
}
?>
<!--End-->

