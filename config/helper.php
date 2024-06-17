<?php
function formatRupiah($amount)
{
    // Create a NumberFormatter instance for Indonesian locale
    $formatter = new NumberFormatter('id_ID', NumberFormatter::CURRENCY);

    // Set the formatting style to decimal (without cents)
    $formatter->setAttribute(NumberFormatter::MAX_FRACTION_DIGITS, 0);

    // Format the amount as Indonesian Rupiah without cents
    return $formatter->formatCurrency($amount, 'IDR');
}

function getNewId($conn, $tableName)
{
    $sql = "SELECT COUNT(*) AS total FROM $tableName";
    $result = $conn->query($sql);
    if ($result) {
        $row = $result->fetch_assoc();
        $newId = $row['total'] + 1;
        return $newId;
    } else {
        return false;
    }
}

function getCurrentTimestamp()
{
    $date = new DateTime("now", new DateTimeZone('Asia/Jakarta'));
    return $date->format('Y-m-d');
}

function formatDate($tanggal)
{
    // Membuat objek DateTime dari tanggal awal
    $date = new DateTime($tanggal);

    // Array nama bulan dalam bahasa Indonesia
    $bulan = array(
        'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
    );

    // Memformat ulang tanggal menjadi "DD MMMM YYYY"
    $formattedDate = $date->format('d ') . $bulan[$date->format('n') - 1] . $date->format(' Y');

    return $formattedDate;
}

