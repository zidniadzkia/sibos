<?php
$konek = new Database();
$us = new User();
$pag = new Paging();

//cek apakah sudah login
if(!$konek->get_sesi()){
    header('location:login.php');
}

if($_GET['kanal']=='user'){
?>
<!--************************-->
<div class="row">
	<div class="panel-heading"><span class="glyphicon glyphicon-book"></span>&nbsp;&nbsp;DATA User</div>
        <p>
			<a href="?kanal=user&aksi=tambah" class="btn btn-info"><i class="glyphicon glyphicon-plus"></i> Tambah Data</a>
            <a href="kanal/lapor.php?kanal=user" class="btn btn-info" target="_blank"><i class="glyphicon glyphicon-print"></i> Cetak Data</a>
		</p>
<!--************************-->

<!--Form Tambah Data-->
<?php
    if($_GET['kanal']=='user' and $_GET['aksi']=='tambah'){
?>
        <form method="POST" action="?kanal=user&aksi=insert">
            <table class="table table-bordered table-responsive">
                <thead>
                    <tr><th colspan="2"><i class="glyphicon glyphicon-plus-sign"></i> Form insert data user </th></tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Username :</td>
                        <td><input type="text" name="user" class="form-control" placeholder=" Username"></td>
                    </tr>
                    <tr>
                        <td>Level</td>
                        <td>
                            <select name="level" class="form-control">
                                <option value="admin">Admin</option>
                                <option value="superadmin">Super Admin</option>
                            </select>
                        </td>
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
    }else if($_GET['kanal']=='user' and $_GET['aksi']=='edit'){
        $id = base64_decode($_GET['id']);
?>
        <form method="POST" action="?kanal=user&aksi=update">
            <input type="hidden" name="id" value="<?php echo $id;?>">
            <table class="table table-bordered table-responsive">
                <thead>
                    <tr><th colspan="2"><i class="glyphicon glyphicon-plus-sign"></i> Form update data user </th></tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Username :</td>
                        <td><input type="text" name="user" class="form-control"  value="<?php echo $us->AmbilUs('username', $id);?>"></td>
                    </tr>
                    <tr>
                        <td>Password :</td>
                        <td><input type="password" name="pswd" class="form-control"  value="<?php echo $us->AmbilUs('password', $id);?>"></td>
                    </tr>
                    <tr>
                        <td>Level</td>
                        <td>
                            <select name="level" class="form-control">
                                <option value="" selected="">Level :</option>
                                <?php
                                $lvl = $us->AmbilUs('level', $id);
                                if($lvl == "superadmin"){
                                    echo "<option value='superadmin' selected>Super Admin</option>";
                                    echo "<option value='admin'>Admin</option>";
                                }else{
                                    echo "<option value='superadmin'>Super Admin</option>";
                                    echo "<option value='admin' selected>Admin</option>";
                                }
                                ?>        
                            </select>
                        </td>
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
<?php 
    }elseif ($_GET['kanal']=='user' and $_GET['aksi']=='insert') {
        $user = antiInjection($_POST['user']);
        $level = antiInjection($_POST['level']);
        $coba = $us->Ceking($user);
        if(!$coba){
            $us->TambahUs($user,$level);
        }  else {
            echo "<div class='alert alert-danger alert-dismissible' role='alert''>"
                    . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                    . "<strong>Username sudah digunakan</strong>"
                . "</div>";
        }    
    
    }elseif ($_GET['kanal']=='user' and $_GET['aksi']=='update') {
        $id = $_POST['id'];
        $user = antiInjection($_POST['user']);
        $pswd = antiInjection($_POST['pswd']);
        $level = antiInjection($_POST['level']);
        
        $us->UpdateUs($id,$user,$pswd,$level);
        
    }elseif ($_GET['kanal']=='user' and $_GET['aksi']=='hapus') {
        $id = base64_decode($_GET['id']);
        $us->HapusUs($id);
    }
    
    //tampil data dan paging halaman
    $batas = 10;
    $posisi = $pag->cariPosisi($batas);
    $arrayuser = $us->TampilUs($posisi,$batas);
    //pencarian user
    if($_POST['do']=='find'){
        $arrayuser = $konek->FilterData('user', 'username', $_POST['key']);
    }
    
?>  
    <table class="table table-bordered table-responsive table-condensed">
        <thead>
            <tr>
                <th>NO</th>
                <th>Username</th>
                <th>Level</th>
                <th align="center"><i class="glyphicon glyphicon-cog"></i> Opsi</th>
            </tr>
        </thead>
    <?php
    //hitung user yang ditemukan
    if(count($arrayuser)){
        $no =$posisi+1;
        foreach ($arrayuser as $data){
            $id = base64_encode($data['id_user']);
            echo "<tbody>"
                . "<tr>"
                    . "<td>$no.</td>"
                    . "<td>$data[username]</td>"
                    . "<td>$data[level]</td>"
                    . "<td align='center'>"
                    . "<a href='?kanal=user&aksi=edit&id=$id' data-toggle='tooltip' data-placement='bottom' title='Edit data'><i class='glyphicon glyphicon-edit'></i></a> "
                    . " -- "
                    . "<a href='?kanal=user&aksi=hapus&id=$id' data-toggle='tooltip' data-placement='bottom' title='Hapus data'><i class='glyphicon glyphicon-trash'></i></a>"
                    . "</td>"
                . "</tr>"
                . "</tbody>";
            $no++;
        }
    }else{
        echo "<div class='alert alert-danger'>"
                    . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                    . "<strong>Data tidak ditemukan</strong>"
                . "</div>";
    }
        echo"</table>";
        //paging
        $data_jml = $pag->Jml_data('user');
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



    