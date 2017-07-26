<?php
$konek = new Database();
$dn = new Dana();
$pag = new Paging();

//cek apakah sudah login
if(!$konek->get_sesi()){
    header('location:login.php');
}

if($_GET['kanal']=='dana'){
?>
<!--************************-->  
<div class="row">
	<div class="panel-heading"><span class="glyphicon glyphicon-book"></span>&nbsp;&nbsp;DATA Dana</div>
        <p><a href="?kanal=dana&aksi=tambah" class="btn btn-info"><i class="glyphicon glyphicon-plus"></i> Tambah Data</a></p>

<!--************************-->

<!--Form Tambah Data-->
<?php
    if($_GET['kanal']=='dana' and $_GET['aksi']=='tambah'){
?>
        <form method="POST" action="?kanal=dana&aksi=insert">
            <table class="table table-bordered table-responsive">
                <thead>
                    <tr><th colspan="2"><i class="glyphicon glyphicon-plus-sign"></i> Form insert data dana </th></tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Tanggal :</td>
                        <td><input type="date" name="tgl" class="form-control"></td>
                    </tr>  
                    <tr>
                        <td>ID Pajak :</td>
                        <td><select name="idp" class="form-control">
                                <option value="0" selected="selected">ID Pajak</option>
                        <?php
			//Tampilkan combo id pajak
			$arrayDana = $konek->comboId('id_pajak','jumlah','pajak');
			foreach($arrayDana as $data)
			{
			?>
				<option value="<?php  echo $data['id_pajak']; ?>"><?php  echo $data['jumlah']; ?></option>
			<?php } ?>
                            </select>   
			</td>
                    </tr>  
                    <tr>
                        <td>Uraian :</td>
                        <td><textarea name="urn" class="form-control" placeholder="Uraian"></textarea></td>
                    </tr>  
                    <tr>
                        <td>Jumlah Dana :</td>
                        <td><input type="number" name="jml" class="form-control" placeholder=" Jumlah dana"></td>
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
    }else if($_GET['kanal']=='dana' and $_GET['aksi']=='edit'){
        $id = $_GET['id'];
?>
        <form method="POST" action="?kanal=dana&aksi=update">
            <input type="hidden" name="id" value="<?php echo $id;?>">
            <table class="table table-bordered table-responsive">
                <thead>
                    <tr><th colspan="2"><i class="glyphicon glyphicon-plus-sign"></i> Form update data dana </th></tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Tanggal :</td>
                        <td><input type="date" name="tgl" class="form-control"  value="<?php echo $dn->AmbilDn('tgl', $id);?>"></td>
                    </tr>
                    <tr>
                        <td>ID Pajak :</td>
                        <td><select name="idp" class="form-control">
                                <option value="0" selected="selected">ID Pajak</option>
                        <?php
			//Tampilkan combo id pajak
			$data1 = $dn->AmbilDn('id_pajak', $id);
			$arrayDana=$konek->comboId('id_pajak','jumlah','pajak');
                        foreach($arrayDana as $data2)
			{   
                            if($data1 == $data2['id_pajak']){
                                echo"<option value='$data2[id_pajak]' selected>$data2[jumlah]</option>";
                            }else{
                                echo"<option value='$data2[id_pajak]'>$data2[jumlah]</option>";
                            }    
                            
                        } ?>
                            </select>   
			</td>
                    </tr>  
                    <tr>
                        <td>Uraian :</td>
                        <td><textarea name="urn" class="form-control" ><?php echo $dn->AmbilDn('uraian', $id);?></textarea></td>
                    </tr>  
                    <tr>
                        <td>Jumlah :</td>
                        <td><input type="number" name="jml" class="form-control"  value="<?php echo $dn->AmbilDn('jumlah', $id);?>"></td>
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
    }elseif ($_GET['kanal']=='dana' and $_GET['aksi']=='insert') {
        $tgl = $_POST['tgl'];
        $idp = $_POST['idp'];
        $urn = $_POST['urn'];
        $jumlah = $_POST['jml'];
        
        $dn->TambahDn($tgl,$idp,$urn,$jumlah);
    
    }elseif ($_GET['kanal']=='dana' and $_GET['aksi']=='update') {
        $id = $_POST['id'];
        $tgl = $_POST['tgl'];
        $idp = $_POST['idp'];
        $urn = $_POST['urn'];
        $jumlah = $_POST['jml'];
        
        $dn->UpdateDn($id,$tgl,$idp,$urn,$jumlah);
        
    }elseif ($_GET['kanal']=='dana' and $_GET['aksi']=='hapus') {
        $id = $_GET['id'];
        $dn->HapusDn($id);
    }
    
    //tampil data dan paging halaman
    $batas = 10;
    $posisi = $pag->cariPosisi($batas);
    $arraydana = $dn->TampilDn($posisi,$batas);
?>
<!--End-->

<!--Tampil Data-->
    <table class="table table-bordered table-responsive table-condensed">
        <thead>
            <tr><td>NO</td>
                <td>Tanggal</td>
                <td>ID Pajak</td>
                <td>Jumlah</td>
                <td><i class="glyphicon glyphicon-cog"></i> Opsi</td></tr>
        </thead>
    <?php
    $no =$posisi+1;
    foreach ($arraydana as $data){
        echo "<tbody>"
            . "<tr>"
                . "<td>$no.</td>"
                . "<td>$data[tgl]</td>"
                . "<td>$data[id_pajak]</td>"
                . "<td>$data[jumlah]</td>"
                . "<td align='center'>"
                . "<a href='?kanal=dana&aksi=edit&id=$data[id_dana]' data-toggle='tooltip' data-placement='bottom' title='Edit data'><i class='glyphicon glyphicon-edit'></i></a> "
                . " -- "
                . "<a href='?kanal=dana&aksi=hapus&id=$data[id_dana]' data-toggle='tooltip' data-placement='bottom' title='Hapus data'><i class='glyphicon glyphicon-trash'></i></a>"
                . "</td>"
            . "</tr>"
            . "</tbody>";
        $no++;
    }
        echo"</table>";
        //paging
        $data_jml = $pag->Jml_data('dana');
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

