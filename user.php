<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>User - Management Stok</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />
    <!-- Custom CSS -->
    <link href="./css/stok.css" rel="stylesheet" />
</head>

<body>
    <?php
    require_once('config/connection.php');
    require_once('config/helper.php');
    require_once('config/services.php');

    // Proses Tambah
    if (isset($_POST["prosesTambah"])) {
        try {
            // Call the function to add data
            tambahDataPengguna($_POST["idUser"], $_POST["avatar"], $_POST["namaPengguna"], $_POST["namaLengkap"], $_POST["nomorTelepon"], $_POST["alamat"], $_POST["email"], $_POST["kataSandi"], $_POST["idRole"], $_POST["roleName"]);
            // Redirect to user.php if successful
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        } catch (Exception $e) {
            // Handle the exception
            echo "Error: " . $e->getMessage();
        }
    }

    // Proses Edit
    if (isset($_POST["prosesEdit"])) {
        try {
            updateDataPengguna($_POST["idUser"], $_POST["avatar"], $_POST["namaPengguna"], $_POST["namaLengkap"], $_POST["nomorTelepon"], $_POST["alamat"], $_POST["email"], $_POST["kataSandi"], $_POST["idRole"], $_POST["roleName"]);
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    // Proses Delete
    if (isset($_POST["prosesDelete"])) {
        try {
            deleteDataPengguna($_POST["idUser"]);
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    $result = displayDataManajemenPengguna();
    $resultRole = displayDataRole();
    ?>
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
            <li><a href="user.php">Manajemen Pengguna</a></li>
            <li><a href="notification.php">Aktivitas Pengguna</a></li>
        </ul>
    </div>

    <div class="content">
        <nav class="navbar navbar-light bg-light">
            <div class="container-fluid">
                <a class="navbar-brand"><i class="bi bi-arrow-bar-left me-2"></i>Manajemen Pengguna</a>
                <form class="d-flex">
                    <button class="btn btn-outline-primary" type="button" onclick="toLogin()">
                        <i class="bi bi-box-arrow-left me-2"></i>
                        Logout
                    </button>
                </form>
            </div>
        </nav>
        <div class="mt-4 d-flex justify-content-end">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModalCreate">
                <i class="bi bi-plus"></i>
                Tambah Pengguna
            </button>
        </div>
        <div class="row mt-4">
            <?php
            if ($result && $result->num_rows > 0) {
                while ($row = mysqli_fetch_array($result)) {
                    echo '<div class="col-12 col-md-6 col-lg-4 mb-4">';
                    echo '<div class="card" style="width: 100%;">';
                    // echo '<img src="file/' . htmlspecialchars($row["avatar"]) . '" class="card-img-top" alt="img-avatar">';
                    echo '<img src="https://fia.ub.ac.id/wp-content/uploads/2022/01/img-dummy-52-2.png" class="card-img-top" alt="img-avatar">';
                    echo '<div class="card-body">';
                    echo '<table class="table table-bordered">';
                    echo '<tbody>';
                    echo '<tr><th>Nama Lengkap</th><td>' . htmlspecialchars($row["fullname"]) . '</td></tr>';
                    echo '<tr><th>Email</th><td>' . htmlspecialchars($row["email"]) . '</td></tr>';
                    echo '<tr><th>Nomor Telepon</th><td>' . htmlspecialchars($row["no_telp"]) . '</td></tr>';
                    echo '<tr><th>Jabatan</th><td>' . htmlspecialchars($row["role_name"]) . '</td></tr>';
                    echo '<tr><th>Alamat</th><td>' . htmlspecialchars($row["address_user"]) . '</td></tr>';
                    echo '<tr><th>Aksi</th><td>';
                    echo '<a class="btn btn-primary btn-sm me-2" data-bs-toggle="modal" data-bs-target="#exampleModalEdit"><i class="bi bi-pencil"></i></a>';
                    echo '<a class="btn btn-danger btn-sm me-2" data-bs-toggle="modal" data-bs-target="#deleteModal"><i class="bi bi-trash"></i></a>';
                    echo '</td></tr>';
                    echo '</tbody>';
                    echo '</table>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo '<div class="col-12 text-center"><p>No data found</p></div>';
            }
            ?>
        </div>
    </div>
    <!-- modal create -->
    <form action="" method="post">
        <div class="modal fade" id="exampleModalCreate" tabindex="-1" aria-labelledby="exampleModalLabelCreate" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Tambah Pengguna</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="namaPengguna" class="form-label">Nama Pengguna</label>
                            <input type="text" class="form-control" name="namaPengguna" id="namaPengguna" placeholder="Masukan Nama Pengguna">
                        </div>
                        <div class="mb-3">
                            <label for="namaLengkap" class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" name="namaLengkap" id="namaLengkap" placeholder="Masukan Nama Lengkap">
                        </div>
                        <div class="mb-3">
                            <label for="nomorTelepon" class="form-label">Nomor Telepon</label>
                            <input type="text" class="form-control" name="nomorTelepon" id="nomorTelepon" placeholder="Masukan Nomor Telepon">
                        </div>
                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat</label>
                            <input type="text" class="form-control" name="alamat" id="alamat" placeholder="Masukan Alamat">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Masukkan Email">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Kata Sandi</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan Kata Sandi">
                        </div>
                        <div class="mb-3">
                            <label for="jabatan" class="form-label">Jabatan</label>
                            <select class="form-select" aria-label="Default select example" id="jabatan" name="jabatan">
                                <option selected disabled>Masukkan Jabatan</option>
                                <?php foreach ($resultRole as $role) : ?>
                                    <option value="<?php echo htmlspecialchars($role['id_role']); ?>">
                                        <?php echo htmlspecialchars($role['role_name']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="jabatan" class="form-label">Avatar</label>
                            <input class="form-control" type="file" id="formFile" name="avatar">
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
                        <input type="hidden" id="editKodeBarang" name="idUser">
                        <div class="mb-3">
                            <label for="namaPengguna" class="form-label">Nama Pengguna</label>
                            <input type="text" class="form-control" name="namaPengguna" id="namaPengguna" placeholder="Masukan Nama Pengguna">
                        </div>
                        <div class="mb-3">
                            <label for="namaLengkap" class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" name="namaLengkap" id="namaLengkap" placeholder="Masukan Nama Lengkap">
                        </div>
                        <div class="mb-3">
                            <label for="nomorTelepon" class="form-label">Nomor Telepon</label>
                            <input type="text" class="form-control" name="nomorTelepon" id="nomorTelepon" placeholder="Masukan Nomor Telepon">
                        </div>
                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat</label>
                            <input type="text" class="form-control" name="alamat" id="alamat" placeholder="Masukan Alamat">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Masukkan Email">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Kata Sandi</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan Kata Sandi">
                        </div>
                        <div class="mb-3">
                            <label for="jabatan" class="form-label">Jabatan</label>
                            <select class="form-select" aria-label="Default select example" id="jabatan" name="jabatan">
                                <option selected disabled>Masukkan Jabatan</option>
                                <?php foreach ($resultRole as $role) : ?>
                                    <option value="<?php echo htmlspecialchars($role['id_role']); ?>">
                                        <?php echo htmlspecialchars($role['role_name']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="jabatan" class="form-label">Avatar</label>
                            <input class="form-control" type="file" id="formFile" name="avatar">
                        </div>
                    </form>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">keluar</button>
                        <button type="submit" class="btn btn-primary" name="prosesTambah">Simpan</button>
                    </div>
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
                        Apakah Anda yakin ingin menghapus item dengan nama pengguna <span id="deleteItemKode"></span>?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
                        <button type="submit" class="btn btn-danger" name="prosesDelete">Hapus</button>
                        <input type="hidden" name="idUser" id="prosesDelete">
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