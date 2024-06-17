<?php
require_once('config/connection.php');
require_once('config/helper.php');
require_once('config/services.php');

$result = displayDataAktivitasPengguna();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Notification - Management Stok</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />
  <!-- Custom CSS -->
  <link href="./css/notifikasi.css" rel="stylesheet" />
</head>

<body>
  <!-- Sidebar -->
  <div class="sidebar">
    <div class="d-flex justify-content-center mb-4">
      <img src="./assets/Logo-Bengkel.png" width="200" alt="logo-bengkel" />
    </div>
    <ul>
      <li><a href="dashboard.php">Dashboard</a></li>
      <li><a href="stok-gudang.php">Stok Gudang</a></li>
      <li><a href="pengelolaan-data.php">Pengelolaan Data</a></li>
      <li><a href="transaksi.php">Transaksi</a></li>
      <li><a href="user.php">Manajemen Pengguna</a></li>
      <li><a href="notification.php">Aktivitas Pengguna</a></li>
    </ul>
  </div>

  <div class="content">
    <nav class="navbar navbar-light bg-light">
      <div class="container-fluid">
        <a class="navbar-brand"><i class="bi bi-arrow-bar-left me-2"></i>Aktivitas Pengguna</a>
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
        <h4 class="text-white">Aktivitas Pengguna</h4>
      </div>
    </div>
    <table class="table table-striped table-hover mt-4">
      <thead>
        <tr>
          <?php
          $headerAktivitas = ["No", "Nama Pengguna", "Tanggal", "Deskripsi"];
          for ($i = 0; $i < count($headerAktivitas); $i++) {
            echo "<th scope='col'>";
            echo $headerAktivitas[$i];
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
            echo "<td>" . $row["fullname"] . "</td>";
            echo "<td>" . $row["created_at"] . "</td>";
            echo "<td>" . $row["description"] . "</td>";
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
  <!-- Option 1: Bootstrap Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" integrity="sha384-4LISF5TTJX/fLmGSxO53rV4miRxdg84mZsxmO8Rx5jGtp/LbrixFETvWa5a6sESd" crossorigin="anonymous" />
  <script>
    // JavaScript code to handle button click
  </script>
</body>

</html>