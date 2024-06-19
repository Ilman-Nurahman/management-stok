<?php
require_once('config/connection.php');

// ================ MENU DASHBOARD ================ \\
function displayTotalKuantitas()
{
    global $conn;
    try {
        // Query untuk menjumlahkan total_kuantitas
        $queryGet = 'SELECT SUM(total_kuantitas) as total_kuantitas FROM stok_gudang';
        $stmt = mysqli_prepare($conn, $queryGet);
        if ($stmt === false) {
            throw new Error('Statement preparation failed: ' . mysqli_error($conn));
        }

        $result = mysqli_stmt_execute($stmt);
        if ($result === false) {
            throw new Error('Statement execution failed: ' . mysqli_stmt_error($stmt));
        }

        $result = mysqli_stmt_get_result($stmt);
        if ($result === false) {
            throw new Error('Getting result set failed: ' . mysqli_stmt_error($stmt));
        }

        $row = mysqli_fetch_assoc($result);
        mysqli_stmt_close($stmt);

        return $row['total_kuantitas'];
    } catch (Error $e) {
        echo "Caught error: " . $e->getMessage();
    }
}

function displayTotalOmset()
{
    global $conn;
    try {
        // Query untuk menjumlahkan total_kuantitas
        $queryGet = 'SELECT SUM(total_harga) as total_harga FROM barang_keluar';
        $stmt = mysqli_prepare($conn, $queryGet);
        if ($stmt === false) {
            throw new Error('Statement preparation failed: ' . mysqli_error($conn));
        }

        $result = mysqli_stmt_execute($stmt);
        if ($result === false) {
            throw new Error('Statement execution failed: ' . mysqli_stmt_error($stmt));
        }

        $result = mysqli_stmt_get_result($stmt);
        if ($result === false) {
            throw new Error('Getting result set failed: ' . mysqli_stmt_error($stmt));
        }

        $row = mysqli_fetch_assoc($result);
        mysqli_stmt_close($stmt);

        return $row['total_harga'];
    } catch (Error $e) {
        echo "Caught error: " . $e->getMessage();
    }
}

function displayTotalBarangTerjual()
{
    global $conn;
    try {
        // Query untuk menjumlahkan total_kuantitas
        $queryGet = 'SELECT SUM(kuantitas) as kuantitas FROM barang_keluar';
        $stmt = mysqli_prepare($conn, $queryGet);
        if ($stmt === false) {
            throw new Error('Statement preparation failed: ' . mysqli_error($conn));
        }

        $result = mysqli_stmt_execute($stmt);
        if ($result === false) {
            throw new Error('Statement execution failed: ' . mysqli_stmt_error($stmt));
        }

        $result = mysqli_stmt_get_result($stmt);
        if ($result === false) {
            throw new Error('Getting result set failed: ' . mysqli_stmt_error($stmt));
        }

        $row = mysqli_fetch_assoc($result);
        mysqli_stmt_close($stmt);

        return $row['kuantitas'];
    } catch (Error $e) {
        echo "Caught error: " . $e->getMessage();
    }
}

// ================ MENU GUDANG ================ \\

function displayDataStokGudang()
{
    global $conn;
    try {
        $queryGet = 'SELECT * FROM stok_gudang';
        $stmt = mysqli_prepare($conn, $queryGet);
        if ($stmt === false) {
            throw new Error('Statement preparation failed: ' . mysqli_error($conn));
        }

        $result = mysqli_stmt_execute($stmt);
        if ($result === false) {
            throw new Error('Statement execution failed: ' . mysqli_stmt_error($stmt));
        }

        $result = mysqli_stmt_get_result($stmt);
        if ($result === false) {
            throw new Error('Getting result set failed: ' . mysqli_stmt_error($stmt));
        }

        mysqli_stmt_close($stmt);
        return $result;
    } catch (Error $e) {
        echo "Caught error: " . $e->getMessage();
    }
}

