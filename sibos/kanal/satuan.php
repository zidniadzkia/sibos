<?php
$konek = new Database();
$st = new Satuan();
$pag = new Paging();

//cek apakah sudah login
if(!$konek->get_sesi()){
    header('location:login.php');
}

if($_GET['kanal']=='satuan'){
?>
<!--************************-->  
<div class="row">
	<div class="panel-heading"><span class="glyphicon glyphicon-book"></span>&nbsp;&nbsp;DATA Satuan</div>
        <p><a href="?kanal=satuan&aksi=tambah" class="btn btn-info"><i class="glyphicon glyphicon-plus"></i> Tambah Data</a></p>
<!--************************-->

<!--Form Tambah Data-->
<?php
    if($_GET['kanal']=='satuan' and $_GET['aksi']=='tambah'){
?>
        <form method="POST" action="?kanal=satuan&aksi=insert">
            <table class="table table-bordered table-responsive">
                <thead>
                    <tr><th colspan="2"><i class="glyphicon glyphicon-plus-sign"></i> Form insert data satuan </th></tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Nama Satuan :</td>
                        <td><input type="text" name="stn" class="form-control" placeholder=" Nama Satuan"></td>
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
    }else if($_GET['kanal']=='satuan' and $_GET['aksi']=='edit'){
        $id = $_GET['id'];
?>
        <form method="POST" action="?kanal=satuan&aksi=update">
            <input type="hidden" name="id" value="<?php echo $id;?>">
            <table class="table table-bordered table-responsive">
                <thead>
                    <tr><th colspan="2"><i class="glyphicon glyphicon-plus-sign"></i> Form update data satuan </th></tr>
                </thead>
                <tbody>
                    <tr>
                        <td>nama Satuan :</td>
                        <td><input type="text" name="stn" class="form-control"  value="<?php echo $st->AmbilSt('satuan', $id);?>"></td>
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
    }elseif ($_GET['kanal']=='satuan' and $_GET['aksi']=='insert') {
        $satu = $_POST['stn'];
        
        $st->TambahSt($satu);
    
    }elseif ($_GET['kanal']=='satuan' and $_GET['aksi']=='update') {
        $id = $_POST['id'];
        $satu = $_POST['stn'];
        
        $st->UpdateSt($id,$satu);
        
    }elseif ($_GET['kanal']=='satuan' and $_GET['aksi']=='hapus') {
        $id = $_GET['id'];
        $st->HapusSt($id);
    }
    
    //tampil data dan paging halaman
    $batas = 10;
    $posisi = $pag->cariPosisi($batas);
    $arraysatuan = $st->TampilSt($posisi,$batas);
?>
<!--End-->

<!--Tampil Data-->
    <table class="table table-bordered table-responsive table-condensed">
        <thead>
            <tr><td>NO</td>
                <td>Id Satuan</td>
                <td>Satuan </td>
                <td><i class="glyphicon glyphicon-cog"></i> Opsi</td></tr>
        </thead>
    <?php
    $no =$posisi+1;
    foreach ($arraysatuan as $data){
        echo "<tbody>"
            . "<tr>"
                . "<td>$no.</td>"
                . "<td>$data[id_satuan]</td>"
                . "<td>$data[satuan]</td>"
                . "<td align='center'>"
                . "<a href='?kanal=satuan&aksi=edit&id=$data[id_satuan]' data-toggle='tooltip' data-placement='bottom' title='Edit data'><i class='glyphicon glyphicon-edit'></i></a> "
                . " -- "
                . "<a href='?kanal=satuan&aksi=hapus&id=$data[id_satuan]' data-toggle='tooltip' data-placement='bottom' title='Hapus data'><i class='glyphicon glyphicon-trash'></i></a>"
                . "</td>"
            . "</tr>"
            . "</tbody>";
        $no++;
    }
        echo"</table>";
        //paging
        $data_jml = $pag->Jml_data('satuan');
        $hal_jml = $pag->jumlahHalaman($data_jml,$batas);
        $link_hal = $pag->navHalaman($_GET['halaman'], $hal_jml);
        echo"<div class='pager pager-sm'>"
            . "<ul>"
                . "<li>$link_hal</li>"
            . "</ul>"
            . "</div>";
    
    ?>
</div>
<?php
}
?>
<!--End-->

