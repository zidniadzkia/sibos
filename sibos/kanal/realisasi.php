<?php
$konek = new Database();
$rl = new Realisasi();
$pag = new Paging();

//cek apakah sudah login
if(!$konek->get_sesi()){
    header('location:login.php');
}

if($_GET['kanal']=='realisasi'){
?>
<!--************************-->  
<div class="row">
	<div class="panel-heading"><span class="glyphicon glyphicon-book"></span>&nbsp;&nbsp;DATA Realisasi</div>
        <p><a href="?kanal=realisasi&aksi=tambah" class="btn btn-info"><i class="glyphicon glyphicon-plus"></i> Tambah Data</a></p>
<!--************************-->

<!--Form Tambah Data-->
<?php
    if($_GET['kanal']=='realisasi' and $_GET['aksi']=='tambah'){
?>
        <form method="POST" action="?kanal=realisasi&aksi=insert">
            <table class="table table-bordered table-responsive">
                <thead>
                    <tr><th colspan="2"><i class="glyphicon glyphicon-plus-sign"></i> Form insert data realisasi </th></tr>
                </thead>
                <tbody>
                    <tr>
                        <td>ID Komponen :</td>
                        <td><select name="idk" class="form-control">
                                <option value="0" selected="selected">Pilih ID komponen</option>
                        <?php
			$arrayKom = $konek->comboId('id_komponen','komponen','komponen');
			foreach($arrayKom as $data)
			{
			?>
				<option value="<?php  echo $data['id_komponen']; ?>"><?php  echo $data['komponen']; ?></option>
			<?php } ?>
                            </select>   
			</td>
                    </tr>  
                    <tr>
                        <td>Tanggal :</td>
                        <td><input type="date" name="tgl" class="form-control" placeholder=" Pilih Tanggal"></td>
                    </tr>  
                    <tr>
                        <td>Jumlah :</td>
                        <td><input type="number" name="jml" class="form-control" placeholder=" Jumlah"></td>
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
    }else if($_GET['kanal']=='realisasi' and $_GET['aksi']=='edit'){
        $id = $_GET['id'];
?>
        <form method="POST" action="?kanal=realisasi&aksi=update">
            <input type="hidden" name="id" value="<?php echo $id;?>">
            <table class="table table-bordered table-responsive">
                <thead>
                    <tr><th colspan="2"><i class="glyphicon glyphicon-plus-sign"></i> Form update data realisasi </th></tr>
                </thead>
                <tbody>
                    <tr>
                        <td>ID Komponen :</td>
                        <td><select name="idk" class="form-control">
                                <option value="0" selected="selected">Pilih ID Komponen</option>
                        <?php
			$idk = $rl->AmbilRl('id_komponen', $id);
			$arrayidk=$konek->comboId('id_komponen','komponen','komponen');
                        foreach($arrayidk as $Idk2)
			{   
                            if($idk == $Idk2['id_komponen']){
                                echo"<option value='$Idk2[id_komponen]' selected>$Idk2[komponen]</option>";
                            }else{
                                echo"<option value='$Idk2[id_komponen]'>$Idk2[komponen]</option>";
                            }    
                            
                        } ?>
                            </select>   
			</td>
                    </tr>  
                    <tr>
                        <td>Tanggal :</td>
                        <td><input type="date" name="tgl" class="form-control" value="<?php echo $rl->AmbilRl('tgl_realisasi', $id);?>"></td>
                    </tr>
                    <tr>
                        <td>Jumlah :</td>
                        <td><input type="number" name="jml" class="form-control" value="<?php echo $rl->AmbilRl('jml_realisasi', $id);?>"></td>
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
    }elseif ($_GET['kanal']=='realisasi' and $_GET['aksi']=='insert') {
        $idkom = $_POST['idk'];
        $tgl = $_POST['tgl'];
        $jml = $_POST['jml'];
        
        $rl->TambahRl($idkom,$tgl,$jml);
    
    }elseif ($_GET['kanal']=='realisasi' and $_GET['aksi']=='update') {
        $id = $_POST['id'];
        $idkom = $_POST['idk'];
        $tgl = $_POST['tgl'];
        $jml = $_POST['jml'];
        
        $rl->UpdateRl($id,$idkom,$tgl,$jml);
        
    }elseif ($_GET['kanal']=='realisasi' and $_GET['aksi']=='hapus') {
        $id = $_GET['id'];
        $rl->HapusRl($id);
    }
    
    //tampil data dan paging halaman
    $batas = 10;
    $posisi = $pag->cariPosisi($batas);
    $arrayrealisasi = $rl->TampilRl($posisi,$batas);
    //pencarian realisasi
    if($_POST['do']=='find'){
        $arrayrealisasi = $konek->FilterData('realisasi', 'jumlah', $_POST['key']);
    }
    
?>
<!--End-->

<!--Tampil Data-->
    <table class="table table-bordered table-responsive table-condensed">
        <thead>
            <tr><td>NO</td>
                <td>ID komponen</td>
                <td>Tanggal</td>
                <td>Jumlah</td>
                <td><i class="glyphicon glyphicon-cog"></i> Opsi</td></tr>
        </thead>
    <?php
    if(count($arrayrealisasi)){
        $no =$posisi+1;
        foreach ($arrayrealisasi as $data){
            echo "<tbody>"
                . "<tr>"
                    . "<td>$no.</td>"
                    . "<td>$data[id_komponen]</td>"
                    . "<td>$data[tgl_realisasi]</td>"
                    . "<td>$data[jml_realisasi]</td>"
                    . "<td align='center'>"
                    . "<a href='?kanal=realisasi&aksi=edit&id=$data[id_realisasi]' data-toggle='tooltip' data-placement='bottom' title='Edit data'><i class='glyphicon glyphicon-edit'></i></a> "
                    . " -- "
                    . "<a href='?kanal=realisasi&aksi=hapus&id=$data[id_realisasi]' data-toggle='tooltip' data-placement='bottom' title='Hapus data'><i class='glyphicon glyphicon-trash'></i></a>"
                    . "</td>"
                . "</tr>"
                . "</tbody>";
            $no++;
        }
        echo"</table>";
        //paging
        $data_jml = $pag->Jml_data('realisasi');
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

