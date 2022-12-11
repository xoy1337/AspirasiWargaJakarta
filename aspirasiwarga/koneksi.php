<?php
ob_start();
session_start();
$conn = mysqli_connect("localhost","root","","aspirasiwarga");

function query($query){
  global $conn;
  $result = mysqli_query($conn,$query);
  $rows = [];
  while($row = mysqli_fetch_assoc($result)){
    $rows[] = $row;
  }
  return $rows;
}

function aspirasi($data){
  global $conn;
  // $id_aspirasi = $data['id_aspirasi'];
  $judul_aspirasi = $data['judul_aspirasi'];
  $lokasi = $data['lokasi'];
  $isi_aspirasi = $data['isi_aspirasi'];
  $id_kategori = $data['id_kategori'];
  // $status_aspirasi = $data['status_aspirasi'];
  $alamat = $data['alamat'];
  $nama_penduduk = $data['nama_penduduk'];

  $conn->query("INSERT INTO penduduk(nama_penduduk,alamat)
                VALUES('$nama_penduduk','$alamat');");

  $id = $conn->query("SELECT id_penduduk FROM penduduk WHERE nama_penduduk ='$nama_penduduk' AND alamat = '$alamat' ")->fetch_assoc();
  // var_dump($id['id_penduduk']);die;

  $conn->query("INSERT INTO aspirasi(id_penduduk,judul_aspirasi,lokasi,isi_aspirasi,id_kategori)
            VALUES ({$id['id_penduduk']},'$judul_aspirasi','$lokasi','$isi_aspirasi','$id_kategori')");

  return mysqli_affected_rows($conn);

}

function sendFeedback($data){
  global $conn;
  $feedback = $data['feedback'];
  $isAdmin = isset($_SESSION['isAdmin']) ? 1 : 0 ;
  $aspirasi_id = $_GET['id'];
  $conn->query("INSERT INTO feedbacks(feedback, isAdmin, aspirasi_id) VALUES ('$feedback', '$isAdmin', '$aspirasi_id');");
}

?>
