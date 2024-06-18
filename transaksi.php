<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Transaksi - Management Stok</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />
</head>
<style>
  @keyframes fadeIn {
    from {
      opacity: 0;
    }

    to {
      opacity: 1;
    }
  }

  .animated-card {
    animation: fadeIn 1s ease-in-out;
  }

  /* Global styles */
  body {
    font-family: Arial, sans-serif;
    margin: 0;
  }

  /* Sidebar styles */
  .sidebar {
    height: 100%;
    width: 250px;
    position: fixed;
    top: 0;
    left: 0;
    background-color: #2e3539;
    padding-top: 20px;
    transition: width 0.3s ease;
    /* Smooth transition for sidebar width */
  }

  .sidebar h2 {
    color: #fff;
    text-align: center;
    margin-bottom: 30px;
  }

  .sidebar ul {
    list-style-type: none;
    padding: 0;
    margin: 0;
  }

  .sidebar li {
    padding: 10px;
    transition: background-color 0.3s ease;
    /* Smooth transition for background color change */
  }

  .sidebar a {
    color: #fff;
    text-decoration: none;
    display: block;
    /* Ensures the entire li area is clickable */
    padding: 10px;
  }

  .sidebar li.active a {
    background-color: #1a73e8;
    border-radius: 10px;
    /* Active background color */
  }

  .sidebar li.active a {
    font-weight: bold;
    /* Example: Highlight active link with bold text */
  }

  .sidebar a:hover {
    background-color: #1a73e8;
    border-radius: 10px;
    /* Hover background color */
  }

  /* Content styles */
  .content {
    margin-left: 250px;
    padding: 20px;
    transition: margin-left 0.3s ease;
    /* Smooth transition for content margin adjustment */
  }
</style>

