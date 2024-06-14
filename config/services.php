<?php
require_once('config/connection.php');

// ================ MENU GUDANG ================ \\

function displayDataBarang()
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

function tambahDataBarang($kodeBarang, $namaBarang, $totalKuantitas, $hargaBarang)
{
    global $conn;
    try {
        $queryInsert = "INSERT INTO stok_gudang (kode_barang, nama_barang, total_kuantitas, harga_barang) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $queryInsert);
        if ($stmt === false) {
            throw new Error('Statement preparation failed: ' . mysqli_error($conn));
        }

        mysqli_stmt_bind_param($stmt, 'ssii', $kodeBarang, $namaBarang, $totalKuantitas, $hargaBarang);
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

function updateDataBarang($kodeBarang, $namaBarang, $totalKuantitas, $hargaBarang)
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

function deleteDataBarang($kodeBarang)
{
    global $conn;
    try {
        $queryDelete = "DELETE FROM stok_gudang WHERE kode_barang = ?";
        $stmt = mysqli_prepare($conn, $queryDelete);
        mysqli_stmt_bind_param($stmt, 's', $kodeBarang);
        $resultDelete = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        return $resultDelete;
    } catch (Error $e) {
        echo "Caught error: " . $e->getMessage();
    }
}

// ================ MENU MASTER ================ \\

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

function tambahDataSatuan($idSatuan, $namaSatuan, $inisialSatuan)
{
    global $conn;
    try {
        $queryInsert = "INSERT INTO satuan (id_satuan, nama_satuan, inisial_satuan) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($conn, $queryInsert);
        if ($stmt === false) {
            throw new Error('Statement preparation failed: ' . mysqli_error($conn));
        }

        mysqli_stmt_bind_param($stmt, 'ssii', $idSatuan, $namaSatuan, $inisialSatuan);
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

function tambahDataTipeBarang($kodeTipe, $namaTipe)
{
    global $conn;
    try {
        $queryInsert = "INSERT INTO tipe_barang (kode_tipe, nama_tipe) VALUES (?, ?)";
        $stmt = mysqli_prepare($conn, $queryInsert);
        if ($stmt === false) {
            throw new Error('Statement preparation failed: ' . mysqli_error($conn));
        }

        mysqli_stmt_bind_param($stmt, 'ssii', $kodeTipe, $namaTipe);
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

function updateDataSatuan($idSatuan, $namaSatuan, $inisialSatuan)
{
    global $conn;
    try {
        $queryUpdate = "UPDATE satuan SET nama_satuan = ?, inisial_satuan = ? WHERE id_satuan = ?";
        $stmt = mysqli_prepare($conn, $queryUpdate);
        mysqli_stmt_bind_param($stmt, 'sids', $namaSatuan, $inisialSatuan, $idSatuan);
        $resultUpdate = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        return $resultUpdate;
    } catch (Error $e) {
        echo "Caught error: " . $e->getMessage();
    }
}

function updateDataTipeBarang($kodeTipe, $namaTipe)
{
    global $conn;
    try {
        $queryUpdate = "UPDATE tipe_barang SET nama_tipe = ? WHERE kode_Tipe = ?";
        $stmt = mysqli_prepare($conn, $queryUpdate);
        mysqli_stmt_bind_param($stmt, 'sids', $namaTipe, $kodeTipe);
        $resultUpdate = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        return $resultUpdate;
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
