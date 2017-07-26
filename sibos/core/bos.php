<?php
/*Kelas Koneksi*/
class Database{
    private $host = "localhost";
    private $user = "root";
    private $pswd = "";
    private $dbnm = "sibos";

    public function __construct(){
        mysql_connect($this->host,  $this->user,  $this->pswd) or die("Server tidak terhubung");
        mysql_select_db($this->dbnm) or die("Database tidak terhubung");
    }

    //method tampil combo
    function comboId($field1,$field2,$table)
    {
            $query = mysql_query("SELECT ".$field1.", ".$field2." FROM ".$table."");
            while($row=mysql_fetch_array($query))
            $data[]=$row;
            return $data;
    }
    //filter data
    function FilterData($table,$field,$keyword){
        $query = mysql_query("SELECT * FROM ".$table." WHERE ".$field." like '%$keyword%'");
        $dapat = mysql_num_rows($query);
        if($dapat == 1){
            while ($row = mysql_fetch_array($query)) {
                $data[] = $row;
                return $data;
            }
        }
    }
    /*Validasi Login*/
    public function ValLog($user,$password) {
        $result = mysql_query("SELECT id_user,username,password,level FROM user WHERE username='$user'");
        $row = mysql_num_rows($result);
        $data = mysql_fetch_array($result);
        
        if($row == 1){
            if($data['level'] == superadmin){
                if(password_verify($password, $data['password'])){
                    $_SESSION['log'] = TRUE;
                    $_SESSION['nama'] = $data['username'];
                    $_SESSION['level'] = $data['level'];
                    $_SESSION['id'] = $data['id_user'];
                    return TRUE;
                }else{
                    return FALSE;
                }
            }else{
                if($data['password'] == $password){
                    $_SESSION['log'] = TRUE;
                    $_SESSION['nama'] = $data['username'];
                    $_SESSION['level'] = $data['level'];
                    $_SESSION['id'] = $data['id_user'];
                    return TRUE;
                }else{
                    return FALSE;
                }
            }    
        }    
    }
    
    public function get_sesi() {
        return $_SESSION['log'];
    }
    
    public function logout() {
        $_SESSION['log'] = FALSE;
        session_destroy();
    }
    /*End*/
}
/*End*/


/*Kelas User*/
class User{
    
    //method tampil user
    public function TampilUs($posisi,$batas) {
        $query = mysql_query("SELECT * FROM user where level = 'Admin' ORDER by username LIMIT $posisi,$batas");
        while ($row = mysql_fetch_array($query))
                $data[] = $row;
            return $data;
    }
    
    //cek user
    public function Ceking($user) {
        $result = mysql_query("SELECT * FROM user WHERE username = '$user'");
        while ($row = mysql_fetch_array($result)) {
            $data[] = $row;
            return $data;
        }
    }
    
    //method tambah user
    public function TambahUs($user,$level) {
        //membuat password acak
        function acakpassword($panjang)
	{
		$karakter ='!@#$%^&*()__++|:;<>?/.,ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwzyz1234567890';
		$string = '';
		for($i=0;$i<$panjang;$i++)
		{
			$pos = rand(0, strlen($karakter)-1);
			$string .= $karakter{$pos};
		}
		return $string;
	}
        $pswd = acakpassword(10);
        $query = mysql_query("INSERT into user(username,password,level)"
                . "values('$user','$pswd','$level')");
        
        if($query){
            echo "<div class='alert alert-success alert-dismissible' role='alert'>"
                    . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                    . "<strong>Berhasil menambah data</strong>"
                . "</div>";
        }  else {
            echo "<div class='alert alert-danger alert-dismissible' role='alert''>"
                    . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                    . "<strong>Gagal menambah data</strong>"
                . "</div>";
        }
    }
    //method mengambil data user
    public function AmbilUs($field,$id) {
        $query = mysql_query("SELECT * FROM user where id_user='$id'");
        $row = mysql_fetch_array($query);
        if($field == 'username')
            return $row['username'];
        elseif ($field == 'password')
            return $row['password']; 
        elseif ($field == 'level')
            return $row['level']; 
    }
    
