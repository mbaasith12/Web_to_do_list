<?php
// koneksi
include('koneksi.php');

// ambil data dari form tambah
$judul = $_POST['judul'];

// simpan data ke dtabase
$sql = "insert into list (judul) values ('$judul')";
mysqli_query($koneksi, $sql) or die("Gagal SQL");

// pindah halaman kalau udh done
header('location:index.php');
