<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Aplikasi To Do List - Productivity App</title>

  <link href="css/bootstrap.min.css" rel="stylesheet">

  <style>
    /* PENGATURAN BACKGROUND UTAMA */
    html,
    body {
      height: 100%;
      margin: 0;
    }

    body {
      /* Memanggil foto 1.jpg sebagai background */
      background-image: url('1.png');
      background-size: cover;
      background-position: center;
      background-attachment: fixed;
      background-repeat: no-repeat;
      background-color: #f8f9fa;
      /* Warna cadangan jika gambar gagal muat */
    }

    /* HEADER: Tulisan "Aplikasi To Do List" di bagian atas foto */
    .header-section {
      height: 100px;
      /* Tinggi area header foto sebelum garis putih */
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      text-shadow: 3px 3px 6px rgba(0, 0, 0, 0.7);
    }

    /* MAIN CONTENT: Area List Tugas (Setelah garis putih) */
    .main-content {
      padding-top: 30px;
      /* Jarak setelah garis putih foto */
      padding-bottom: 100px;
    }

    /* Kartu tugas dibuat semi-transparan agar estetik */
    .card {
      background-color: rgba(255, 255, 255, 0.9);
      border: none;
      border-radius: 10px;
    }
  </style>
</head>

<body>

  <header class="header-section">
    <h1 class="display-3 fw-bold">Aplikasi To Do List</h1>
  </header>

  <section class="main-content">
    <div class="container">
      <div class="row">
        <div class="col-md-6 offset-md-3">

          <div class="mb-3">
            <a href="tambah.php" class="btn btn-primary btn-sm shadow">
              <ion-icon name="add-outline"></ion-icon> Tambah Tugas Baru
            </a>
          </div>

          <?php
          include("koneksi.php");
          $hari_ini = date('Y-m-d');

          // TAMPILKAN TUGAS YANG BELUM SELESAI & BELUM TERLEWAT
          $sql = "SELECT * FROM list WHERE status_selesai = 0 AND (deadline >= '$hari_ini' OR deadline IS NULL) ORDER BY id ASC";
          $query = mysqli_query($koneksi, $sql) or die("Gagal SQL");

          if (mysqli_num_rows($query) > 0) {
            while ($data = mysqli_fetch_array($query)) {
          ?>
              <div class="card mt-2 shadow-sm">
                <div class="card-body d-flex justify-content-between align-items-center">
                  <div>
                    <strong><?php echo $data['judul']; ?></strong>
                    <?php if (!empty($data['deadline'])) { ?>
                      <br><small class="text-danger"><ion-icon name="calendar-outline"></ion-icon> Deadline: <?php echo date('d-m-Y', strtotime($data['deadline'])); ?></small>
                    <?php } ?>
                  </div>
                  <div class="text-end" style="min-width: 120px;">
                    <a href="set_selesai.php?id=<?php echo $data['id'] ?>" class="btn btn-success btn-sm"><ion-icon name="checkmark-outline"></ion-icon></a>
                    <a href="#" class="btn btn-warning btn-sm btn-edit" data-id="<?php echo $data['id']; ?>"><ion-icon name="pencil-outline"></ion-icon></a>
                    <a href="hapus.php?id=<?php echo $data['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')"><ion-icon name="trash-outline"></ion-icon></a>
                  </div>
                </div>
              </div>
          <?php
            }
          } else {
            // Jika tidak ada tugas aktif
            echo "<div class='text-center p-4 bg-white rounded shadow-sm'><small class='text-muted'>Tidak ada tugas yang perlu dikerjakan saat ini.</small></div>";
          }
          ?>
        </div>
      </div>
    </div>
  </section>

  <div style="position: fixed; bottom: 20px; left: 20px; width: 300px; max-height: 350px; overflow-y: auto; z-index: 1000;" class="bg-white border border-success rounded shadow p-3">
    <div class="d-flex justify-content-between align-items-center mb-2">
      <h6 class="text-success fw-bold m-0">Selesai</h6>
      <a href="hapus_semua_selesai.php" class="btn btn-sm btn-outline-danger py-0" style="font-size: 10px;" onclick="return confirm('Hapus semua?')">Hapus Semua</a>
    </div>
    <hr class="mt-1">
    <?php
    $sql_done = "SELECT * FROM list WHERE status_selesai = 1 ORDER BY id ASC";
    $query_done = mysqli_query($koneksi, $sql_done);

    if (mysqli_num_rows($query_done) > 0) {
      while ($done = mysqli_fetch_array($query_done)) {
        echo "<div class='card mb-2 border-success p-2 shadow-sm'><small class='text-success'><s>" . $done['judul'] . "</s></small></div>";
      }
    } else {
      // BAGIAN YANG KAMU TANYAKAN
      echo "<small class='text-muted d-block text-center'>Belum ada tugas selesai.</small>";
    }
    ?>
  </div>

  <div style="position: fixed; bottom: 20px; right: 20px; width: 300px; max-height: 350px; overflow-y: auto; z-index: 1000;" class="bg-white border border-danger rounded shadow p-3">
    <div class="d-flex justify-content-between align-items-center mb-2">
      <h6 class="text-danger fw-bold m-0">Terlewat</h6>
      <a href="hapus_semua_terlewat.php" class="btn btn-sm btn-outline-danger py-0" style="font-size: 10px;" onclick="return confirm('Hapus semua?')">Hapus Semua</a>
    </div>
    <hr class="mt-1">
    <?php
    $sql_missed = "SELECT * FROM list WHERE status_selesai = 0 AND deadline IS NOT NULL AND deadline < '$hari_ini' ORDER BY id ASC";
    $query_missed = mysqli_query($koneksi, $sql_missed);

    if (mysqli_num_rows($query_missed) > 0) {
      while ($missed = mysqli_fetch_array($query_missed)) {
    ?>
        <div class="card mb-2 border-danger p-2 shadow-sm">
          <small class="fw-bold"><?php echo $missed['judul']; ?></small>
          <form action="simpan_komentar.php" method="POST" class="mt-1">
            <input type="hidden" name="id" value="<?php echo $missed['id']; ?>">
            <?php if (empty($missed['komentar'])) { ?>
              <textarea name="komentar" class="form-control form-control-sm" rows="1" placeholder="Refleksi..."></textarea>
              <button type="submit" class="btn btn-danger btn-sm w-100 mt-1" style="font-size: 9px;">Simpan</button>
            <?php } else { ?>
              <div class="bg-light p-1 rounded" style="font-size: 10px;">Refleksi: <?php echo $missed['komentar']; ?></div>
            <?php } ?>
          </form>
        </div>
    <?php
      }
    } else {
      // BAGIAN YANG KAMU TANYAKAN
      echo "<small class='text-muted d-block text-center'>Hebat! Tidak ada tugas yang terlewat.</small>";
    }
    ?>
  </div>

  <div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit Tugas</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body" id="modal-body-edit"></div>
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
          .then(res => res.text())
          .then(data => {
            document.getElementById('modal-body-edit').innerHTML = data;
            new bootstrap.Modal(document.getElementById('editModal')).show();
          });
      });
    });
  </script>
</body>

</html>