<body>
  <?php
  require_once('config/connection.php');
  require_once('config/helper.php');
  require_once('config/services.php');

  $current_page = basename($_SERVER['REQUEST_URI']);

  $resultBarangKeluar = displayDataBarangKeluar();
  ?>
  <!-- Sidebar -->
  <div class="sidebar">
    <div class="d-flex justify-content-center mb-4">
      <img src="./assets/Logo-Bengkel.png" width="200" alt="logo-bengkel" />
    </div>
    <ul>
      <li class="<?php echo $current_page == 'dashboard.php' ? 'active' : ''; ?>"><a href="dashboard.php">Dashboard</a></li>
      <li class="<?php echo $current_page == 'stok-gudang.php' ? 'active' : ''; ?>"><a href="stok-gudang.php">Stok Gudang</a></li>
      <li class="<?php echo $current_page == 'pengelolaan-data.php' ? 'active' : ''; ?>"><a href="pengelolaan-data.php">Pengelolaan Data</a></li>
      <li class="<?php echo $current_page == 'transaksi.php' ? 'active' : ''; ?>"><a href="transaksi.php">Transaksi</a></li>
      <li class="<?php echo $current_page == 'user.php' ? 'active' : ''; ?>"><a href="user.php">Manajemen Pengguna</a></li>
      <li class="<?php echo $current_page == 'notification.php' ? 'active' : ''; ?>"><a href="notification.php">Aktivitas Pengguna</a></li>
    </ul>
  </div>

  <div class="content">
    <nav class="navbar navbar-light bg-light">
      <div class="container-fluid">
        <a class="navbar-brand"><i class="bi bi-arrow-bar-left me-2"></i>Transaksi</a>
        <form class="d-flex">
          <a href="login.php"><button class="btn btn-outline-primary" type="button">
              <i class="bi bi-box-arrow-left me-2"></i>
              Logout
            </button></a>
        </form>
      </div>
    </nav>
    <!-- content -->
    <div class="card pt-2 px-3 bg-primary" style="margin-top: 3%">
      <div class="d-flex justify-content-between align-items-center">
        <h4 class="text-white">Barang Keluar</h4>
        <button type="button" class="btn btn-outline-light mb-2" data-bs-toggle="modal" data-bs-target="#exampleModalCreate">
          Tambah
        </button>
      </div>
    </div>
    <table class="table table-striped table-hover mt-2 animated-card">
      <thead>
        <tr>
          <?php
          $headerBarangKeluar = ["No", "Kode Barang", "Nama Barang", "Tipe", "Satuan", "Kuantitas", "Harga Barang", "Total", "Nama Pelanggan", "No HP", "Keterangan", "Tanggal", "Aksi"];
          for ($i = 0; $i < count($headerBarangKeluar); $i++) {
            echo "<th scope='col'>";
            echo $headerBarangKeluar[$i];
            echo "</th>";
          }
          ?>
        </tr>
      </thead>
      <tbody>
        <?php if ($resultBarangKeluar && $resultBarangKeluar->num_rows < 1) : ?>
          <tr>
            <td colspan="<?php echo count($headerBarangKeluar); ?>" class="text-center">Tidak ada data tersedia</td>
          </tr>
        <?php else : ?>
          <?php $no = 0; ?>
          <?php foreach ($resultBarangKeluar as $row) : ?>
            <?php $no++; ?>
            <tr>
              <td><?php echo $no; ?></td>
              <td><?php echo $row["kode_barang"]; ?></td>
              <td><?php echo $row["nama_barang"]; ?></td>
              <td><?php echo $row["nama_tipe"]; ?></td>
              <td><?php echo $row["nama_satuan"]; ?></td>
              <td><?php echo $row["kuantitas"]; ?></td>
              <td><?php echo formatRupiah($row["harga_barang"]); ?></td>
              <td><?php echo formatRupiah($row["total_harga"]); ?></td>
              <td><?php echo $row["nama_pelanggan"]; ?></td>
              <td><?php echo $row["no_hp"]; ?></td>
              <td><?php echo $row["keterangan"]; ?></td>
              <td><?php echo formatDate($row["updated_at"]); ?></td>
              <td>
                <a class='btn btn-primary btn-sm me-2 edit-button' data-bs-toggle='modal' data-bs-target='#modalEditBarangMasuk' onclick='populateModalEditBarangMasuk("<?php echo $row["id"]; ?>", "<?php echo $row["kode_barang"]; ?>", "<?php echo $row["id_satuan"]; ?>", "<?php echo $row["kode_tipe"]; ?>", "<?php echo $row["total_kuantitas"]; ?>", "<?php echo $row["harga_barang"]; ?>", "<?php echo $row["total_harga"]; ?>", "<?php echo $row["updated_at"]; ?>")'><i class='bi bi-pencil'></i></a>
                <a class='btn btn-danger btn-sm' data-bs-toggle='modal' data-bs-target='#deleteModalBarangMasuk' onclick='populateDeleteModalBarangMasuk("<?php echo $row["id"]; ?>")'><i class='bi bi-trash'></i></a>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
  <!-- modal create -->
  <div class="modal fade" id="exampleModalCreate" tabindex="-1" aria-labelledby="exampleModalLabelCreate" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Tambah Barang</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="kodeBarang" class="form-label">Kode Barang</label>
            <input type="text" class="form-control" id="kodeBarang" placeholder="kode barang">
          </div>
          <div class="mb-3">
            <label for="kodeBarang" class="form-label">Nama Barang</label>
            <input type="text" class="form-control" id="kodeBarang" placeholder="nama barang">
          </div>
          <div class="mb-3">
            <label for="kodeBarang" class="form-label">Tipe Barang</label>
            <input type="text" class="form-control" id="kodeBarang" placeholder="tipe barang">
          </div>
          <div class="mb-3">
            <label for="kodeBarang" class="form-label">Jumlah Barang</label>
            <input type="text" class="form-control" id="kodeBarang" placeholder="jumlah barang">
          </div>
          <div class="mb-3">
            <label for="kodeBarang" class="form-label">Harga Barang</label>
            <input type="text" class="form-control" id="kodeBarang" placeholder="harga barang">
          </div>
          <div class="mb-3">
            <label for="kodeBarang" class="form-label">Laporan di Update</label>
            <input type="text" class="form-control" id="kodeBarang" placeholder="harga barang">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div>
      </div>
    </div>
  </div>
  <!-- modal edit -->
  <div class="modal fade" id="exampleModalEdit" tabindex="-1" aria-labelledby="exampleModalLabelEdit" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Edit Barang</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          ...
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">close data in teger</button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div>
      </div>
    </div>
  </div>
  <!-- modal delete -->
  <!-- Option 1: Bootstrap Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" integrity="sha384-4LISF5TTJX/fLmGSxO53rV4miRxdg84mZsxmO8Rx5jGtp/LbrixFETvWa5a6sESd" crossorigin="anonymous" />
  <script>
    // JavaScript code to handle button click
    function toLogin() {
      window.location.href = "/login.php";
    }
  </script>
</body>

</html>