<?php
$konek = new Database();
$km = new Komponen();
$pag = new Paging();

//cek apakah sudah login
if(!$konek->get_sesi()){
    header('location:login.php');
}

if($_GET['kanal']=='komponen'){
?>
<!--************************-->  
<div class="row">
	<div class="panel-heading"><span class="glyphicon glyphicon-book"></span>&nbsp;&nbsp;DATA Komponen</div>
        <p><a href="?kanal=komponen&aksi=tambah" class="btn btn-info"><i class="glyphicon glyphicon-plus"></i> Tambah Data</a></p>
<!--************************-->

<!--Form Tambah Data-->
<?php
    if($_GET['kanal']=='komponen' and $_GET['aksi']=='tambah'){
?>
        <form method="POST" action="?kanal=komponen&aksi=insert">
            <table class="table table-bordered table-responsive">
                <thead>
                    <tr><th colspan="2"><i class="glyphicon glyphicon-plus-sign"></i> Form insert data komponen </th></tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Komponen :</td>
                        <td><input type="text" name="kom" class="form-control" placeholder=" Komponen"></td>
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
                        <td>ID Rekening :</td>
                        <td><select name="idr" class="form-control">
                                <option value="0" selected="selected">Pilih ID Rekening</option>
                        <?php
			$arrayRek = $konek->comboId('id_rekening','nm_rekening','rekening');
			foreach($arrayRek as $data)
			{
			?>
				<option value="<?php  echo $data['id_rekening']; ?>"><?php  echo $data['nm_rekening']; ?></option>
			<?php } ?>
                            </select>   
			</td>
                    </tr>  
                    <tr>
                        <td>ID Belanja :</td>
                        <td><select name="idb" class="form-control">
                                <option value="0" selected="selected">Pilih ID Belanja</option>
                        <?php
			//Tampilkan combo id pajak
			$arrayBel = $konek->comboId('id_belanja','jns_belanja','belanja');
			foreach($arrayBel as $data)
			{
			?>
				<option value="<?php  echo $data['id_belanja']; ?>"><?php  echo $data['jns_belanja']; ?></option>
			<?php } ?>
                            </select>   
			</td>
                    </tr>  
                    <tr>
                        <td>Tanggal :</td>
                        <td><input type="date" name="tgl" class="form-control" placeholder=" Pilih Tanggal"></td>
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
    }else if($_GET['kanal']=='komponen' and $_GET['aksi']=='edit'){
        $id = $_GET['id'];
?>
        <form method="POST" action="?kanal=komponen&aksi=update">
            <input type="hidden" name="id" value="<?php echo $id;?>">
            <table class="table table-bordered table-responsive">
                <thead>
                    <tr><th colspan="2"><i class="glyphicon glyphicon-plus-sign"></i> Form update data komponen </th></tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Komponen :</td>
                        <td><input type="text" name="kom" class="form-control" value="<?php echo $km->AmbilKm('komponen', $id);?>"></td>
                    </tr>  
                    <tr>
                        <td>ID Satuan :</td>
                        <td><select name="ids" class="form-control">
                                <option value="0" selected="selected">Pilih ID Satuan</option>
                        <?php
			$ids = $km->AmbilKm('id_satuan', $id);
			$arrayids=$konek->comboId('id_satuan','satuan','satuan');
                        foreach($arrayids as $Ids2)
			{   
                            if($ids['id_satuan'] == $Ids2['id_satuan']){
                                echo"<option value='$Ids2[id_satuan]' selected>$Ids2[satuan]</option>";
                            }else{
                                echo"<option value='$Ids2[id_satuan]'>$Ids2[satuan]</option>";
                            }    
                            
                        } ?>
                            </select>   
			</td>
                    </tr>  
                    <tr>
                        <td>ID Rekening :</td>
                        <td><select name="idr" class="form-control">
                                <option value="0" selected="selected">Pilih ID Rekening</option>
                        <?php
			$idr = $km->AmbilKm('id_rekening', $id);
			$arrayidr=$konek->comboId('id_rekening','nm_rekening','rekening');
                        foreach($arrayidr as $Idr2)
			{   
                            if($idr == $Idr2['id_rekening']){
                                echo"<option value='$Idr2[id_rekening]' selected>$Idr2[nm_rekening]</option>";
                            }else{
                                echo"<option value='$Idr2[id_rekening]'>$Idr2[nm_rekening]</option>";
                            }    
                            
                        } ?>
                            </select>   
			</td>
                    </tr>  
                    <tr>
                        <td>ID Belanja :</td>
                        <td><select name="idb" class="form-control">
                                <option value="0" selected="selected">Pilih ID Belanja</option>
                        <?php
			$idb = $km->AmbilKm('id_belanja', $id);
			$arrayidb=$konek->comboId('id_belanja','jns_belanja','belanja');
                        foreach($arrayidb as $Idb2)
			{   
                            if($idb == $Idb2['id_belanja']){
                                echo"<option value='$Idb2[id_belanja]' selected>$Idb2[jns_belanja]</option>";
                            }else{
                                echo"<option value='$Idb2[id_belanja]'>$Idb2[jns_belanja]</option>";
                            }    
                            
                        } ?>
                            </select>   
			</td>
                    </tr>  
                    <tr>
                        <td>Tanggal :</td>
                        <td><input type="date" name="tgl" class="form-control" value="<?php echo $km->AmbilKm('tgl', $id);?>"></td>
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
    }elseif ($_GET['kanal']=='komponen' and $_GET['aksi']=='insert') {
        $kom = $_POST['kom'];
        $id_sat = $_POST['ids'];
        $id_rek = $_POST['idr'];
        $id_bel = $_POST['idb'];
        $tgl = $_POST['tgl'];
        
        $km->TambahKm($kom,$id_sat,$id_rek,$id_bel,$tgl);
    
    }elseif ($_GET['kanal']=='komponen' and $_GET['aksi']=='update') {
        $id = $_POST['id'];
        $kom = $_POST['kom'];
        $id_sat = $_POST['ids'];
        $id_rek = $_POST['idr'];
        $id_bel = $_POST['idb'];
        $tgl = $_POST['tgl'];
        
        $km->UpdateKm($id,$kom,$id_sat,$id_rek,$id_bel,$tgl);
        
    }elseif ($_GET['kanal']=='komponen' and $_GET['aksi']=='hapus') {
        $id = $_GET['id'];
        $km->HapusKm($id);
    }
    
    //tampil data dan paging halaman
    $batas = 10;
    $posisi = $pag->cariPosisi($batas);
    $arraykomponen = $km->TampilKm($posisi,$batas);
    //pencarian user
    if($_POST['do']=='find'){
        $arraykomponen = $konek->FilterData('komponen', 'komponen', $_POST['key']);
    }
    
?>
<!--End-->

<!--Tampil Data-->
    <table class="table table-bordered table-responsive table-condensed">
        <thead>
            <tr><td>NO</td>
                <td>Komponen</td>
                <td>ID satuan</td>
                <td>ID rekening</td>
                <td>ID belanja</td>
                <td>Tanggal</td>
                <td><i class="glyphicon glyphicon-cog"></i> Opsi</td></tr>
        </thead>
    <?php
    if(count($arraykomponen)){
        $no =$posisi+1;
        foreach ($arraykomponen as $data){
            echo "<tbody>"
                . "<tr>"
                    . "<td>$no.</td>"
                    . "<td>$data[komponen]</td>"
                    . "<td>$data[id_satuan]</td>"
                    . "<td>$data[id_rekening]</td>"
                    . "<td>$data[id_belanja]</td>"
                    . "<td>$data[tgl]</td>"
                    . "<td align='center'>"
                    . "<a href='?kanal=komponen&aksi=edit&id=$data[id_komponen]' data-toggle='tooltip' data-placement='bottom' title='Edit data'><i class='glyphicon glyphicon-edit'></i></a> "
                    . " -- "
                    . "<a href='?kanal=komponen&aksi=hapus&id=$data[id_komponen]' data-toggle='tooltip' data-placement='bottom' title='Hapus data'><i class='glyphicon glyphicon-trash'></i></a>"

                    . "</td>"
                . "</tr>"
                . "</tbody>";
            $no++;
        }
    }else{
        echo "<div class='alert alert-danger'>"
                    . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                    . "<strong>Tidak ditemukan data dengan kata kunci ".$_POST['key']."</strong>"
                . "</div>";
    }
        echo"</table>";
        //paging
        $data_jml = $pag->Jml_data('komponen');
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