    //method update user
    public function UpdateUs($id,$user,$pswd,$level) {
        $sandi = password_hash($pswd, PASSWORD_DEFAULT);
        $query = mysql_query("UPDATE user set username = '$user',"
                . "password = '$sandi',"
                . "level = '$level'"
                . "where id_user = '$id'");
        
        if($query){
            echo "<div class='alert alert-success'>"
                    . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                    . "<strong>Berhasil mengupdate data</strong>"
                . "</div>";
        }  else {
            echo "<div class='alert alert-danger'>"
                    . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                    . "<strong>Gagal mengupdate data</strong>"
                . "</div>";
        }
    }
    
    //method update profil
    public function UpdateProf($id,$user,$pswd) {
        $sandi = password_hash($pswd, PASSWORD_DEFAULT);
        $query = mysql_query("UPDATE user set username = '$user',"
                . "password = '$sandi'"
                . "where id_user = '$id'");
        
        if($query){
            echo "<div class='alert alert-success'>"
                    . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                    . "<strong>Berhasil mengupdate data</strong>"
                . "</div>";
        }  else {
            echo "<div class='alert alert-danger'>"
                    . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                    . "<strong>Gagal mengupdate data</strong>"
                . "</div>";
        }
    }
    
    public function HapusUs($id) {
        $query = mysql_query("DELETE from user where id_user = '$id'");
        
        if($query){
            echo "<div class='alert alert-success'>"
                    . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                    . "<strong>Berhasil menghapus data</strong>"
                . "</div>";
        }  else {
            echo "<div class='alert alert-danger'>"
                    . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                    . "<strong>Gagal menghapus data</strong>"
                . "</div>";
        }
    }
    
}
/*End*/

/*Kelas Belanja*/
class Belanja{
    
    //method tampil Belanja
    public function TampilBl($posisi,$batas) {
        $query = mysql_query("SELECT * FROM belanja ORDER by id_belanja limit $posisi,$batas");
        while ($row = mysql_fetch_array($query))
                $data[] = $row;
            return $data;
    }
    
    
    //method tambah Belanja
    public function TambahBl($jns) {
        $query = mysql_query("INSERT into belanja(jns_belanja)"
                . "values('$jns')");
        
        if($query){
            echo "<div class='col-xs-6 col-sm-4 col-md-4'>"
            . "<div class='alert alert-success'>"
                    . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                    . "<strong>Berhasil menambah data</strong>"
                . "</div>"
                    . "</div>";
        }  else {
            echo "<div class='col-xs-6 col-sm-4 col-md-4'>"
            . "<div class='alert alert-danger'>"
                    . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                    . "<strong>Gagal menambah data</strong>"
                . "</div>"
                    . "</div>";
        }
    }
    //method mengambil data Belanja
    public function AmbilBl($field,$id) {
        $query = mysql_query("SELECT * FROM belanja where id_belanja='$id'");
        $row = mysql_fetch_array($query);
        if($field == 'jns_belanja')
            return $row['jns_belanja']; 
    }
    
    //method update belanja
    public function UpdateBl($id,$jns) {
        $query = mysql_query("UPDATE belanja set jns_belanja = '$jns'"
                . "where id_belanja = '$id'");
        
        if($query){
            echo "<div class='alert alert-success'>"
                    . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                    . "<strong>Berhasil mengupdate data</strong>"
                . "</div>";
        }  else {
            echo "<div class='alert alert-danger'>"
                    . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                    . "<strong>Gagal mengupdate data</strong>"
                . "</div>";
        }
    }
    
    //hapus adata belanja
    public function HapusBl($id) {
        $query = mysql_query("DELETE from belanja where id_belanja = '$id'");
        
        if($query){
            echo "<div class='alert alert-success'>"
                    . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                    . "<strong>Berhasil menghapus data</strong>"
                . "</div>";
        }  else {
            echo "<div class='alert alert-danger'>"
                    . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                    . "<strong>Gagal menghapus data</strong>"
                . "</div>";
        }
    }
    
}
/*End*/

