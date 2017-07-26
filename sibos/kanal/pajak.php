<?php
include_once 'core/bos.php';
$konek = new Database();
$pj = new Pajak();
$pag = new Paging();

//cek apakah sudah login
if(!$konek->get_sesi()){
    header('location:login.php');
}

if($_GET['kanal']=='pajak'){
?>
<!--************************-->  
<div class="row">
	<div class="panel-heading"><span class="glyphicon glyphicon-book"></span>&nbsp;&nbsp;DATA Pajak</div>
        <p><a href="?kanal=pajak&aksi=tambah" class="btn btn-info"><i class="glyphicon glyphicon-plus"></i> Tambah Data</a></p>
<!--************************-->

<!--Form Tambah Data-->
<?php
    if($_GET['kanal']=='pajak' and $_GET['aksi']=='tambah'){
?>
        <form method="POST" action="?kanal=pajak&aksi=insert">
            <table class="table table-bordered table-responsive">
                <thead>
                    <tr><th colspan="2"><i class="glyphicon glyphicon-plus-sign"></i> Form insert data pajak </th></tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Jenis Pajak :</td>
                        <td><input type="text" name="jns" class="form-control" placeholder=" Jenis Pajak"></td>
                    </tr>  
                    <tr>
                        <td>Jumlah Pajak :</td>
                        <td><input type="number" name="jml" class="form-control" placeholder=" Jumlah Pajak"></td>
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
    }else if($_GET['kanal']=='pajak' and $_GET['aksi']=='edit'){
        $id = $_GET['id'];
?>
        <form method="POST" action="?kanal=pajak&aksi=update">
            <input type="hidden" name="id" value="<?php echo $id;?>">
            <table class="table table-bordered table-responsive">
                <thead>
                    <tr><th colspan="2"><i class="glyphicon glyphicon-plus-sign"></i> Form update data pajak </th></tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Jenis Pajak :</td>
                        <td><input type="text" name="jns" class="form-control"  value="<?php echo $pj->AmbilPj('jns_pajak', $id);?>"></td>
                    </tr>
                    <tr>
                        <td>Jumlah Pajak :</td>
                        <td><input type="number
                                   " name="jml" class="form-control"  value="<?php echo $pj->AmbilPj('jumlah', $id);?>"></td>
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
    }elseif ($_GET['kanal']=='pajak' and $_GET['aksi']=='insert') {
        $jenis = $_POST['jns'];
        $jumlah = $_POST['jml'];
        
        $pj->TambahPj($jenis,$jumlah);
    
    }elseif ($_GET['kanal']=='pajak' and $_GET['aksi']=='update') {
        $id = $_POST['id'];
        $jenis = $_POST['jns'];
        $jumlah = $_POST['jml'];
        
        $pj->UpdatePj($id,$jenis,$jumlah);
        
    }elseif ($_GET['kanal']=='pajak' and $_GET['aksi']=='hapus') {
        $id = $_GET['id'];
        $pj->HapusPj($id);
    }
    
    //tampil data dan paging halaman
    $batas = 10;
    $posisi = $pag->cariPosisi($batas);
    $arraypajak = $pj->TampilPj($posisi,$batas);
?>
<!--End-->

<!--Tampil Data-->
    <table class="table table-bordered table-responsive table-condensed">
        <thead>
            <tr><td>NO</td>
                <td>Id Pajak</td>
                <td>Jenis Pajak </td>
                <td>Jumlah Pajak </td>
                <td><i class="glyphicon glyphicon-cog"></i> Opsi</td></tr>
        </thead>
    <?php
    $no =$posisi+1;
    foreach ($arraypajak as $data){
        echo "<tbody>"
            . "<tr>"
                . "<td>$no.</td>"
                . "<td>$data[id_pajak]</td>"
                . "<td>$data[jns_pajak]</td>"
                . "<td>$data[jumlah]</td>"
                . "<td align='center'>"
                . "<a href='?kanal=pajak&aksi=edit&id=$data[id_pajak]' data-toggle='tooltip' data-placement='bottom' title='Edit data'><i class='glyphicon glyphicon-edit'></i></a> "
                . " -- "
                . "<a href='?kanal=pajak&aksi=hapus&id=$data[id_pajak]' data-toggle='tooltip' data-placement='bottom' title='Hapus data'><i class='glyphicon glyphicon-trash'></i></a>"
                . "</td>"
            . "</tr>"
            . "</tbody>";
        $no++;
    }
        echo"</table>";
        //paging
        $data_jml = $pag->Jml_data('pajak');
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

