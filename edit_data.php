<?php
include('koneksi.php');

$judul = $_POST['judul'];
$id = $_POST['id'];
$deadline = $_POST['deadline'];

if (empty($deadline)) {
    $deadline_sql = "NULL";
} else {
    $deadline_sql = "'$deadline'";
}

$sql = "update list set judul='$judul', deadline=$deadline_sql where id='$id'";
mysqli_query($koneksi, $sql) or die("Gagal SQL: " . mysqli_error($koneksi));

header('location:index.php');