/*Kelas Satuan*/
class Satuan{
    
    //method tampil satuan
    public function TampilSt($posisi,$batas) {
        $query = mysql_query("SELECT * FROM satuan order by id_satuan limit $posisi,$batas");
        while ($row = mysql_fetch_array($query))
                $data[] = $row;
            return $data;
    }
    
    
    //method tambah satuan
    public function TambahSt($st) {
        $query = mysql_query("INSERT into satuan(satuan)"
                . "values('$st')");
        
        if($query){
            echo "<div class='alert alert-success'>"
                    . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                    . "<strong>Berhasil menambah data</strong>"
                . "</div>";
        }  else {
            echo "<div class='alert alert-danger'>"
                    . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                    . "<strong>Gagal menambah data</strong>"
                . "</div>";
        }
    }
    //method mengambil data satuan
    public function AmbilSt($field,$id) {
        $query = mysql_query("SELECT * FROM satuan where id_satuan='$id'");
        $row = mysql_fetch_array($query);
        if($field == 'satuan')
            return $row['satuan']; 
    }
    
    //method update satuan
    public function UpdateSt($id,$st) {
        $query = mysql_query("UPDATE satuan set satuan = '$st'"
                . "where id_satuan = '$id'");
        
        if($query){
            echo "<div class='alert alert-success'>"
                    . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                    . "<strong>Berhasil mengupdate data</strong>"
                . "</div>";
        }  else {
            echo "<div class='alert alert-danger'>"
                    . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                    . "<strong>Gagal mengupdate data</strong>"
                . "</div>";
        }
    }
    
    //hapus adata satuan
    public function HapusSt($id) {
        $query = mysql_query("DELETE from satuan where id_satuan = '$id'");
        
        if($query){
            echo "<div class='alert alert-success'>"
                    . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                    . "<strong>Berhasil menghapus data</strong>"
                . "</div>";
        }  else {
            echo "<div class='alert alert-danger'>"
                    . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                    . "<strong>Gagal menghapus data</strong>"
                . "</div>";
        }
    }
    
}
/*End*/

/*Kelas Pajak*/
class Pajak{
    
    //method tampil pajak
    public function TampilPj($posisi,$batas) {
        $query = mysql_query("SELECT * FROM pajak order by id_pajak limit $posisi,$batas");
        while ($row = mysql_fetch_array($query))
                $data[] = $row;
            return $data;
    }
    
    
    //method tambah pajak
    public function TambahPj($jns,$jml) {
        $query = mysql_query("INSERT into pajak(jns_pajak,jumlah)"
                . "values('$jns','$jml')");
        
        if($query){
            echo "<div class='alert alert-success'>"
                    . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                    . "<strong>Berhasil menambah data</strong>"
                . "</div>";
        }  else {
            echo "<div class='alert alert-danger'>"
                    . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                    . "<strong>Gagal menambah data</strong>"
                . "</div>";
        }
    }
    //method mengambil data pajak
    public function AmbilPj($field,$id) {
        $query = mysql_query("SELECT * FROM pajak where id_pajak='$id'");
        $row = mysql_fetch_array($query);
        if($field == 'jns_pajak')
            return $row['jns_pajak'];
        elseif($field == 'jumlah')
            return $row['jumlah'];
    }
    
    //method update pajak
    public function UpdatePj($id,$jns,$jml) {
        $query = mysql_query("UPDATE pajak set jns_pajak = '$jns',"
                . "jumlah = '$jml'"
                . "where id_pajak = '$id'");
        
        if($query){
            echo "<div class='alert alert-success'>"
                    . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                    . "<strong>Berhasil mengupdate data</strong>"
                . "</div>";
        }  else {
            echo "<div class='alert alert-danger'>"
                    . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                    . "<strong>Gagal mengupdate data</strong>"
                . "</div>";
        }
    }
    
