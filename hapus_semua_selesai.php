<?php
include('koneksi.php');

$sql = "DELETE FROM list WHERE status_selesai = 1";
mysqli_query($koneksi, $sql) or die("Gagal menghapus tugas selesai: " . mysqli_error($koneksi));

header('location:index.php');
