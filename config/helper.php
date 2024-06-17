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
    return $date->format('Y-m-d H:i:s');
}
