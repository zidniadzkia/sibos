<?php
$konek = new Database();
$us = new User();

//cek apakah sudah login
if(!$konek->get_sesi()){
    header('location:login.php');
}

if($_GET['kanal']=='profil' and $_GET['aksi']=='edit'){
        $id = $_GET['id'];
?>
        <form method="POST" action="?kanal=profil&aksi=update">
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
                        <td colspan="2">
                            <input type="submit" name="update" class="btn btn-primary" value="Update"> |     
                            <input type="reset" name="batal" class="btn btn-danger" value="Batal">     
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>
<?php
}elseif ($_GET['kanal']=='profil' and $_GET['aksi']=='update') {
        $id = $_POST['id'];
        $user = antiInjection($_POST['user']);
        $pswd = antiInjection($_POST['pswd']);
        
        $us->UpdateProf($id,$user,$pswd);    
}
?>
<div class="row">
    <div class="col-xs-6 col-lg-4">
        <?php
        echo "<div class='list-group'>"
        . "<li class='list-group-item active'><h4>Profilku</h4></li>"
        . "<li class='list-group-item'>Username : $_SESSION[nama]</li>"
        . "<li class='list-group-item'>Level : $_SESSION[level]</li>"
        . "<li class='list-group-item'><a class='btn btn-primary' href='?kanal=profil&aksi=edit&id=$_SESSION[id]'>Edit</a></li>"
        . "</div>";
        ?>
    </div>
</div>