    //hapus adata pajak
    public function HapusPj($id) {
        $query = mysql_query("DELETE from pajak where id_pajak = '$id'");
        
        if($query){
            echo "<div class='alert alert-success'>"
                    . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                    . "<strong>Berhasil menghapus data</strong>"
                . "</div>";
        }  else {
            echo "<div class='alert alert-danger'>"
                    . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                    . "<strong>Gagal menghapus data</strong>"
                . "</div>";
        }
    }
    
}
/*End*/

/*Kelas Rekening*/
class Rekening{
    
    //method tampil rekening
    public function TampilRk($posisi,$batas) {
        $query = mysql_query("SELECT * FROM rekening order by id_rekening limit $posisi,$batas");
        while ($row = mysql_fetch_array($query))
                $data[] = $row;
            return $data;
    }
    
    
    //method tambah rekening
    public function TambahRk($nm) {
        $query = mysql_query("INSERT into rekening(nm_rekening)"
                . "values('$nm')");
        
        if($query){
            echo "<div class='alert alert-success'>"
                    . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                    . "<strong>Berhasil menambah data</strong>"
                . "</div>";
        }  else {
            echo "<div class='alert alert-danger'>"
                    . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                    . "<strong>Gagal menambah data</strong>"
                . "</div>";
        }
    }
    //method mengambil data rekening
    public function AmbilRk($field,$id) {
        $query = mysql_query("SELECT * FROM rekening where id_rekening='$id'");
        $row = mysql_fetch_array($query);
        if($field == 'nm_rekening')
            return $row['nm_rekening'];
    }
    
    //method update rekening
    public function UpdateRk($id,$nm) {
        $query = mysql_query("UPDATE rekening set nm_rekening = '$nm'"
                . "where id_rekening = '$id'");
        
        if($query){
            echo "<div class='alert alert-success'>"
                    . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                    . "<strong>Berhasil mengupdate data</strong>"
                . "</div>";
        }  else {
            echo "<div class='alert alert-danger'>"
                    . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                    . "<strong>Gagal mengupdate data</strong>"
                . "</div>";
        }
    }
    
    //hapus adata rekening
    public function HapusRk($id) {
        $query = mysql_query("DELETE from rekening where id_rekening = '$id'");
        
        if($query){
            echo "<div class='alert alert-success'>"
                    . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                    . "<strong>Berhasil menghapus data</strong>"
                . "</div>";
        }  else {
            echo "<div class='alert alert-danger'>"
                    . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                    . "<strong>Gagal menghapus data</strong>"
                . "</div>";
        }
    }
    
}
/*End*/

/*Kelas Dana*/
class Dana{
    
    //method tampil dana
    public function TampilDn($posisi,$batas) {
        $query = mysql_query("SELECT * FROM dana order by id_dana limit $posisi,$batas");
        while ($row = mysql_fetch_array($query))
                $data[] = $row;
            return $data;
    }
    
    
    //method tambah dana
    public function TambahDn($tgl,$idp,$urn,$jml) {
        $query = mysql_query("INSERT into dana(tgl,id_pajak,uraian,jumlah)"
                . "values('$tgl','$idp','$urn','$jml')");
        
        if($query){
            echo "<div class='alert alert-success'>"
                    . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                    . "<strong>Berhasil menambah data</strong>"
                . "</div>";
        }  else {
            echo "<div class='alert alert-danger'>"
                    . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                    . "<strong>Gagal menambah data</strong>"
                . "</div>";
        }
    }
    //method mengambil data dana
    public function AmbilDn($field,$id) {
        $query = mysql_query("SELECT * FROM dana where id_dana ='$id'");
        $row = mysql_fetch_array($query);
        if($field == 'tgl')
            return $row['tgl'];
        else if($field == 'id_pajak')
            return $row['id_pajak'];
        else if($field == 'uraian')
            return $row['uraian'];
        else if($field == 'jumlah')
            return $row['jumlah'];
    }
    
