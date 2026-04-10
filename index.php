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
    <div class="container">
      <div class="row">
        <div class="col-md-6 offset-md-3">
          <h1 class="text-center mb-3">Aplikasi To Do List</h1>

          <a href="tambah.php" class="btn-primary btn btn-sm">
            <ion-icon name="add-outline"></ion-icon>
          </a>

          <!-- Card itu dari sini -->
          <?php
          include("koneksi.php");

          $sql = "select*from list order by id asc";
          $query = mysqli_query($koneksi, $sql) or die("Gagal SQL");
          while ($data = mysqli_fetch_array($query)) {

          ?>
            <div class="card mt-2">
              <div class="card-body">
                <div class="row">
                  <?php
                  // Menampilkan Judul
                  if ($data['status_selesai'] == 1) {
                    echo "<s>" . $data['judul'] . "</s>";
                  } else {
                    echo $data['judul'];
                  }

                  // Menampilkan Deadline di bawah judul dengan teks kecil berwarna abu-abu/merah
                  if (!empty($data['deadline'])) {
                    // Mengubah format tanggal menjadi DD-MM-YYYY agar lebih enak dibaca
                    $tanggal_tampil = date('d-m-Y', strtotime($data['deadline']));
                    echo "<br><small class='text-danger'><ion-icon name='calendar-outline'></ion-icon> Deadline: $tanggal_tampil</small>";
                  }
                  ?>
                  <div class="col-md-9">
                    <?php
                    if ($data['status_selesai'] == 1) {
                    ?>
                      <ion-icon name="checkbox-outline" style="font-size:20px; position:relative; top:5px; color:green"></ion-icon>
                    <?php } ?>

                    <?php
                    if ($data['status_selesai'] == 1) {
                      echo "<s>" . $data['judul'] . "</s>";
                    } else {
                      echo $data['judul'];
                    }
                    ?>
                  </div>
                  <div class="col-md-3">
                    <!-- Tombol Selesai -->
                    <a href="set_selesai.php?id=<?php echo $data['id'] ?>" class="btn btn-success btn-sm">
                      <ion-icon name="checkmark-outline"></ion-icon>
                    </a>
                    <?php
                    if ($data['status_selesai'] == 0) {
                    ?>
                      <!-- Tombol Edit -->
                      <a href="#"
                        class="btn btn-warning btn-sm btn-edit"
                        data-id="<?php echo $data['id']; ?>">
                        <ion-icon name="pencil-outline"></ion-icon>
                      </a>
                    <?php
                    }
                    ?>
                    <!-- Tombol Delete -->
                    <a href="hapus.php?id=<?php echo $data['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">
                      <ion-icon name="trash-outline"></ion-icon>
                    </a>
                  </div>
                </div>
              </div>
            </div>
          <?php
          }
          ?>
          <!-- Card stop disini -->
        </div>
        <!-- Modal Edit -->
        <div class="modal fade" id="editModal" tabindex="-1">
          <div class="modal-dialog">
            <div class="modal-content">

              <div class="modal-header">
                <h5 class="modal-title">Edit Task</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
              </div>

              <div class="modal-body" id="modal-body-edit">
                Loading...
              </div>

            </div>
          </div>
        </div>
  </section>


  <script src="js/bootstrap.bundle.min.js"></script>
  <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
  <script>
    document.querySelectorAll('.btn-edit').forEach(function(button) {

      button.addEventListener('click', function() {

        let id = this.getAttribute('data-id');

        fetch('frm_edit.php?id=' + id)
          .then(response => response.text())
          .then(data => {

            document.getElementById('modal-body-edit').innerHTML = data;

            let modalElement = document.getElementById('editModal');
            let modal = new bootstrap.Modal(modalElement);
            modal.show();

            modalElement.addEventListener('shown.bs.modal', function() {

              setTimeout(function() {
                let input = document.querySelector('#modal-body-edit #judul');
                if (input) {
                  input.focus();
                  input.select();
                }
              }, 100);

            }, {
              once: true
            });

          });

      });

    });
  </script>
</body>

</html>