function tambahDataStokGudang($idStok, $kodeTipe, $idSatuan, $pilihBarang, $kuantitas, $harga, $total, $createdAt, $updateAt)
{
    global $conn;
    try {
        // Query to get nama_tipe from tipe_barang table
        $queryTipe = "SELECT nama_tipe FROM tipe_barang WHERE kode_tipe = ?";
        $stmtTipe = mysqli_prepare($conn, $queryTipe);
        mysqli_stmt_bind_param($stmtTipe, 's', $kodeTipe);
        mysqli_stmt_execute($stmtTipe);
        mysqli_stmt_bind_result($stmtTipe, $namaTipe);
        mysqli_stmt_fetch($stmtTipe);
        mysqli_stmt_close($stmtTipe);

        // Query to get nama_satuan and inisial_satuan from satuan table
        $querySatuan = "SELECT nama_satuan, inisial_satuan FROM satuan WHERE id_satuan = ?";
        $stmtSatuan = mysqli_prepare($conn, $querySatuan);
        mysqli_stmt_bind_param($stmtSatuan, 's', $idSatuan);
        mysqli_stmt_execute($stmtSatuan);
        mysqli_stmt_bind_result($stmtSatuan, $namaSatuan, $inisialSatuan);
        mysqli_stmt_fetch($stmtSatuan);
        mysqli_stmt_close($stmtSatuan);

        // Query to get nama_barang from barang table
        $queryBarang = "SELECT nama_barang FROM barang WHERE kode_barang = ?";
        $stmtBarang = mysqli_prepare($conn, $queryBarang);
        mysqli_stmt_bind_param($stmtBarang, 's', $pilihBarang);
        mysqli_stmt_execute($stmtBarang);
        mysqli_stmt_bind_result($stmtBarang, $namaBarang);
        mysqli_stmt_fetch($stmtBarang);
        mysqli_stmt_close($stmtBarang);

        // Insert data into stok_gudang table
        $queryInsert = "INSERT INTO stok_gudang (id_stok, kode_tipe, nama_tipe, id_satuan, nama_satuan, inisial_satuan, kode_barang, nama_barang, total_kuantitas, harga_barang, total_harga, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmtInsert = mysqli_prepare($conn, $queryInsert);
        mysqli_stmt_bind_param($stmtInsert, 'ssssssssiisss', $idStok, $kodeTipe, $namaTipe, $idSatuan, $namaSatuan, $inisialSatuan, $pilihBarang, $namaBarang, $kuantitas, $harga, $total, $createdAt, $updateAt);
        mysqli_stmt_execute($stmtInsert);
        mysqli_stmt_close($stmtInsert);
    } catch (Exception $e) {
        throw new Exception('Error inserting data: ' . $e->getMessage());
    }
}

function updateDataStokGudang($idStok, $kodeTipe, $idSatuan, $pilihBarang, $kuantitas, $harga, $total, $createdAt, $updateAt)
{
    global $conn;
    try {
        // Query to get nama_tipe from tipe_barang table
        $queryTipe = "SELECT nama_tipe FROM tipe_barang WHERE kode_tipe = ?";
        $stmtTipe = mysqli_prepare($conn, $queryTipe);
        mysqli_stmt_bind_param($stmtTipe, 's', $kodeTipe);
        mysqli_stmt_execute($stmtTipe);
        mysqli_stmt_bind_result($stmtTipe, $namaTipe);
        mysqli_stmt_fetch($stmtTipe);
        mysqli_stmt_close($stmtTipe);

        // Query to get nama_satuan and inisial_satuan from satuan table
        $querySatuan = "SELECT nama_satuan, inisial_satuan FROM satuan WHERE id_satuan = ?";
        $stmtSatuan = mysqli_prepare($conn, $querySatuan);
        mysqli_stmt_bind_param($stmtSatuan, 's', $idSatuan);
        mysqli_stmt_execute($stmtSatuan);
        mysqli_stmt_bind_result($stmtSatuan, $namaSatuan, $inisialSatuan);
        mysqli_stmt_fetch($stmtSatuan);
        mysqli_stmt_close($stmtSatuan);

        // Query to get nama_barang from barang table
        $queryBarang = "SELECT nama_barang FROM barang WHERE kode_barang = ?";
        $stmtBarang = mysqli_prepare($conn, $queryBarang);
        mysqli_stmt_bind_param($stmtBarang, 's', $pilihBarang);
        mysqli_stmt_execute($stmtBarang);
        mysqli_stmt_bind_result($stmtBarang, $namaBarang);
        mysqli_stmt_fetch($stmtBarang);
        mysqli_stmt_close($stmtBarang);

        $queryUpdate = "UPDATE stok_gudang SET kode_barang = ?, nama_barang = ?, id_satuan = ?, nama_satuan = ?, inisial_satuan = ?, kode_tipe = ?, nama_tipe = ?, total_kuantitas = ?, harga_barang = ?, total_harga = ?, created_at = ?, updated_at = ? WHERE id_stok = ?";
        $stmt = mysqli_prepare($conn, $queryUpdate);
        mysqli_stmt_bind_param($stmt, 'ssissssiiisss', $pilihBarang, $namaBarang, $idSatuan, $namaSatuan, $inisialSatuan, $kodeTipe, $namaTipe, $kuantitas, $harga, $total, $createdAt, $updateAt, $idStok);
        $resultUpdate = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        return $resultUpdate;
    } catch (Error $e) {
        echo "Caught error: " . $e->getMessage();
    }
}