    //method update dana
    public function UpdateDn($id,$tgl,$idp,$urn,$jml) {
        $query = mysql_query("UPDATE dana set tgl = '$tgl',"
                . "id_pajak = '$idp',"
                . "uraian = '$urn',"
                . "jumlah = '$jml'"
                . "where id_dana = '$id'");
        
        if($query){
            echo "<div class='alert alert-success'>"
                    . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                    . "<strong>Berhasil mengupdate data</strong>"
                . "</div>";
        }  else {
            echo "<div class='alert alert-danger'>"
                    . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                    . "<strong>Gagal mengupdate data</strong>"
                . "</div>";
        }
    }
    
    //hapus adata dana
    public function HapusDn($id) {
        $query = mysql_query("DELETE from dana where id_dana = '$id'");
        
        if($query){
            echo "<div class='alert alert-success'>"
                    . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                    . "<strong>Berhasil menghapus data</strong>"
                . "</div>";
        }  else {
            echo "<div class='alert alert-danger'>"
                    . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                    . "<strong>Gagal menghapus data</strong>"
                . "</div>";
        }
    }
    
}
/*End*/

/*Kelas Komponen*/
class Komponen{
    
    //method tampil komponen
    public function TampilKm($posisi,$batas) {
        $query = mysql_query("SELECT * FROM komponen order by id_komponen limit $posisi,$batas");
        while ($row = mysql_fetch_array($query))
                $data[] = $row;
            return $data;
    }
    
    
    //method tambah komponen
    public function TambahKm($kom,$ids,$idr,$idb,$tgl) {
        $query = mysql_query("INSERT into komponen(komponen,id_satuan,id_rekening,id_belanja,tgl)"
                . "values('$kom','$ids','$idr','$idb','$tgl')");
        
        if($query){
            echo "<div class='alert alert-success'>"
                    . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                    . "<strong>Berhasil menambah data</strong>"
                . "</div>";
        }  else {
            echo "<div class='alert alert-danger'>"
                    . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                    . "<strong>Gagal menambah data</strong>"
                . "</div>";
        }
    }
    //method mengambil data komponen
    public function AmbilKm($field,$id) {
        $query = mysql_query("SELECT * FROM komponen where id_komponen ='$id'");
        $row = mysql_fetch_array($query);
        if($field == 'komponen')
            return $row['komponen'];
        else if($field == 'id_satuan')
            return $row['id_satuan'];
        else if($field == 'id_rekening')
            return $row['id_rekening'];
        else if($field == 'id_belanja')
            return $row['id_belanja'];
        else if($field == 'tgl')
            return $row['tgl'];
    }
    
    //method update komponen
    public function UpdateKm($id,$kom,$ids,$idr,$idb,$tgl) {
        $query = mysql_query("UPDATE komponen set komponen = '$kom',"
                . "id_satuan = '$ids',"
                . "id_rekening = '$idr',"
                . "id_belanja = '$idb',"
                . "tgl = '$tgl'"
                . "where id_komponen = '$id'");
        
        if($query){
            echo "<div class='alert alert-success'>"
                    . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                    . "<strong>Berhasil mengupdate data</strong>"
                . "</div>";
        }  else {
            echo "<div class='alert alert-danger'>"
                    . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                    . "<strong>Gagal mengupdate data</strong>"
                . "</div>";
        }
    }
    
    //hapus data komponen
    public function HapusKm($id) {
        $query = mysql_query("DELETE from komponen where id_komponen = '$id'");
        
        if($query){
            echo "<div class='alert alert-success'>"
                    . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                    . "<strong>Berhasil menghapus data</strong>"
                . "</div>";
        }  else {
            echo "<div class='alert alert-danger'>"
                    . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                    . "<strong>Gagal menghapus data</strong>"
                . "</div>";
        }
    }
    
}
/*End*/

/*Kelas Realisasi*/
class Realisasi{
    
    //method tampil realisasi
    public function TampilRl($posisi,$batas) {
        $query = mysql_query("SELECT * FROM realisasi order by id_realisasi limit $posisi,$batas");
        while ($row = mysql_fetch_array($query))
                $data[] = $row;
            return $data;
    }
    
