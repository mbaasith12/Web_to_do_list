<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Aplikasi To Do List</title>
  <link href="css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

  <section>
    <div class="container">
      <div class="row">
        <div class="col-md-6 offset-md-3">
          <h1 class="text-center mb-3">Aplikasi To Do List</h1>

          <a href="tambah.php" class="btn-primary btn btn-sm mb-2">
            <ion-icon name="add-outline"></ion-icon> Tambah Tugas
          </a>

          <?php
          include("koneksi.php");

          // Ambil tanggal hari ini menggunakan PHP
          $hari_ini = date('Y-m-d');

          // QUERY UTAMA: Hanya tampilkan tugas yang SUDAH SELESAI, atau DEADLINE MASIH NANTI/HARI INI, atau TIDAK PUNYA DEADLINE
          $sql = "SELECT * FROM list WHERE status_selesai = 1 OR deadline >= '$hari_ini' OR deadline IS NULL ORDER BY id ASC";
          $query = mysqli_query($koneksi, $sql) or die("Gagal SQL");

          while ($data = mysqli_fetch_array($query)) {
          ?>
            <div class="card mt-2">
              <div class="card-body">
                <div class="row">

                  <div class="col-md-9">
                    <?php
                    // 1. Menampilkan icon centang hijau jika tugas sudah selesai
                    if ($data['status_selesai'] == 1) {
                    ?>
                      <ion-icon name="checkbox-outline" style="font-size:20px; position:relative; top:5px; color:green"></ion-icon>
                    <?php } ?>

                    <?php
                    // 2. Menampilkan Judul (dicoret jika selesai)
                    if ($data['status_selesai'] == 1) {
                      echo "<s>" . $data['judul'] . "</s>";
                    } else {
                      echo $data['judul'];
                    }

                    // 3. Menampilkan Deadline di bawah judul
                    if (!empty($data['deadline'])) {
                      $tanggal_tampil = date('d-m-Y', strtotime($data['deadline']));
                      echo "<br><small class='text-danger'><ion-icon name='calendar-outline'></ion-icon> Deadline: $tanggal_tampil</small>";
                    }
                    ?>
                  </div>

                  <div class="col-md-3 text-end">
                    <a href="set_selesai.php?id=<?php echo $data['id'] ?>" class="btn btn-success btn-sm">
                      <ion-icon name="checkmark-outline"></ion-icon>
                    </a>
                    <?php if ($data['status_selesai'] == 0) { ?>
                      <a href="#" class="btn btn-warning btn-sm btn-edit" data-id="<?php echo $data['id']; ?>">
                        <ion-icon name="pencil-outline"></ion-icon>
                      </a>
                    <?php } ?>
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
        </div>
      </div>
    </div>
  </section>

  <div style="position: fixed; bottom: 20px; right: 20px; width: 320px; max-height: 450px; overflow-y: auto; z-index: 1000;" class="bg-white border border-danger rounded shadow p-3">
    <h6 class="text-danger fw-bold"><ion-icon name="warning-outline"></ion-icon> Tugas Terlewat</h6>
    <hr>
    <?php
    // QUERY KEDUA: Hanya ambil tugas yang BELUM SELESAI dan SUDAH LEWAT DEADLINE
    $sql_missed = "SELECT * FROM list WHERE status_selesai = 0 AND deadline IS NOT NULL AND deadline < '$hari_ini' ORDER BY id ASC";
    $query_missed = mysqli_query($koneksi, $sql_missed);

    // Jika ada tugas yang terlewat
    if (mysqli_num_rows($query_missed) > 0) {
      while ($missed = mysqli_fetch_array($query_missed)) {
    ?>
        <div class="card mb-2 border-danger">
          <div class="card-body p-2">
            <small class="fw-bold"><?php echo $missed['judul']; ?></small><br>
            <small class="text-muted" style="font-size: 11px;">Terlewat sejak: <?php echo date('d-m-Y', strtotime($missed['deadline'])); ?></small>

            <form action="simpan_komentar.php" method="POST" class="mt-2">
              <input type="hidden" name="id" value="<?php echo $missed['id']; ?>">

              <?php
              // Jika belum ada komentar, tampilkan kotak input
              if (empty($missed['komentar'])) {
              ?>
                <textarea name="komentar" class="form-control form-control-sm mb-1" placeholder="Kenapa terlewat? (Refleksi)" rows="2" required></textarea>
                <button type="submit" class="btn btn-danger btn-sm w-100" style="font-size: 12px;">Simpan Refleksi</button>
              <?php
                // Jika sudah ada komentar, tampilkan komentarnya sebagai teks
              } else {
              ?>
                <div class="bg-light p-1 rounded border mt-1" style="font-size: 11px;">
                  <strong class="text-secondary">Refleksiku:</strong><br>
                  <span><?php echo $missed['komentar']; ?></span>
                </div>
              <?php } ?>
            </form>
          </div>
        </div>
    <?php
      }
    } else {
      // Pesan jika tidak ada tugas yang terlewat
      echo "<small class='text-muted d-block text-center'>Hebat! Tidak ada tugas yang terlewat.</small>";
    }
    ?>
  </div>

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