function deleteDataStokGudang($idStok)
{
    global $conn;
    try {
        $queryDelete = "DELETE FROM stok_gudang WHERE id_stok = ?";
        $stmt = mysqli_prepare($conn, $queryDelete);
        mysqli_stmt_bind_param($stmt, 's', $idStok);
        $resultDelete = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        return $resultDelete;
    } catch (Error $e) {
        echo "Caught error: " . $e->getMessage();
    }
}

// ================ MENU PENGELOLAAN DATA ================ \\

function displayDataBarang()
{
    global $conn;
    try {
        $queryGet = 'SELECT * FROM barang';
        $stmt = mysqli_prepare($conn, $queryGet);
        if ($stmt === false) {
            throw new Error('Statement preparation failed: ' . mysqli_error($conn));
        }

        $result = mysqli_stmt_execute($stmt);
        if ($result === false) {
            throw new Error('Statement execution failed: ' . mysqli_stmt_error($stmt));
        }

        $result = mysqli_stmt_get_result($stmt);
        if ($result === false) {
            throw new Error('Getting result set failed: ' . mysqli_stmt_error($stmt));
        }

        mysqli_stmt_close($stmt);
        return $result;
    } catch (Error $e) {
        echo "Caught error: " . $e->getMessage();
    }
}

function displayDataSatuan()
{
    global $conn;
    try {
        $queryGet = 'SELECT * FROM satuan';
        $stmt = mysqli_prepare($conn, $queryGet);
        if ($stmt === false) {
            throw new Error('Statement preparation failed: ' . mysqli_error($conn));
        }

        $result = mysqli_stmt_execute($stmt);
        if ($result === false) {
            throw new Error('Statement execution failed: ' . mysqli_stmt_error($stmt));
        }

        $result = mysqli_stmt_get_result($stmt);
        if ($result === false) {
            throw new Error('Getting result set failed: ' . mysqli_stmt_error($stmt));
        }

        mysqli_stmt_close($stmt);
        return $result;
    } catch (Error $e) {
        echo "Caught error: " . $e->getMessage();
    }
}

function displayDataTipeBarang()
{
    global $conn;
    try {
        $queryGet = 'SELECT * FROM tipe_barang';
        $stmt = mysqli_prepare($conn, $queryGet);
        if ($stmt === false) {
            throw new Error('Statement preparation failed: ' . mysqli_error($conn));
        }

        $result = mysqli_stmt_execute($stmt);
        if ($result === false) {
            throw new Error('Statement execution failed: ' . mysqli_stmt_error($stmt));
        }

        $result = mysqli_stmt_get_result($stmt);
        if ($result === false) {
            throw new Error('Getting result set failed: ' . mysqli_stmt_error($stmt));
        }

        mysqli_stmt_close($stmt);
        return $result;
    } catch (Error $e) {
        echo "Caught error: " . $e->getMessage();
    }
}

function tambahDataBarang($kodeBarang, $namaBarang, $kodeTipe, $idSatuan, $hargaBarang)
{
    global $conn;
    try {
        $queryInsert = "INSERT INTO barang (kode_barang, nama_barang, kode_tipe, id_satuan, harga_barang) VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $queryInsert);
        if ($stmt === false) {
            throw new Exception('Statement preparation failed: ' . mysqli_error($conn));
        }

        mysqli_stmt_bind_param($stmt, 'sssss', $kodeBarang, $namaBarang, $kodeTipe, $idSatuan, $hargaBarang);
        $resultInsert = mysqli_stmt_execute($stmt);
        if ($resultInsert === false) {
            throw new Exception('Statement execution failed: ' . mysqli_stmt_error($stmt));
        }

        mysqli_stmt_close($stmt);
        return $resultInsert;
    } catch (Exception $e) {
        echo "Caught exception: " . $e->getMessage();
    }
}

