<?php
include('koneksi.php');

$judul = $_POST['judul'];
$deadline = $_POST['deadline'];

if (empty($deadline)) {
    $deadline_sql = "NULL";
} else {
    $deadline_sql = "'$deadline'";
}

$sql = "insert into list (judul, deadline) values ('$judul', $deadline_sql)";
mysqli_query($koneksi, $sql) or die("Gagal SQL: " . mysqli_error($koneksi));

header('location:index.php');
