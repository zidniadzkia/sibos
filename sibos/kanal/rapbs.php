<?php
$konek = new Database();
$rap = new RAPBS();
$pag = new Paging();

//cek apakah sudah login
if(!$konek->get_sesi()){
    header('location:login.php');
}

if($_GET['kanal']=='rapbs'){
?>
<!--************************-->  
<div class="row">
	<div class="panel-heading"><span class="glyphicon glyphicon-book"></span>&nbsp;&nbsp;DATA RAPBS</div>
        <p>
            <a href="?kanal=rapbs&aksi=tambah" class="btn btn-info"><i class="glyphicon glyphicon-plus"></i> Tambah Data</a>
            <a href="kanal/lapor.php?kanal=rapbs" class="btn btn-info" target="_blank"><i class="glyphicon glyphicon-print"></i> Cetak Data</a>
        </p>
<!--************************-->

<!--Form Tambah Data-->
<?php
    if($_GET['kanal']=='rapbs' and $_GET['aksi']=='tambah'){
?>
        <form method="POST" action="?kanal=rapbs&aksi=insert">
            <table class="table table-bordered table-responsive">
                <thead>
                    <tr><th colspan="2"><i class="glyphicon glyphicon-plus-sign"></i> Form insert data rapbs </th></tr>
                </thead>
                <tbody>
                    <tr>
                        <td>ID RAPBS :</td>
                        <td><input type="number" name="rap" class="form-control" placeholder=" RAPBS"></td>
                    </tr>  
                    <tr>
                        <td>NSS :</td>
                        <td><select name="nss" class="form-control">
                                <option value="0" selected="selected">Pilih NSS</option>
                        <?php
			$arrayNss = $konek->comboId('nss','nama_sklh','sekolah');
			foreach($arrayNss as $data)
			{
			?>
				<option value="<?php  echo $data['nss']; ?>"><?php  echo $data['nama_sklh']; ?></option>
			<?php } ?>
                            </select>   
			</td>
                    </tr>  
                    <tr>
                        <td>ID Satuan :</td>
                        <td><select name="ids" class="form-control">
                                <option value="0" selected="selected">Pilih ID Satuan</option>
                        <?php
			$arraySat = $konek->comboId('id_satuan','satuan','satuan');
			foreach($arraySat as $data)
			{
			?>
				<option value="<?php  echo $data['id_satuan']; ?>"><?php  echo $data['satuan']; ?></option>
			<?php } ?>
                            </select>   
			</td>
                    </tr>  
                    <tr>
                        <td>ID Komponen :</td>
                        <td><select name="idk" class="form-control">
                                <option value="0" selected="selected">Pilih ID Komponen</option>
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
                        <td>Tahun :</td>
                        <td><input type="date" name="thn" class="form-control" placeholder=" Pilih Koefisien 1"></td>
                    </tr>  
                    <tr>
                        <td>Koefisien 1 :</td>
                        <td><input type="text" name="kf1" class="form-control" placeholder=" Pilih Koefisien 1"></td>
                    </tr>  
                    <tr>
                        <td>Koefisien 2 :</td>
                        <td><input type="text" name="kf2" class="form-control" placeholder=" Pilih Koefisien 2"></td>
                    </tr>  
                    <tr>
                        <td>Koefisien 3 :</td>
                        <td><input type="text" name="kf3" class="form-control" placeholder=" Pilih Koefisien 3"></td>
                    </tr>  
                    <tr>
                        <td>Koefisien 4 :</td>
                        <td><input type="text" name="kf4" class="form-control" placeholder=" Pilih Koefisien 4"></td>
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
    }else if($_GET['kanal']=='rapbs' and $_GET['aksi']=='edit'){
        $id = $_GET['id'];
?>
        <form method="POST" action="?kanal=rapbs&aksi=update">
            <input type="hidden" name="id" value="<?php echo $id;?>">
            <table class="table table-bordered table-responsive">
                <thead>
                    <tr><th colspan="2"><i class="glyphicon glyphicon-plus-sign"></i> Form update data rapbs </th></tr>
                </thead>
                <tbody>
                    <tr>
                        <td>ID RAPBS :</td>
                        <td><input type="number" name="rap" class="form-control" value="<?php echo $rap->AmbilRs('id_rapbs', $id);?>" readonly="readonly"></td>
                    </tr>
                    <tr>
                        <td>NSS :</td>
                        <td><select name="nss" class="form-control">
                                <option value="0" selected="selected">--NSS--<option>
                        <?php
                        $nos = $rap->AmbilRs('nss', $id);
			$arraynos=$konek->comboId('nss','nama_sklh','sekolah');
                        foreach($arraynos as $nos2)
			{   
                            if($nos == $nos2['nss']){
                                echo"<option value='$nos2[nss]' selected>$nos2[nama_sklh]</option>";
                            }else{
                                echo"<option value='$nos2[nss]'>$nos2[nama_sklh]</option>";
                            }    
                            
                        } ?>
                            </select>   
			</td>
                    </tr>  
                    <tr>
                        <td>ID Satuan :</td>
                        <td><select name="ids" class="form-control">
                                <option value="0" selected="selected">Pilih ID Satuan</option>
                        <?php
                        $ids = $rap->AmbilRs('id_satuan', $id);
			$arrayids=$konek->comboId('id_satuan','satuan','satuan');
                        foreach($arrayids as $Ids2)
			{   
                            if($ids == $Ids2['id_satuan']){
                                echo"<option value='$Ids2[id_satuan]' selected>$Ids2[satuan]</option>";
                            }else{
                                echo"<option value='$Ids2[id_satuan]'>$Ids2[satuan]</option>";
                            }    
                            
                        } ?>
                            </select>   
			</td>
                    </tr>  
                    <tr>
                        <td>ID Komponen :</td>
                        <td><select name="idk" class="form-control">
                                <option value="0" selected="selected">Pilih ID Komponen</option>
                        <?php
			$idk = $rap->AmbilRs('id_komponen', $id);
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
                        <td>Tahun :</td>
                        <td><input type="date" name="thn" class="form-control" value="<?php echo $rap->AmbilRs('tahun', $id);?>"></td>
                    </tr>  
                    <tr>
                        <td>Koefisien 1 :</td>
                        <td><input type="text" name="kf1" class="form-control" value="<?php echo $rap->AmbilRs('koefisien1', $id);?>"></td>
                    </tr>  
                    <tr>
                        <td>Koefisien 2 :</td>
                        <td><input type="text" name="kf2" class="form-control" value="<?php echo $rap->AmbilRs('koefisien2', $id);?>"></td>
                    </tr>  
                    <tr>
                        <td>Koefisien 3 :</td>
                        <td><input type="text" name="kf3" class="form-control" value="<?php echo $rap->AmbilRs('koefisien3', $id);?>"></td>
                    </tr>  
                    <tr>
                        <td>Koefisien 4 :</td>
                        <td><input type="text" name="kf4" class="form-control" value="<?php echo $rap->AmbilRs('koefisien4', $id);?>"></td>
                    </tr>
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
    }elseif ($_GET['kanal']=='rapbs' and $_GET['aksi']=='insert') {
        $rpb = antiInjection($_POST['rap']);
        $ssn = antiInjection($_POST['nss']);
        $id_sat = antiInjection($_POST['ids']);
        $id_kom = antiInjection($_POST['idk']);
        $thn = antiInjection($_POST['thn']);
        $kf1 = antiInjection($_POST['kf1']);
        $kf2 = antiInjection($_POST['kf2']);
        $kf3 = antiInjection($_POST['kf3']);
        $kf4 = antiInjection($_POST['kf4']);
        
        $rap->TambahRs($rpb,$ssn,$id_sat,$id_kom,$thn,$kf1,$kf2,$kf3,$kf4);
    
    }elseif ($_GET['kanal']=='rapbs' and $_GET['aksi']=='update') {
        $rpb = antiInjection($_POST['rap']);
        $ssn = antiInjection($_POST['nss']);
        $id_sat = antiInjection($_POST['ids']);
        $id_kom = antiInjection($_POST['idk']);
        $thn = antiInjection($_POST['thn']);
        $kf1 = antiInjection($_POST['kf1']);
        $kf2 = antiInjection($_POST['kf2']);
        $kf3 = antiInjection($_POST['kf3']);
        $kf4 = antiInjection($_POST['kf4']);
        
        $rap->UpdateRs($rpb,$ssn,$id_sat,$id_kom,$thn,$kf1,$kf2,$kf3,$kf4);
        
    }elseif ($_GET['kanal']=='rapbs' and $_GET['aksi']=='hapus') {
        $id = $_GET['id'];
        $rap->HapusRs($id);
    }
    
    //tampil data dan paging halaman
    $batas = 10;
    $posisi = $pag->cariPosisi($batas);
    $arrayrapbs = $rap->TampilRs($posisi,$batas);
    //pencarian user
    if($_POST['do']=='find'){
        $arrayrapbs = $konek->FilterData('rapbs', 'id_rapbs', $_POST['key']);
    }
    
?>
<!--End-->

<!--Tampil Data-->
    <table class="table table-bordered table-responsive table-condensed">
        <thead>
            <tr><td>NO</td>
                <td>ID RAPBS</td>
                <td>NSS</td>
                <td>ID satuan</td>
                <td>ID komponen</td>
                <td>Tahun</td>
                <td><i class="glyphicon glyphicon-cog"></i> Opsi</td></tr>
        </thead>
    <?php
    if(count($arrayrapbs)){
        $no =$posisi+1;
        foreach ($arrayrapbs as $data){
            echo "<tbody>"
                . "<tr>"
                    . "<td>$no.</td>"
                    . "<td>$data[id_rapbs]</td>"
                    . "<td>$data[nss]</td>"
                    . "<td>$data[id_satuan]</td>"
                    . "<td>$data[id_komponen]</td>"
                    . "<td>$data[tahun]</td>"
                    . "<td align='center'>"
                    . "<a href='?kanal=rapbs&aksi=edit&id=$data[id_rapbs]' data-toggle='tooltip' data-placement='bottom' title='Edit data'><i class='glyphicon glyphicon-edit'></i></a> "
                    . " -- "
                    . "<a href='?kanal=rapbs&aksi=hapus&id=$data[id_rapbs]' data-toggle='tooltip' data-placement='bottom' title='Hapus data'><i class='glyphicon glyphicon-trash'></i></a>"

                    . "</td>"
                . "</tr>"
                . "</tbody>";
            $no++;
        }
        echo"</table>";
        //paging
        $data_jml = $pag->Jml_data('rapbs');
        $hal_jml = $pag->jumlahHalaman($data_jml,$batas);
        $link_hal = $pag->navHalaman($_GET['halaman'], $hal_jml);
        echo"<div class='pager pager-sm'>"
            . "<ul>"
                . "<li>$link_hal</li>"
            . "</ul>"
            . "</div>";
    //jika tidak ditemukann data
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