function tambahDataSatuan($idSatuan, $namaSatuan, $inisialSatuan)
{
    global $conn;
    try {
        $queryInsert = "INSERT INTO satuan (id_satuan, nama_satuan, inisial_satuan) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($conn, $queryInsert);
        if ($stmt === false) {
            throw new Exception('Statement preparation failed: ' . mysqli_error($conn));
        }

        mysqli_stmt_bind_param($stmt, 'sss', $idSatuan, $namaSatuan, $inisialSatuan);
        $resultInsert = mysqli_stmt_execute($stmt);
        if ($resultInsert === false) {
            throw new Exception('Statement execution failed: ' . mysqli_stmt_error($stmt));
        }

        mysqli_stmt_close($stmt);
        return $resultInsert;
    } catch (Exception $e) {
        echo "Caught exception: " . $e->getMessage();
    }
}

function tambahDataTipeBarang($kodeTipe, $namaTipe)
{
    global $conn;
    try {
        $queryInsert = "INSERT INTO tipe_barang (kode_tipe, nama_tipe) VALUES (?, ?)";
        $stmt = mysqli_prepare($conn, $queryInsert);
        if ($stmt === false) {
            throw new Error('Statement preparation failed: ' . mysqli_error($conn));
        }

        mysqli_stmt_bind_param($stmt, 'ss', $kodeTipe, $namaTipe);
        $resultInsert = mysqli_stmt_execute($stmt);
        if ($resultInsert === false) {
            throw new Error('Statement execution failed: ' . mysqli_stmt_error($stmt));
        }

        mysqli_stmt_close($stmt);
        return $resultInsert;
    } catch (Error $e) {
        echo "Caught error: " . $e->getMessage();
    }
}

function updateDataBarang($originalKodeBarang, $newKodeBarang, $namaBarang, $kodeTipe, $idSatuan, $hargaBarang)
{
    global $conn;
    try {
        $queryUpdate = "UPDATE barang SET kode_barang = ?, nama_barang = ?, kode_tipe = ?, id_satuan = ?, harga_barang = ? WHERE kode_barang = ?";
        $stmt = mysqli_prepare($conn, $queryUpdate);
        if ($stmt === false) {
            throw new Exception('Statement preparation failed: ' . mysqli_error($conn));
        }

        // Correct the parameter order to match the query
        mysqli_stmt_bind_param($stmt, 'ssssds', $newKodeBarang, $namaBarang, $kodeTipe, $idSatuan, $hargaBarang, $originalKodeBarang);
        $resultUpdate = mysqli_stmt_execute($stmt);
        if ($resultUpdate === false) {
            throw new Exception('Statement execution failed: ' . mysqli_stmt_error($stmt));
        }

        mysqli_stmt_close($stmt);
        return $resultUpdate;
    } catch (Exception $e) {
        echo "Caught exception: " . $e->getMessage();
    }
}

function updateDataSatuan($idSatuan, $namaSatuan, $inisialSatuan)
{
    global $conn;
    try {
        $queryUpdate = "UPDATE satuan SET nama_satuan = ?, inisial_satuan = ? WHERE id_satuan = ?";
        $stmt = mysqli_prepare($conn, $queryUpdate);
        if ($stmt === false) {
            throw new Exception('Statement preparation failed: ' . mysqli_error($conn));
        }

        mysqli_stmt_bind_param($stmt, 'sss', $namaSatuan, $inisialSatuan, $idSatuan);
        $resultUpdate = mysqli_stmt_execute($stmt);
        if ($resultUpdate === false) {
            throw new Exception('Statement execution failed: ' . mysqli_stmt_error($stmt));
        }

        mysqli_stmt_close($stmt);
        return $resultUpdate;
    } catch (Exception $e) {
        echo "Caught exception: " . $e->getMessage();
    }
}

