<?php
include('koneksi.php');

$id = $_POST['id'];
$komentar = $_POST['komentar'];

$sql = "UPDATE list SET komentar='$komentar' WHERE id='$id'";
mysqli_query($koneksi, $sql) or die("Gagal menyimpan komentar: " . mysqli_error($koneksi));

header('location:index.php');
