<?php
include('koneksi.php');

// Ambil tanggal hari ini untuk perbandingan
$hari_ini = date('Y-m-d');

// Perintah SQL diperbaiki: 
// Menghapus tugas yang status_selesai = 0 (belum selesai) 
// DAN memiliki deadline 
// DAN deadline-nya lebih kecil (sudah lewat) dari hari ini
$sql = "DELETE FROM list WHERE status_selesai = 0 AND deadline IS NOT NULL AND deadline < '$hari_ini'";
mysqli_query($koneksi, $sql) or die("Gagal menghapus tugas terlewat: " . mysqli_error($koneksi));

// Kembali ke halaman utama
header('location:index.php');