function updateDataTipeBarang($originalKodeTipe, $newKodeTipe, $namaTipe)
{
    global $conn;
    try {
        $queryUpdate = "UPDATE tipe_barang SET kode_tipe = ?, nama_tipe = ? WHERE kode_tipe = ?";
        $stmt = mysqli_prepare($conn, $queryUpdate);
        if ($stmt === false) {
            throw new Exception('Statement preparation failed: ' . mysqli_error($conn));
        }

        mysqli_stmt_bind_param($stmt, 'sss', $newKodeTipe, $namaTipe, $originalKodeTipe);
        $resultUpdate = mysqli_stmt_execute($stmt);
        if ($resultUpdate === false) {
            throw new Exception('Statement execution failed: ' . mysqli_stmt_error($stmt));
        }

        mysqli_stmt_close($stmt);
        return $resultUpdate;
    } catch (Exception $e) {
        echo "Caught exception: " . $e->getMessage();
    }
}

function deleteDatabarang($kodeBarang)
{
    global $conn;
    try {
        $queryDeleteBarang = "DELETE FROM barang WHERE kode_barang = ?";
        $stmt = mysqli_prepare($conn, $queryDeleteBarang);
        mysqli_stmt_bind_param($stmt, 's', $kodeBarang);
        $resultDelete = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        return $resultDelete;
    } catch (Error $e) {
        echo "Caught error: " . $e->getMessage();
    }
}

function deleteDataSatuan($idSatuan)
{
    global $conn;
    try {
        $queryDeleteSatuan = "DELETE FROM satuan WHERE id_satuan = ?";
        $stmt = mysqli_prepare($conn, $queryDeleteSatuan);
        mysqli_stmt_bind_param($stmt, 's', $idSatuan);
        $resultDelete = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        return $resultDelete;
    } catch (Error $e) {
        echo "Caught error: " . $e->getMessage();
    }
}

function deleteDataTipeBarang($kodeTipe)
{
    global $conn;
    try {
        $queryDeleteTipe = "DELETE FROM tipe_barang WHERE kode_tipe = ?";
        $stmt = mysqli_prepare($conn, $queryDeleteTipe);
        mysqli_stmt_bind_param($stmt, 's', $kodeTipe);
        $resultDelete = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        return $resultDelete;
    } catch (Error $e) {
        echo "Caught error: " . $e->getMessage();
    }
}

// ================ MENU CATATAN TRANSAKSI ================ \\
function displayDataBarangKeluar()
{
    global $conn;
    try {
        $queryGet = 'SELECT * FROM barang_keluar';
        $stmt = mysqli_prepare($conn, $queryGet);
        if ($stmt === false) {
            throw new Error('Statement preparation failed: ' . mysqli_error($conn));
        }

        $result = mysqli_stmt_execute($stmt);
        if ($result === false) {
            throw new Error('Statement execution failed: ' . mysqli_stmt_error($stmt));
        }

        $result = mysqli_stmt_get_result($stmt);
        if ($result === false) {
            throw new Error('Getting result set failed: ' . mysqli_stmt_error($stmt));
        }

        mysqli_stmt_close($stmt);
        return $result;
    } catch (Error $e) {
        echo "Caught error: " . $e->getMessage();
    }
}

