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
        <div class="col-md-6 offset-md-3 mb-5 pb-5">
          <h1 class="text-center mb-3">Aplikasi To Do List</h1>

          <a href="tambah.php" class="btn-primary btn btn-sm mb-2">
            <ion-icon name="add-outline"></ion-icon> Tambah Tugas
          </a>

          <?php
          include("koneksi.php");
          $hari_ini = date('Y-m-d');

          $sql = "SELECT * FROM list WHERE status_selesai = 0 AND (deadline >= '$hari_ini' OR deadline IS NULL) ORDER BY id ASC";
          $query = mysqli_query($koneksi, $sql) or die("Gagal SQL");

          while ($data = mysqli_fetch_array($query)) {
          ?>
            <div class="card mt-2">
              <div class="card-body">
                <div class="row">
                  <div class="col-md-9">
                    <?php
                    // Menampilkan Judul
                    echo $data['judul'];

                    // Menampilkan Deadline di bawah judul
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
                    <a href="#" class="btn btn-warning btn-sm btn-edit" data-id="<?php echo $data['id']; ?>">
                      <ion-icon name="pencil-outline"></ion-icon>
                    </a>
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

  <div style="position: fixed; bottom: 20px; left: 20px; width: 320px; max-height: 450px; overflow-y: auto; z-index: 1000;" class="bg-white border border-success rounded shadow p-3">
    <div class="d-flex justify-content-between align-items-center mb-2">
      <h6 class="text-success fw-bold m-0"><ion-icon name="checkbox-outline"></ion-icon> Selesai</h6>
      <a href="hapus_semua_selesai.php" class="btn btn-sm btn-outline-danger py-0" style="font-size: 11px;" onclick="return confirm('Yakin ingin menghapus SEMUA tugas yang sudah selesai?')">Hapus Semua</a>
    </div>
    <hr class="mt-1">

    <?php
    $sql_done = "SELECT * FROM list WHERE status_selesai = 1 ORDER BY id ASC";
    $query_done = mysqli_query($koneksi, $sql_done);

    if (mysqli_num_rows($query_done) > 0) {
      while ($done = mysqli_fetch_array($query_done)) {
    ?>
        <div class="card mb-2 border-success">
          <div class="card-body p-2">
            <small class="fw-bold text-success"><s><?php echo $done['judul']; ?></s></small>
            <?php if (!empty($done['deadline'])) { ?>
              <br><small class="text-muted" style="font-size: 11px;">Deadline: <?php echo date('d-m-Y', strtotime($done['deadline'])); ?></small>
            <?php } ?>
            <a href="hapus.php?id=<?php echo $done['id'] ?>" class="float-end text-danger" style="font-size: 14px;" onclick="return confirm('Yakin ingin menghapus?')">
              <ion-icon name="trash-outline"></ion-icon>
            </a>
          </div>
        </div>
    <?php
      }
    } else {
      echo "<small class='text-muted d-block text-center'>Belum ada tugas selesai.</small>";
    }
    ?>
  </div>

  <div style="position: fixed; bottom: 20px; right: 20px; width: 320px; max-height: 450px; overflow-y: auto; z-index: 1000;" class="bg-white border border-danger rounded shadow p-3">
    <div class="d-flex justify-content-between align-items-center mb-2">
      <h6 class="text-danger fw-bold m-0"><ion-icon name="warning-outline"></ion-icon> Terlewat</h6>
      <a href="hapus_semua_terlewat.php" class="btn btn-sm btn-outline-danger py-0" style="font-size: 11px;" onclick="return confirm('Yakin ingin menghapus SEMUA tugas terlewat beserta refleksinya?')">Hapus Semua</a>
    </div>
    <hr class="mt-1">

    <?php
    $sql_missed = "SELECT * FROM list WHERE status_selesai = 0 AND deadline IS NOT NULL AND deadline < '$hari_ini' ORDER BY id ASC";
    $query_missed = mysqli_query($koneksi, $sql_missed);

    if (mysqli_num_rows($query_missed) > 0) {
      while ($missed = mysqli_fetch_array($query_missed)) {
    ?>
        <div class="card mb-2 border-danger">
          <div class="card-body p-2">
            <small class="fw-bold"><?php echo $missed['judul']; ?></small><br>
            <small class="text-muted" style="font-size: 11px;">Terlewat: <?php echo date('d-m-Y', strtotime($missed['deadline'])); ?></small>

            <form action="simpan_komentar.php" method="POST" class="mt-2">
              <input type="hidden" name="id" value="<?php echo $missed['id']; ?>">
              <?php if (empty($missed['komentar'])) { ?>
                <textarea name="komentar" class="form-control form-control-sm mb-1" placeholder="Kenapa terlewat? (Refleksi)" rows="2" required></textarea>
                <button type="submit" class="btn btn-danger btn-sm w-100" style="font-size: 12px;">Simpan Refleksi</button>
              <?php } else { ?>
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