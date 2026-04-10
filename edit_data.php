<?php
// koneksi
include('koneksi.php');

// ambil data dari form tambah
$judul = $_POST['judul'];
$id = $_POST['id'];

// simpan data ke dtabase
$sql = "update list set judul='$judul' where id='$id'";
mysqli_query($koneksi, $sql) or die("Gagal SQL");

// pindah halaman kalau udh done
header('location:index.php');
