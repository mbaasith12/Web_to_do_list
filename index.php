<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Aplikasi To Do List</title>

  <link href="css/bootstrap.min.css" rel="stylesheet">

  <style>
    /* =========================================
       MEMASANG FONT DARI FILE LOKAL
       ========================================= */
    @font-face {
      font-family: 'Fontku';
      /* Ini nama panggilan untuk font kamu, bebas dinamai apa saja */
      src: url('handwriting-black-draft_DEMO.otf');
      /* Pastikan nama file di sini SAMA PERSIS dengan file aslinya (huruf besar/kecil ngaruh) */
    }

    /* RESET HTML DAN BODY */
    html,
    body {
      height: 100%;
      margin: 0;
      padding: 0;
    }

    body {
      /* PENGATURAN BACKGROUND AGAR TIDAK TERPOTONG */
      background-image: url('siang.png');
      background-size: 100% 100%;
      background-position: top center;
      background-attachment: fixed;
      background-repeat: no-repeat;
      background-color: #f8f9fa;
      min-height: 100vh;
      transition: background-image 0.5s ease-in-out;
    }

    /* HEADER: Posisi tulisan judul di atas foto */
    /* HEADER: Container utama untuk logo dan judul */
    .header-section {
      height: 20vh;
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.8);
      position: relative;
      /* Penting agar logo bisa diposisikan terhadap header ini */
    }

    /* PENGATURAN LOGO DI KIRI ATAS HEADER */
    .logo-header {
      position: absolute;
      top: 12px;
      /* Jarak dari atas */
      left: 20px;
      /* Jarak dari kiri */
      height: 122px;
      /* Atur besar kecilnya logo di sini */
      width: auto;
      filter: brightness(1.3);
    }

    /* Menerapkan font lokal ke judul Header */
    .header-section h1 {
      font-family: 'Fontku', sans-serif;
      /* Memanggil nama font yang sudah dibuat di @font-face */
    }

    /* MAIN CONTENT: Area List Tugas (Setelah garis putih di foto) */
    .main-content {
      padding-top: 20px;
      padding-bottom: 150px;
    }

    /* Membuat card sedikit transparan agar background terlihat */
    .card {
      background-color: rgba(255, 255, 255, 0.85);
      border: none;
      border-radius: 12px;
    }

    /* =========================================
       MODE MALAM (Easter Egg)
       ========================================= */
    body.night-mode {
      background-image: url('malam.png') !important;
      /* Ganti '2.png' dengan nama foto malammu */
    }
  </style>
</head>

<body>

  <header class="header-section">
    <img src="logo.png" id="logoEasterEgg" class="logo-header" style="cursor: pointer;" alt="Logo">
    <h1 class="display-3 fw-bold">Aplikasi To Do List</h1>
  </header>

  <section class="main-content">
    <div class="container">
      <div class="row">
        <div class="col-md-6 offset-md-3">

          <div class="mb-3 d-flex justify-content-between">
            <button type="button" class="btn btn-primary btn-sm shadow-sm" data-bs-toggle="modal" data-bs-target="#tambahModal">
              <ion-icon name="add-outline"></ion-icon> Tambah Tugas
            </button>
          </div>

          <?php
          include("koneksi.php");
          $hari_ini = date('Y-m-d');

          // AMBIL TUGAS AKTIF
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
                  <div class="text-end">
                    <a href="set_selesai.php?id=<?php echo $data['id'] ?>" class="btn btn-success btn-sm"><ion-icon name="checkmark-outline"></ion-icon></a>
                    <a href="#" class="btn btn-warning btn-sm btn-edit" data-id="<?php echo $data['id']; ?>"><ion-icon name="pencil-outline"></ion-icon></a>
                    <a href="hapus.php?id=<?php echo $data['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')"><ion-icon name="trash-outline"></ion-icon></a>
                  </div>
                </div>
              </div>
          <?php
            }
          } else {
            // Jika tugas utama kosong
            echo "<div class='text-center p-4 bg-white rounded shadow-sm opacity-75'><small class='text'>Selamat! Semua tugas sudah selesai :D</small></div>";
          }
          ?>
        </div>
      </div>
    </div>
  </section>

  <div style="position: fixed; bottom: 20px; left: 20px; width: 280px; max-height: 300px; overflow-y: auto; z-index: 1000;" class="bg-white border border-success rounded shadow p-3">
    <div class="d-flex justify-content-between align-items-center mb-2">
      <h6 class="text-success fw-bold m-0 small">Selesai</h6>
      <a href="hapus_semua_selesai.php" class="btn btn-sm btn-outline-danger py-0" style="font-size: 9px;" onclick="return confirm('Hapus semua?')">Hapus Semua</a>
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
      // BAGIAN YANG KAMU TANYAKAN (Muncul jika list kosong)
      echo "<small class='text-muted d-block text-center'>Belum ada tugas selesai.</small>";
    }
    ?>
  </div>

  <div style="position: fixed; bottom: 20px; right: 20px; width: 280px; max-height: 300px; overflow-y: auto; z-index: 1000;" class="bg-white border border-danger rounded shadow p-3">
    <div class="d-flex justify-content-between align-items-center mb-2">
      <h6 class="text-danger fw-bold m-0 small">Terlewat</h6>
      <a href="hapus_semua_terlewat.php" class="btn btn-sm btn-outline-danger py-0" style="font-size: 9px;" onclick="return confirm('Hapus semua?')">Hapus Semua</a>
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
      // BAGIAN YANG KAMU TANYAKAN (Muncul jika list kosong)
      echo "<small class='text-muted d-block text-center'>Hebat! Tidak ada tugas terlewat.</small>";
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

  <div class="modal fade" id="tambahModal" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title fw-bold">Tambah Tugas Baru</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <form action="simpan_data.php" method="POST">
          <div class="modal-body">
            <div class="mb-3">
              <label class="form-label">Nama Tugas</label>
              <input type="text" name="judul" class="form-control" placeholder="Tulis tugasmu di sini..." required autofocus>
            </div>
            <div class="mb-3">
              <label class="form-label">Deadline (Opsional)</label>
              <input type="date" name="deadline" class="form-control">
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary btn-sm">Simpan Tugas</button>
          </div>
        </form>
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

  <script>
    // --- FITUR EASTER EGG SIANG/MALAM ---
    const logoBtn = document.getElementById('logoEasterEgg');
    const body = document.body;

    // 1. Cek apakah sebelumnya web sedang dalam mode malam
    if (localStorage.getItem('theme') === 'night') {
      body.classList.add('night-mode');
    }

    // 2. Aksi ketika logo diklik
    if (logoBtn) {
      logoBtn.addEventListener('click', () => {
        body.classList.toggle('night-mode');

        // Simpan status agar tidak hilang saat refresh atau tambah tugas
        if (body.classList.contains('night-mode')) {
          localStorage.setItem('theme', 'night');
        } else {
          localStorage.setItem('theme', 'day');
        }
      });
    }
  </script>
</body>

</html>