    //method tambah realisasi
    public function TambahRl($id_kom,$tgl,$jml) {
        $query = mysql_query("INSERT into realisasi(id_komponen,tgl_realisasi,jml_realisasi)"
                . "values('$id_kom','$tgl','$jml')");
        
        if($query){
            echo "<div class='alert alert-success'>"
                    . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                    . "<strong>Berhasil menambah data</strong>"
                . "</div>";
        }  else {
            echo "<div class='alert alert-danger'>"
                    . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                    . "<strong>Gagal menambah data</strong>"
                . "</div>";
        }
    }
    //method mengambil data realisasi
    public function AmbilRl($field,$id) {
        $query = mysql_query("SELECT * FROM realisasi where id_realisasi ='$id'");
        $row = mysql_fetch_array($query);
        if($field == 'id_komponen')
            return $row['id_komponen'];
        else if($field == 'tgl_realisasi')
            return $row['tgl_realisasi'];
        else if($field == 'jml_realisasi')
            return $row['jml_realisasi'];
    }
    
    //method update realisasi
    public function UpdateRl($id,$id_kom,$tgl,$jml) {
        $query = mysql_query("UPDATE realisasi set id_komponen = '$id_kom',"
                . "tgl_realisasi = '$tgl',"
                . "jml_realisasi = '$jml'"
                . "where id_realisasi = '$id'");
        
        if($query){
            echo "<div class='alert alert-success'>"
                    . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                    . "<strong>Berhasil mengupdate data</strong>"
                . "</div>";
        }  else {
            echo "<div class='alert alert-danger'>"
                    . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                    . "<strong>Gagal mengupdate data</strong>"
                . "</div>";
        }
    }
    
    //hapus data realisasi
    public function HapusRl($id) {
        $query = mysql_query("DELETE from realisasi where id_realisasi = '$id'");
        
        if($query){
            echo "<div class='alert alert-success'>"
                    . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                    . "<strong>Berhasil menghapus data</strong>"
                . "</div>";
        }  else {
            echo "<div class='alert alert-danger'>"
                    . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                    . "<strong>Gagal menghapus data</strong>"
                . "</div>";
        }
    }
    
}
/*End*/

/*Kelas Sekolah*/
class Sekolah{
    
    //method tampil sekolah
    public function TampilSk($posisi,$batas) {
        $query = mysql_query("SELECT * FROM sekolah order by nss limit $posisi,$batas");
        while ($row = mysql_fetch_array($query))
                $data[] = $row;
            return $data;
    }
    
    //method tambah sekolah
    public function TambahSk($nss,$ns,$almt,$nk,$ket) {
        $query = mysql_query("INSERT into sekolah(nss,nama_sklh,alamat,nama_kpl,ket)"
                . "values('$nss','$ns','$nk','$almt','$ket')");
        
        if($query){
            echo "<div class='alert alert-success'>"
                    . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                    . "<strong>Berhasil menambah data</strong>"
                . "</div>";
        }  else {
            echo "<div class='alert alert-danger'>"
                    . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                    . "<strong>Gagal menambah data</strong>"
                . "</div>";
        }
    }
    //method mengambil data sekolah
    public function AmbilSk($field,$id) {
        $query = mysql_query("SELECT * FROM sekolah where nss ='$id'");
        $row = mysql_fetch_array($query);
        if($field == 'nss')
            return $row['nss'];
        else if($field == 'nama_sklh')
            return $row['nama_sklh'];
        else if($field == 'alamat')
            return $row['alamat'];
        else if($field == 'nama_kpl')
            return $row['nama_kpl'];
        else if($field == 'ket')
            return $row['ket'];
    }
    
    //method update sekolah
    public function UpdateSk($nss,$ns,$almt,$nk,$ket) {
        $query = mysql_query("UPDATE sekolah set nama_sklh = '$ns',"
                . "alamat = '$almt',"
                . "nama_kpl = '$nk',"
                . "ket = '$ket'"
                . "where nss = '$nss'");
        
        if($query){
            echo "<div class='alert alert-success'>"
                    . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                    . "<strong>Berhasil mengupdate data</strong>"
                . "</div>";
        }  else {
            echo "<div class='alert alert-danger'>"
                    . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                    . "<strong>Gagal mengupdate data</strong>"
                . "</div>";
        }
    }
    
