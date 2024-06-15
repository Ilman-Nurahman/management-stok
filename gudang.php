<?php
require_once('config/connection.php');
require_once('config/helper.php');
require_once('config/services.php');

// Proses tambah
if (isset($_POST["prosesTambah"])) {
  try {
    // Call the function to add data
    tambahDataBarang($_POST["kodeBarang"], $_POST["namaBarang"], $_POST["totalKuantitas"], $_POST["hargaBarang"]);
    // Redirect to gudang.php if successful
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
    updateDataBarang($_POST["kodeBarang"], $_POST["namaBarang"], $_POST["totalKuantitas"], $_POST["hargaBarang"]);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
  } catch (Exception $e) {
    echo "Error: " . $e->getMessage();
  }
}

// Proses delete
if (isset($_POST["prosesDelete"])) {
  try {
    deleteDataBarang($_POST["kodeBarang"]);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
  } catch (Exception $e) {
    echo "Error: " . $e->getMessage();
  }
}

$result = displayDataBarang();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Stok Gudang - Management Stok</title>
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
        <a class="navbar-brand"><i class="bi bi-arrow-bar-left me-2"></i>Stok Barang</a>
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
        <h4 class="text-white">Stok Gudang</h4>
        <button type="button" class="btn btn-outline-light mb-2" data-bs-toggle="modal" data-bs-target="#exampleModalCreate">
          Tambah
        </button>
      </div>
    </div>
    <table class="table table-striped table-hover mt-4">
      <thead>
        <tr>
          <?php
          $headerGudang = ["No", "Kode Barang", "Nama Barang", "Total Kuantitas", "Harga Barang (pcs)", "Aksi"];
          for ($i = 0; $i < count($headerGudang); $i++) {
            echo "<th scope='col'>";
            echo $headerGudang[$i];
            echo "</th>";
          }
          ?>
        </tr>
      </thead>
      <tbody>
        <?php
        $no = 0;
        if ($result && $result->num_rows > 0) {
          while ($row = mysqli_fetch_array($result)) {
            $no++;
            echo "<tr>";
            echo "<td>" . $no . "</td>";
            echo "<td>" . $row["kode_barang"] . "</td>";
            echo "<td>" . $row["nama_barang"] . "</td>";
            echo "<td>" . $row["total_kuantitas"] . "</td>";
            echo "<td>" . formatRupiah($row["harga_barang"]) . "</td>";
            // Action buttons column
            echo "<td>";
            echo "<a class='btn btn-primary btn-sm me-2' data-bs-toggle='modal' data-bs-target='#exampleModalEdit' onclick='populateModal(\"{$row["kode_barang"]}\", \"{$row["nama_barang"]}\", {$row["total_kuantitas"]}, {$row["harga_barang"]})'><i class='bi bi-pencil'></i></a>";
            echo "<a class='btn btn-danger btn-sm me-2' data-bs-toggle='modal' data-bs-target='#deleteModal' onclick='populateDeleteModal(\"{$row["kode_barang"]}\")'><i class='bi bi-trash'></i></a>";
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
            <h5 class="modal-title" id="exampleModalLabel">Tambah Barang</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label for="kodeBarang" class="form-label">Kode Barang</label>
              <input type="text" class="form-control" name="kodeBarang" id="kodeBarang" placeholder="Masukan kode barang (contoh: B01XXX)">
            </div>
            <div class="mb-3">
              <label for="namaBarang" class="form-label">Nama Barang</label>
              <input type="text" class="form-control" id="namaBarang" name="namaBarang" placeholder="Masukkan nama barang">
            </div>
            <div class="mb-3">
              <label for="totalKuantitas" class="form-label">Total Kuantitas</label>
              <input type="number" class="form-control" id="totalKuantitas" name="totalKuantitas" placeholder="Masukkan Total Kuantitas">
            </div>
            <div class="mb-3">
              <label for="hargaBarang" class="form-label">Harga Barang</label>
              <input type="number" class="form-control" id="hargaBarang" name="hargaBarang" placeholder="jumlah barang">
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
          <h5 class="modal-title" id="exampleModalLabelEdit">Edit Barang</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="editForm" method="post" action="">
            <input type="hidden" id="editKodeBarang" name="kodeBarang">
            <div class="mb-3">
              <label for="editNamaBarang" class="form-label">Nama Barang</label>
              <input type="text" class="form-control" id="editNamaBarang" name="namaBarang">
            </div>
            <div class="mb-3">
              <label for="editTotalKuantitas" class="form-label">Total Kuantitas</label>
              <input type="number" class="form-control" id="editTotalKuantitas" name="totalKuantitas">
            </div>
            <div class="mb-3">
              <label for="editHargaBarang" class="form-label">Harga Barang</label>
              <input type="number" class="form-control" id="editHargaBarang" name="hargaBarang">
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
            <input type="hidden" name="kodeBarang" id="prosesDelete">
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Option 1: Bootstrap Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" integrity="sha384-4LISF5TTJX/fLmGSxO53rV4miRxdg84mZsxmO8Rx5jGtp/LbrixFETvWa5a6sESd" crossorigin="anonymous" />
  <script>
    function populateModal(kodeBarang, namaBarang, totalKuantitas, hargaBarang) {
      document.getElementById('editKodeBarang').value = kodeBarang;
      document.getElementById('editNamaBarang').value = namaBarang;
      document.getElementById('editTotalKuantitas').value = totalKuantitas;
      document.getElementById('editHargaBarang').value = hargaBarang;
    }

    function populateDeleteModal(kodeBarang) {
      document.getElementById('deleteItemKode').innerText = kodeBarang;
      document.getElementById('prosesDelete').setAttribute('value', kodeBarang);
    }
  </script>
</body>

</html>