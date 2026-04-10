<?php

include('koneksi.php');

$id = $_GET['id'];

$sql = "select*from list where id='$id'";
$query = mysqli_query($koneksi, $sql);
$data = mysqli_fetch_array($query);

?>

<form action="edit_data.php" method="POST">

    <input type="hidden" name="id" value="<?php echo $data['id'] ?>">

    <div class="mb-3">
        <label class="form-label">Judul</label>
        <input type="text" class="form-control" id="judul" name="judul" value="<?php echo $data['judul'] ?>">
    </div>

    <div class="mb-3">
        <label class="form-label">Deadline</label>
        <input type="date" class="form-control" id="deadline" name="deadline" value="<?php echo $data['deadline'] ?>">
    </div>

    <button type="submit" class="btn btn-primary">Simpan</button>

</form>