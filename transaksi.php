<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Transaksi - Management Stok</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />
  <!-- Custom CSS -->
  <link href="./css/stok.css" rel="stylesheet" />
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
    background-color: rgb(0, 162, 255);
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

  .sidebar li.active {
    background-color: #555;
    /* Active background color */
  }

  .sidebar li.active a {
    font-weight: bold;
    /* Example: Highlight active link with bold text */
  }

  .sidebar a:hover {
    background-color: #555;
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
    <table class="table table-striped table-hover mt-4">
      <thead>
        <tr>
          <th>No</th>
          <th>Kode Barang</th>
          <th>Nama Barang</th>
          <th>Tipe Barang</th>
          <th>Jumlah Barang</th>
          <th>Harga Barang (pcs)</th>
          <th>Laporan di update</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
      </tbody>
    </table>
    <!-- barang keluar -->
    <div class="card pt-2 px-3 mt-5 bg-primary">
      <div class="d-flex justify-content-between align-items-center">
        <h4 class="text-white">Barang Masuk</h4>
        <button type="button" class="btn btn-outline-light mb-2" data-bs-toggle="modal" data-bs-target="#exampleModalCreate">
          Tambah
        </button>
      </div>
    </div>
    <table class="table table-striped table-hover mt-4">
      <thead>
        <tr>
          <th>No</th>
          <th>Kode Barang</th>
          <th>Nama Barang</th>
          <th>Tipe Barang</th>
          <th>Jumlah Barang</th>
          <th>Harga Barang (pcs)</th>
          <th>Laporan di update</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
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