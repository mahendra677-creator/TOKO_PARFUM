<?php
include_once 'm_koneksi.php';
class m_pelanggan{

function tampil_data(){
  $koneksi = new koneksi();
  
  $sql = "SELECT * FROM user";
  
  $query =mysqli_query($koneksi->koneksi,$sql);
  
  if ($query->num_rows > 0){
    while ($data = mysqli_fetch_object($query)){
      $result[] = $data;
    }
    return $result;
  }else {
    echo "tidak ada data";
  }
}
function tampil_data_by_id($id){
  $koneksi = new koneksi ();
  $sql = "SELECT FROM user WHERE id_user = $id";
  return mysqli_fetch_object(mysqli_query($koneksi->koneksi,$sql));
  
}
function tambah_data ($id, $nama, $email, $password, $alamat, $jk, $role){

  $koneksi = new koneksi();

  $sql = "INSERT INTO user VALUE ('$id','$nama','$email','$password','$alamat','$jk','$role')";

  $query = mysqli_query($koneksi->koneksi,$sql);
  
  return $query;
  
}




function registrasi_data ($id, $nama, $email, $password, $alamat, $jk, $role){

  $koneksi = new koneksi();

  $sql = "INSERT INTO user VALUE ('$id','$nama','$email','$password','$alamat','$jk','$role')";

  $query = mysqli_query($koneksi->koneksi,$sql);
  
  return $query;
  
}





//======UPDATE========
function get_by_id($id) {
  $koneksi = new koneksi();
  $query = "SELECT * FROM user WHERE id_user = '$id'";
  return mysqli_query($koneksi->koneksi, $query);
}




  // --- Hapus data berdasarkan ID (✅ versi aman) ---
  function hapus_data($id){
    $koneksi = new koneksi();
    $sql = "DELETE FROM user WHERE id_user = '$id'";
    return mysqli_query($koneksi->koneksi, $sql);
  }
}