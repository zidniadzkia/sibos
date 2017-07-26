<?php
$konek = new Database();
$sk = new Sekolah();
$pag = new Paging();

//cek apakah sudah login
if(!$konek->get_sesi()){
    header('location:login.php');
}

if($_GET['kanal']=='sekolah'){
?>
<!--************************-->  
<div class="row">
	<div class="panel-heading"><span class="glyphicon glyphicon-book"></span>&nbsp;&nbsp;DATA Sekolah</div>
        <p><a href="?kanal=sekolah&aksi=tambah" class="btn btn-info"><i class="glyphicon glyphicon-plus"></i> Tambah Data</a></p>
<!--************************-->

<!--Form Tambah Data-->
<?php
    if($_GET['kanal']=='sekolah' and $_GET['aksi']=='tambah'){
?>
        <form method="POST" action="?kanal=sekolah&aksi=insert">
            <table class="table table-bordered table-responsive">
                <thead>
                    <tr><th colspan="2"><i class="glyphicon glyphicon-plus-sign"></i> Form insert data sekolah </th></tr>
                </thead>
                <tbody>
                    <tr>
                        <td>NSS :</td>
                        <td><input type="number" name="nss" class="form-control" placeholder=" NSS" size="5"></td>
                    </tr>  
                    <tr>
                        <td>Nama Sekolah :</td>
                        <td><input type="text" name="ns" class="form-control" placeholder=" Nama Sekolah"></td>
                    </tr>  
                    <tr>
                        <td>Alamat :</td>
                        <td><textarea name="almt" class="form-control" placeholder=" Alamat Sekolah"></textarea></td>
                    </tr>  
                    <tr>
                        <td>Nama KepSek. :</td>
                        <td><input type="text" name="nk" class="form-control" placeholder=" Nama Kepala Sekolah"></td>
                    </tr>  
                    <tr>
                        <td>Keterangan :</td>
                        <td><textarea name="ket" class="form-control" placeholder=" Keterangan"></textarea></td>
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
    }else if($_GET['kanal']=='sekolah' and $_GET['aksi']=='edit'){
        $id = $_GET['id'];
?>
        <form method="POST" action="?kanal=sekolah&aksi=update">
            <input type="hidden" name="id" value="<?php echo $id;?>">
            <table class="table table-bordered table-responsive">
                <thead>
                    <tr><th colspan="2"><i class="glyphicon glyphicon-plus-sign"></i> Form update data sekolah </th></tr>
                </thead>
                <tbody>
                    <tr>
                        <td>NSS :</td>
                        <td><input type="number" name="nss" class="form-control" size="5" value="<?php echo $sk->AmbilSk('nss', $id)?>" readonly="readonly"></td>
                    </tr>  
                    <tr>
                        <td>Nama Sekolah :</td>
                        <td><input type="text" name="ns" class="form-control" value="<?php echo $sk->AmbilSk('nama_sklh', $id)?>"></td>
                    </tr>  
                    <tr>
                        <td>Alamat :</td>
                        <td><textarea name="almt" class="form-control"><?php echo $sk->AmbilSk('alamat', $id)?></textarea></td>
                    </tr>  
                    <tr>
                        <td>Nama Kepala :</td>
                        <td><input type="text" name="nk" class="form-control" value="<?php echo $sk->AmbilSk('nama_kpl', $id)?>"></td>
                    </tr>  
                    <tr>
                        <td>Keterangan :</td>
                        <td><textarea name="ket" class="form-control" ><?php echo $sk->AmbilSk('ket', $id)?></textarea></td>
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
    }elseif ($_GET['kanal']=='sekolah' and $_GET['aksi']=='insert') {
        $nss = antiInjection($_POST['nss']);
        $ns = antiInjection($_POST['ns']);
        $almt = antiInjection($_POST['almt']);
        $nk = antiInjection($_POST['nk']);
        $ket = antiInjection($_POST['ket']);
        
        $sk->TambahSk($nss,$ns,$almt,$nk,$ket);
    
    }elseif ($_GET['kanal']=='sekolah' and $_GET['aksi']=='update') {
        $nss = antiInjection($_POST['nss']);
        $ns = antiInjection($_POST['ns']);
        $almt = antiInjection($_POST['almt']);
        $nk = antiInjection($_POST['nk']);
        $ket = antiInjection($_POST['ket']);
        
        $sk->UpdateSk($nss,$ns,$almt,$nk,$ket);
        
    }elseif ($_GET['kanal']=='sekolah' and $_GET['aksi']=='hapus') {
        $id = $_GET['id'];
        $sk->HapusSk($id);
    }
    
    //tampil data dan paging halaman
    $batas = 10;
    $posisi = $pag->cariPosisi($batas);
    $arraysekolah = $sk->TampilSk($posisi,$batas);
?>
<!--End-->

<!--Tampil Data-->
    <table class="table table-bordered table-responsive table-condensed">
        <thead>
            <tr><td>NO</td>
                <td>NSS</td>
                <td>Nama Sekolah</td>
                <td>Nama KepSek</td>
                <td><i class="glyphicon glyphicon-cog"></i> Opsi</td></tr>
        </thead>
    <?php
    $no =$posisi+1;
    foreach ($arraysekolah as $data){
        echo "<tbody>"
            . "<tr>"
                . "<td>$no.</td>"
                . "<td>$data[nss]</td>"
                . "<td>$data[nama_sklh]</td>"
                . "<td>$data[nama_kpl]</td>"
                . "<td align='center'>"
                . "<a href='?kanal=sekolah&aksi=edit&id=$data[nss]' data-toggle='tooltip' data-placement='bottom' title='Edit data'><i class='glyphicon glyphicon-edit'></i></a> "
                . " -- "
                . "<a href='?kanal=sekolah&aksi=hapus&id=$data[nss]' data-toggle='tooltip' data-placement='bottom' title='Hapus data'><i class='glyphicon glyphicon-trash'></i></a>"

                . "</td>"
            . "</tr>"
            . "</tbody>";
        $no++;
    }
        echo"</table>";
        //paging
        $data_jml = $pag->Jml_data('sekolah');
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

