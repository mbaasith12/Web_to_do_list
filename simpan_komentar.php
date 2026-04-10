<?php
// Hubungkan ke database
include('koneksi.php');

// Tangkap id tugas dan isi komentarnya dari form
$id = $_POST['id'];
$komentar = $_POST['komentar'];

// Update tabel list dengan memasukkan komentar ke tugas yang tepat
$sql = "UPDATE list SET komentar='$komentar' WHERE id='$id'";
mysqli_query($koneksi, $sql) or die("Gagal menyimpan komentar: " . mysqli_error($koneksi));

// Kembalikan ke halaman utama setelah selesai
header('location:index.php');
