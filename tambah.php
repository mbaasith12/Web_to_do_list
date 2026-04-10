<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Aplikasi To Do List</title>
  <link href="css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

  <!-- Main Section -->
  <section>
    <div class="container"></div>
    <div class="row">
      <div class="col-md-6 offset-md-3">
        <h3 class="text-center mb-3">Tambah Data - To Do List</h3>
        <form action="simpan_data.php" method="POST">

          <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Judul</label>
            <input type="text" class="form-control" id="judul" name="judul" autofocus>
          </div>

          <div class="mb-3">
            <label class="form-label">Deadline</label>
            <input type="date" class="form-control" name="deadline" required>
          </div>

          <button type="submit" class="btn btn-primary">Simpan</button>
          <a href="index.php" class="btn btn-danger">Batal</a>
        </form>
      </div>
    </div>
  </section>


  <script src="js/bootstrap.bundle.min.js"></script>
  <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>

</html>