function tambahDataBarangKeluar($idBarangKeluar, $pilihBarang, $kodeTipe, $idSatuan, $harga, $kuantitas, $total, $keterangan, $namaPelanggan, $noHp, $tipeKendaraan, $noKendaraan, $iduser, $createdAt, $updatedAt)
{
    global $conn;
    try {
        // Query to check if id_barang_keluar already exists
        $queryCheck = "SELECT id_barang_keluar FROM barang_keluar WHERE id_barang_keluar = ?";
        $stmtCheck = mysqli_prepare($conn, $queryCheck);
        mysqli_stmt_bind_param($stmtCheck, 's', $idBarangKeluar);
        mysqli_stmt_execute($stmtCheck);
        mysqli_stmt_store_result($stmtCheck);

        if (mysqli_stmt_num_rows($stmtCheck) > 0) {
            throw new Exception('Error: id_barang_keluar ' . $idBarangKeluar . ' already exists.');
        }

        mysqli_stmt_close($stmtCheck);

        // Query to get nama_barang from barang table
        $queryBarang = "SELECT nama_barang FROM barang WHERE kode_barang = ?";
        $stmtBarang = mysqli_prepare($conn, $queryBarang);
        mysqli_stmt_bind_param($stmtBarang, 's', $pilihBarang);
        mysqli_stmt_execute($stmtBarang);
        mysqli_stmt_bind_result($stmtBarang, $namaBarang);
        mysqli_stmt_fetch($stmtBarang);
        mysqli_stmt_close($stmtBarang);

        // Check if $namaBarang is NULL and handle it
        if ($namaBarang === NULL) {
            throw new Exception('Error: Barang with kode ' . $pilihBarang . ' not found.');
        }

        // Query to get nama_tipe from tipe_barang table
        $queryTipe = "SELECT nama_tipe FROM tipe_barang WHERE kode_tipe = ?";
        $stmtTipe = mysqli_prepare($conn, $queryTipe);
        mysqli_stmt_bind_param($stmtTipe, 's', $kodeTipe);
        mysqli_stmt_execute($stmtTipe);
        mysqli_stmt_bind_result($stmtTipe, $namaTipe);
        mysqli_stmt_fetch($stmtTipe);

        // Check if $namaTipe is NULL and handle it
        if ($namaTipe === NULL) {
            throw new Exception('Error: Tipe with kode ' . $kodeTipe . ' not found.');
        }

        mysqli_stmt_close($stmtTipe);

        // Query to get nama_satuan and inisial_satuan from satuan table
        $querySatuan = "SELECT nama_satuan, inisial_satuan FROM satuan WHERE id_satuan = ?";
        $stmtSatuan = mysqli_prepare($conn, $querySatuan);
        mysqli_stmt_bind_param($stmtSatuan, 's', $idSatuan);
        mysqli_stmt_execute($stmtSatuan);
        mysqli_stmt_bind_result($stmtSatuan, $namaSatuan, $inisialSatuan);
        mysqli_stmt_fetch($stmtSatuan);

        // Check if $namaSatuan or $inisialSatuan is NULL and handle it
        if ($namaSatuan === NULL || $inisialSatuan === NULL) {
            throw new Exception('Error: Satuan with ID ' . $idSatuan . ' not found or missing inisial_satuan.');
        }

        mysqli_stmt_close($stmtSatuan);

        // Query to get username from user table
        $queryUser = "SELECT username FROM user WHERE id_user = ?";
        $stmtUser = mysqli_prepare($conn, $queryUser);
        mysqli_stmt_bind_param($stmtUser, 's', $iduser);
        mysqli_stmt_execute($stmtUser);
        mysqli_stmt_bind_result($stmtUser, $username);
        mysqli_stmt_fetch($stmtUser);

        // Check if $username is NULL and handle it
        if ($username === NULL) {
            throw new Exception('Error: Username for user with ID ' . $iduser . ' not found.');
        }

        mysqli_stmt_close($stmtUser);

        // Insert data into barang_keluar table
        $queryInsert = "INSERT INTO barang_keluar (id_barang_keluar, kode_barang, nama_barang, kode_tipe, nama_tipe, id_satuan, nama_satuan, inisial_satuan, harga_barang, kuantitas, total_harga, keterangan, nama_pelanggan, no_hp, tipe_kendaraan, no_kendaraan, id_user, username, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmtInsert = mysqli_prepare($conn, $queryInsert);

        if (!$stmtInsert) {
            throw new Exception('Error preparing statement: ' . mysqli_error($conn));
        }

        mysqli_stmt_bind_param($stmtInsert, 'ssssssssisisssssssss', $idBarangKeluar, $pilihBarang, $namaBarang, $kodeTipe, $namaTipe, $idSatuan, $namaSatuan, $inisialSatuan, $harga, $kuantitas, $total, $keterangan, $namaPelanggan, $noHp, $tipeKendaraan, $noKendaraan, $iduser, $username, $createdAt, $updatedAt);

        if (!mysqli_stmt_execute($stmtInsert)) {
            throw new Exception('Error executing statement: ' . mysqli_stmt_error($stmtInsert));
        }

        mysqli_stmt_close($stmtInsert);
    } catch (Exception $e) {
        throw new Exception('Error inserting data: ' . $e->getMessage());
    }
}

function deleteDataBarangKeluar($idBarangKeluar)
{
    global $conn;
    try {
        $queryDeleteBarangKeluar = "DELETE FROM barang_keluar WHERE id_barang_keluar = ?";
        $stmt = mysqli_prepare($conn, $queryDeleteBarangKeluar);
        mysqli_stmt_bind_param($stmt, 's', $idBarangKeluar);
        $resultDelete = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        return $resultDelete;
    } catch (Error $e) {
        echo "Caught error: " . $e->getMessage();
    }
}

