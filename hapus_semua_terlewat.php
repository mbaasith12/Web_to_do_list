<?php
include('koneksi.php');

$hari_ini = date('Y-m-d');

$sql = "DELETE FROM list WHERE status_selesai = 0 AND deadline IS NOT NULL AND deadline < '$hari_ini'";
mysqli_query($koneksi, $sql) or die("Gagal menghapus tugas terlewat: " . mysqli_error($koneksi));

header('location:index.php');
