<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Transaction - Management Stok</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />
  <!-- Custom CSS -->
  <link href="./css/stok.css" rel="stylesheet" />
</head>

<body>
  <!-- Sidebar -->
  <div class="sidebar">
    <div class="d-flex justify-content-center mb-4">
      <img src="./assets/Logo-Bengkel.png" width="200" alt="logo-bengkel" />
    </div>
    <ul>
    <li><a href="dashboard.php">Dashboard</a></li>
      <li><a href="gudang.php">Stok Gudang</a></li>
      <li><a href="pengelolaan-data.php">Pengelolaan Data</a></li>
      <li><a href="transaksi.php">Transaksi</a></li>
      <li><a href="user.php">User Manajemen</a></li>
      <li><a href="notification.php">Notifikasi</a></li>
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
        <h4 class="text-white">Data Transaksi</h4>
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
        <tr>
          <td>1</td>
          <td>01OLI</td>
          <td>Oli Castrol 30ml</td>
          <td>Oli</td>
          <td>200</td>
          <td>50.000</td>
          <td>24/04/2024</td>
          <td>
            <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModalEdit"">Edit</button>
                <button type=" button" class="btn btn-danger btn-sm">Delete</button>
          </td>
        </tr>
        <tr>
          <td>2</td>
          <td>02OLI</td>
          <td>Oli Castrol 450ml</td>
          <td>Oli</td>
          <td>200</td>
          <td>50.000</td>
          <td>24/04/2024</td>
          <td>
            <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModalEdit">Edit</button>
            <button type="button" class="btn btn-danger btn-sm">Delete</button>
          </td>
        </tr>

        <tr>
          <td>3</td>
          <td>03OLI</td>
          <td>Oli Yamalube 450ml</td>
          <td>Oli</td>
          <td>300</td>
          <td>50.000</td>
          <td>24/04/2024</td>
          <td>
            <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModalEdit">Edit</button>
            <button type="button" class="btn btn-danger btn-sm">Delete</button>
          </td>
        </tr>
        <!-- Add more rows as needed -->
      </tbody>
    </table>
    <!-- barang keluar -->
    <div class="card pt-2 px-3 mt-5 bg-primary">
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
        <tr>
          <td>1</td>
          <td>01OLI</td>
          <td>Oli Castrol 30ml</td>
          <td>Oli</td>
          <td>200</td>
          <td>50.000</td>
          <td>24/04/2024</td>
          <td>
            <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModalEdit">Edit</button>
            <button type="button" class="btn btn-danger btn-sm">Delete</button>
          </td>
        </tr>
        <tr>
          <td>2</td>
          <td>02OLI</td>
          <td>Oli Castrol 450ml</td>
          <td>Oli</td>
          <td>200</td>
          <td>50.000</td>
          <td>24/04/2024</td>
          <td>
            <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModalEdit">Edit</button>
            <button type="button" class="btn btn-danger btn-sm">Delete</button>
          </td>
        </tr>

        <tr>
          <td>3</td>
          <td>03OLI</td>
          <td>Oli Yamalube 450ml</td>
          <td>Oli</td>
          <td>300</td>
          <td>50.000</td>
          <td>24/04/2024</td>
          <td>
            <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModalEdit">Edit</button>
            <button type="button" class="btn btn-danger btn-sm">Delete</button>
          </td>
        </tr>
        <!-- Add more rows as needed -->
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