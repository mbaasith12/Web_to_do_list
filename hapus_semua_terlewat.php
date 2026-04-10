<?php
include('koneksi.php');

// Hapus semua tugas yang status_selesai = 1 (Sudah Selesai)
$sql = "DELETE FROM list WHERE status_selesai = 1";
mysqli_query($koneksi, $sql) or die("Gagal menghapus tugas selesai: " . mysqli_error($koneksi));

header('location:index.php');
