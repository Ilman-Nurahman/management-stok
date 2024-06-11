<?php
require_once('config/connection.php');
require_once('config/helper.php');
require_once('config/services.php');

// Proses tambah
if (isset($_POST["prosesTambah"])) {
  try {
    // Call the function to add data
    tambahDataSatuan($_POST["idSatuan"], $_POST["namaSatuan"], $_POST["inisialSatuan"]);
    tambahDataTipeBarang($_POST["kodeTipe"], $_POST["namaTipe"]);
    // Redirect to master.php if successful
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
  } catch (Exception $e) {
    // Handle the exception
    echo "Error: " . $e->getMessage();
  }
}

// Proses edit
if (isset($_POST["prosesEdit"])) {
  try {
    updateDataSatuan($_POST["idSatuan"], $_POST["namaSatuan"], $_POST["inisialSatuan"]);
    updateDataTipeBarang($_POST["kodeTipe"], $_POST["namaTipe"]);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
  } catch (Exception $e) {
    echo "Error: " . $e->getMessage();
  }
}

// Proses delete
if (isset($_POST["prosesDelete"])) {
  try {
    deleteDataSatuan($_POST["idSatuan"]);
    deleteDataTipeBarang($_POST["kodeTipe"]);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
  } catch (Exception $e) {
    echo "Error: " . $e->getMessage();
  }
}

$resultSatuan = displayDataSatuan();
$resultTipeBarang = displayDataTipeBarang();

// Merge the data
$combinedResults = [];
foreach ($resultTipeBarang as $type) {
  foreach ($resultSatuan as $satuan) {
    $combinedResults[] = array_merge($type, $satuan);
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Master Data - Management Stok</title>
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
      <li><a href="master.php">Data Master</a></li>
      <li><a href="transaksi.php">Transaksi</a></li>
      <li><a href="user.php">User Manajemen</a></li>
      <li><a href="notification.php">Notifikasi</a></li>
    </ul>
  </div>

  <div class="content">
    <nav class="navbar navbar-light bg-light">
      <div class="container-fluid">
        <a class="navbar-brand"><i class="bi bi-arrow-bar-left me-2"></i>Master Data</a>
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
        <h4 class="text-white">Tipe dan Satuan Barang</h4>
        <button type="button" class="btn btn-outline-light mb-2" data-bs-toggle="modal" data-bs-target="#exampleModalCreate">
          Tambah
        </button>
      </div>
    </div>
    <table class="table table-striped table-hover mt-4">
      <thead>
        <tr>
          <?php
          $headerMaster = ["No", "Kode Tipe", "Nama Tipe", "Nama Satuan", "Inisial Satuan", "Aksi"];
          foreach ($headerMaster as $header) {
            echo "<th scope='col'>{$header}</th>";
          }
          ?>
        </tr>
      </thead>
      <tbody>
        <?php
        $no = 0;
        if (count($combinedResults) > 0) {
          foreach ($combinedResults as $row) {
            $no++;
            echo "<tr>";
            echo "<td>" . $no . "</td>";
            echo "<td>" . $row["kode_tipe"] . "</td>";
            echo "<td>" . $row["nama_tipe"] . "</td>";
            echo "<td>" . $row["nama_satuan"] . "</td>";
            echo "<td>" . $row["inisial_satuan"] . "</td>";
            // Action buttons column
            echo "<td>";
            echo "<a class='btn btn-primary btn-sm me-2' data-bs-toggle='modal' data-bs-target='#exampleModalEdit' onclick='populateModal(\"{$row["kode_tipe"]}\", \"{$row["id_satuan"]}\", \"{$row["nama_tipe"]}\", \"{$row["nama_satuan"]}\", \"{$row["inisial_satuan"]}\")'><i class='bi bi-pencil'></i></a>";
            echo "<a class='btn btn-danger btn-sm me-2' data-bs-toggle='modal' data-bs-target='#deleteModal' onclick='populateDeleteModal(\"{$row["kode_tipe"]}\", \"{$row["id_satuan"]}\")'><i class='bi bi-trash'></i></a>";
            echo "</td>";
            echo "</tr>";
          }
        } else {
          echo "<tr class='text-center'><td colspan='6'>No data found</td></tr>";
        }
        ?>
      </tbody>
    </table>
  </div>
  <!-- modal create -->
  <form action="" method="post">
    <div class="modal fade" id="exampleModalCreate" tabindex="-1" aria-labelledby="exampleModalLabelCreate" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Tambah Data</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label for="kodeTipe" class="form-label">Kode Tipe</label>
              <input type="text" class="form-control" name="kodeTipe" id="kodeTipe" placeholder="Masukkan kode tipe (contoh: T01XXX)">
            </div>
            <div class="mb-3">
              <label for="namaTipe" class="form-label">Nama Tipe</label>
              <input type="text" class="form-control" id="namaTipe" name="namaTipe" placeholder="Masukkan nama tipe">
            </div>
            <div class="mb-3">
              <label for="namaSatuan" class="form-label">Nama Satuan</label>
              <input type="text" class="form-control" id="namaSatuan" name="namaSatuan" placeholder="Masukkan nama satuan">
            </div>
            <div class="mb-3">
              <label for="inisialSatuan" class="form-label">Inisial Satuan</label>
              <input type="text" class="form-control" id="inisialSatuan" name="inisialSatuan" placeholder="Masukkan inisial satuan">
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">keluar</button>
            <button type="submit" class="btn btn-primary" name="prosesTambah">Simpan</button>
          </div>
        </div>
      </div>
    </div>
  </form>

  <!-- modal edit -->
  <div class="modal fade" id="exampleModalEdit" tabindex="-1" aria-labelledby="exampleModalLabelEdit" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabelEdit">Edit Data</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="editForm" method="post" action="">
            <input type="hidden" id="editKodeTipe" name="kodeTipe">
            <div class="mb-3">
              <label for="editNamaTipe" class="form-label">Nama Tipe</label>
              <input type="text" class="form-control" id="editNamaTipe" name="namaTipe">
            </div>
            <div class="mb-3">
              <label for="editNamaSatuan" class="form-label">Nama Satuan</label>
              <input type="text" class="form-control" id="editNamaSatuan" name="namaSatuan">
            </div>
            <div class="mb-3">
              <label for="editInisialSatuan" class="form-label">Inisial Satuan</label>
              <input type="text" class="form-control" id="editInisialSatuan" name="inisialSatuan">
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Keluar</button>
              <button type="submit" class="btn btn-primary" name="prosesEdit">Simpan</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal delete-->
  <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <form id="deleteForm" method="post" action="">
          <div class="modal-header">
            <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            Apakah Anda yakin ingin menghapus item dengan kode <span id="deleteItemKode"></span>?
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
            <button type="submit" class="btn btn-danger" name="prosesDelete">Hapus</button>
            <input type="hidden" name="kodeTipe" id="prosesDelete">
          </div>
        </form>
      </div>
    </div>
  </div>
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