// ================ MENU MANAGEMEN PENGGUNA ================ \\

// Function to authenticate user
function authenticateUser($email, $password)
{
    global $conn;
    try {
        // Prepare the SQL statement
        $query = 'SELECT * FROM user WHERE email = ?';
        $stmt = mysqli_prepare($conn, $query);
        if ($stmt === false) {
            throw new Error('Statement preparation failed: ' . mysqli_error($conn));
        }

        // Bind the email parameter
        mysqli_stmt_bind_param($stmt, 's', $email);

        // Execute the statement
        $result = mysqli_stmt_execute($stmt);
        if ($result === false) {
            throw new Error('Statement execution failed: ' . mysqli_stmt_error($stmt));
        }

        // Get the result
        $result = mysqli_stmt_get_result($stmt);
        if ($result === false) {
            throw new Error('Getting result set failed: ' . mysqli_stmt_error($stmt));
        }

        // Fetch the user data
        $user = mysqli_fetch_assoc($result);

        // Close the statement
        mysqli_stmt_close($stmt);

        // If user is found, verify the password
        if ($user && password_verify($password, $user['password_user'])) {
            return true;
        }

        return false;
    } catch (Error $e) {
        echo "Caught error: " . $e->getMessage();
    }
    return false;
}

// Function to verify token
function verifyToken($token)
{
    global $conn;
    $query = 'SELECT * FROM user WHERE token = ?';
    $stmt = mysqli_prepare($conn, $query);
    if ($stmt === false) {
        throw new Error('Statement preparation failed: ' . mysqli_error($conn));
    }
    mysqli_stmt_bind_param($stmt, 's', $token);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
    return $user ? true : false;
}

function getUserByToken($token)
{
    global $conn;
    $query = 'SELECT * FROM user WHERE token = ?';
    $stmt = mysqli_prepare($conn, $query);
    if ($stmt === false) {
        throw new Error('Statement preparation failed: ' . mysqli_error($conn));
    }
    mysqli_stmt_bind_param($stmt, 's', $token);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
    return $user;
}

function displayDataManajemenPengguna()
{
    global $conn;
    try {
        $queryGet = 'SELECT * FROM user';
        $stmt = mysqli_prepare($conn, $queryGet);
        if ($stmt === false) {
            throw new Error('Statement preparation failed: ' . mysqli_error($conn));
        }

        $result = mysqli_stmt_execute($stmt);
        if ($result === false) {
            throw new Error('Statement execution failed: ' . mysqli_stmt_error($stmt));
        }

        $result = mysqli_stmt_get_result($stmt);
        if ($result === false) {
            throw new Error('Getting result set failed: ' . mysqli_stmt_error($stmt));
        }

        mysqli_stmt_close($stmt);
        return $result;
    } catch (Error $e) {
        echo "Caught error: " . $e->getMessage();
    }
}

function displayDataRole()
{
    global $conn;
    try {
        $queryGet = 'SELECT * FROM role';
        $stmt = mysqli_prepare($conn, $queryGet);
        if ($stmt === false) {
            throw new Error('Statement preparation failed: ' . mysqli_error($conn));
        }

        $result = mysqli_stmt_execute($stmt);
        if ($result === false) {
            throw new Error('Statement execution failed: ' . mysqli_stmt_error($stmt));
        }

        $result = mysqli_stmt_get_result($stmt);
        if ($result === false) {
            throw new Error('Getting result set failed: ' . mysqli_stmt_error($stmt));
        }

        mysqli_stmt_close($stmt);
        return $result;
    } catch (Error $e) {
        echo "Caught error: " . $e->getMessage();
    }
}

function tambahDataPengguna($idUser, $avatarPath, $namaPengguna, $namaLengkap, $nomorTelepon, $alamat, $email, $kataSandi, $idRole, $roleName, $createdAt)
{
    global $conn;
    try {
        $queryInsert = "INSERT INTO user (id_user, avatar, username, fullname, no_telp, address_user, email, password_user, id_role, role_name, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $queryInsert);
        if ($stmt === false) {
            throw new Error('Statement preparation failed: ' . mysqli_error($conn));
        }

        // Adjusting the data types for each parameter
        // 's' for strings (all the fields are treated as strings here, including IDs)
        mysqli_stmt_bind_param($stmt, 'ssssssssiss', $idUser, $avatarPath, $namaPengguna, $namaLengkap, $nomorTelepon, $alamat, $email, $kataSandi, $idRole, $roleName, $createdAt);

        $resultInsert = mysqli_stmt_execute($stmt);
        if ($resultInsert === false) {
            throw new Error('Statement execution failed: ' . mysqli_stmt_error($stmt));
        }

        mysqli_stmt_close($stmt);
        return $resultInsert;
    } catch (Error $e) {
        echo "Caught error: " . $e->getMessage();
    }
}