    //hapus data sekolah
    public function HapusSk($id) {
        $query = mysql_query("DELETE from sekolah where nss = '$id'");
        
        if($query){
            echo "<div class='alert alert-success'>"
                    . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                    . "<strong>Berhasil menghapus data</strong>"
                . "</div>";
        }  else {
            echo "<div class='alert alert-danger'>"
                    . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                    . "<strong>Gagal menghapus data</strong>"
                . "</div>";
        }
    }
    
}
/*End*/

/*Kelas Rapbs*/
class Rapbs{
    
    //method tampil rapbs
    public function TampilRs($posisi,$batas) {
        $query = mysql_query("SELECT * FROM rapbs order by id_rapbs limit $posisi,$batas");
        while ($row = mysql_fetch_array($query))
                $data[] = $row;
            return $data;
    }
    
    
    //method tambah rapbs
    public function TambahRs($id_rs,$nss,$id_s,$id_k,$thn,$kf1,$kf2,$kf3,$kf4) {
        $query = mysql_query("INSERT into rapbs(id_rapbs,nss,id_satuan,id_komponen,tahun,koefisien1,koefisien2,koefisien3,koefisien4)"
                . "values('$id_rs','$nss','$id_s','$id_k','$thn','$kf1','$kf2','$kf3','$kf4')");
        
        if($query){
            echo "<div class='alert alert-success'>"
                    . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                    . "<strong>Berhasil menambah data</strong>"
                . "</div>";
        }  else {
            echo "<div class='alert alert-danger'>"
                    . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                    . "<strong>Gagal menambah data</strong>"
                . "</div>";
        }
    }
    //method mengambil data rapbs
    public function AmbilRs($field,$id) {
        $query = mysql_query("SELECT * FROM rapbs where id_rapbs ='$id'");
        $row = mysql_fetch_array($query);
        if($field == 'id_rapbs')
            return $row['id_rapbs'];
        else if($field == 'nss')
            return $row['nss'];
        else if($field == 'id_satuan')
            return $row['id_satuan'];
        else if($field == 'id_komponen')
            return $row['id_komponen'];
        else if($field == 'tahun')
            return $row['tahun'];
        else if($field == 'koefisien1')
            return $row['koefisien1'];
        else if($field == 'koefisien2')
            return $row['koefisien2'];
        else if($field == 'koefisien3')
            return $row['koefisien3'];
        else if($field == 'koefisien4')
            return $row['koefisien4'];
    }
    
    //method update rapbs
    public function UpdateRs($id_rs,$nss,$id_s,$id_k,$thn,$kf1,$kf2,$kf3,$kf4) {
        $query = mysql_query("UPDATE rapbs set nss = '$nss',"
                . "id_satuan = '$id_s',"
                . "id_komponen = '$id_k',"
                . "tahun = '$thn',"
                . "koefisien1 = '$kf1',"
                . "koefisien2 = '$kf2',"
                . "koefisien3 = '$kf3',"
                . "koefisien4 = '$kf4'"
                . "where id_rapbs = '$id_rs'");
        
        if($query){
            echo "<div class='alert alert-success'>"
                    . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                    . "<strong>Berhasil mengupdate data</strong>"
                . "</div>";
        }  else {
            echo "<div class='alert alert-danger'>"
                    . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                    . "<strong>Gagal mengupdate data</strong>"
                . "</div>";
        }
    }
    
    //hapus data rapbs
    public function HapusRs($id) {
        $query = mysql_query("DELETE from rapbs where id_rapbs = '$id'");
        
        if($query){
            echo "<div class='alert alert-success'>"
                    . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                    . "<strong>Berhasil menghapus data</strong>"
                . "</div>";
        }  else {
            echo "<div class='alert alert-danger'>"
                    . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                    . "<strong>Gagal menghapus data</strong>"
                . "</div>";
        }
    }
    
}
/*End*/