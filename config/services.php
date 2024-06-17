<?php
require_once('config/connection.php');

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

function updateDataStokGudang($kodeBarang, $namaBarang, $totalKuantitas, $hargaBarang)
{
    global $conn;
    try {
        $queryUpdate = "UPDATE stok_gudang SET nama_barang = ?, total_kuantitas = ?, harga_barang = ? WHERE kode_barang = ?";
        $stmt = mysqli_prepare($conn, $queryUpdate);
        mysqli_stmt_bind_param($stmt, 'sids', $namaBarang, $totalKuantitas, $hargaBarang, $kodeBarang);
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

// ================ MENU MANAGEMEN PENGGUNA ================ \\

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