function updateDataPengguna($idUser, $avatarPath, $namaPengguna, $namaLengkap, $nomorTelepon, $alamat, $email, $idRole, $roleName, $createdAt, $hashedPassword)
{
    global $conn;
    try {
        $queryUpdate = "UPDATE user SET avatar = ?, username = ?, fullname = ?, no_telp = ?, address_user = ?, email = ?, id_role = ?, role_name = ?, created_at = ?";

        // Check if the password is provided
        if (!empty($hashedPassword)) {
            $queryUpdate .= ", password_user = ?";
        }

        $queryUpdate .= " WHERE id_user = ?";

        $stmt = mysqli_prepare($conn, $queryUpdate);
        if ($stmt === false) {
            throw new Error('Statement preparation failed: ' . mysqli_error($conn));
        }
        echo var_dump($roleName);
        // Bind parameters
        if (!empty($hashedPassword)) {
            mysqli_stmt_bind_param($stmt, 'sssisssissi', $avatarPath, $namaPengguna, $namaLengkap, $nomorTelepon, $alamat, $email, $idRole, $roleName, $createdAt, $hashedPassword, $idUser);
        } else {
            mysqli_stmt_bind_param($stmt, 'sssisssisi', $avatarPath, $namaPengguna, $namaLengkap, $nomorTelepon, $alamat, $email, $idRole, $roleName, $createdAt, $idUser);
        }

        $resultUpdate = mysqli_stmt_execute($stmt);
        if ($resultUpdate === false) {
            throw new Error('Statement execution failed: ' . mysqli_stmt_error($stmt));
        }

        mysqli_stmt_close($stmt);
        return $resultUpdate;
    } catch (Error $e) {
        echo "Caught error: " . $e->getMessage();
    }
}

function deleteDataPengguna($idUser)
{
    global $conn;
    try {
        // Ambil nama file avatar dari database berdasarkan id_user
        $queryAvatar = "SELECT avatar FROM user WHERE id_user = ?";
        $stmtAvatar = mysqli_prepare($conn, $queryAvatar);
        mysqli_stmt_bind_param($stmtAvatar, 's', $idUser);
        mysqli_stmt_execute($stmtAvatar);
        mysqli_stmt_bind_result($stmtAvatar, $avatarPath);
        mysqli_stmt_fetch($stmtAvatar);
        mysqli_stmt_close($stmtAvatar);

        // Hapus pengguna dari database
        $queryDelete = "DELETE FROM user WHERE id_user = ?";
        $stmt = mysqli_prepare($conn, $queryDelete);
        mysqli_stmt_bind_param($stmt, 's', $idUser);
        $resultDelete = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        // Jika pengguna berhasil dihapus dari database, hapus file avatar jika ada
        if ($resultDelete && !empty($avatarPath)) {
            $fullAvatarPath = 'uploads/avatars/' . basename($avatarPath);
            if (file_exists($fullAvatarPath)) {
                unlink($fullAvatarPath); // Hapus file avatar
            }
        }

        return $resultDelete;
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}

// ================ MENU AKTIVITAS PENGGUNA ================ \\

function displayDataAktivitasPengguna()
{
    global $conn;
    try {
        $queryGet = 'SELECT * FROM notifications';
        $stmt = mysqli_prepare($conn, $queryGet);
        if ($stmt === false) {
            throw new Error('Statement preparation failed: ' . mysqli_error($conn));
        }

        $result = mysqli_stmt_execute($stmt);
        if ($result === false) {
            throw new Error('Statement execution failed: ' . mysqli_stmt_error($stmt));
        }

        $result = mysqli_stmt_get_result($stmt);
        if ($result === false) {
            throw new Error('Getting result set failed: ' . mysqli_stmt_error($stmt));
        }

        mysqli_stmt_close($stmt);
        return $result;
    } catch (Error $e) {
        echo "Caught error: " . $e->getMessage();
    }
}
