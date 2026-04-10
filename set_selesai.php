<?php
include('koneksi.php');

$id = $_GET['id'];

$sql = "UPDATE list SET status_selesai = 1 - status_selesai WHERE id='$id'";
mysqli_query($koneksi, $sql) or die("Gagal SQL");

header('location:index.php');
