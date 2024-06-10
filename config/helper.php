<?php
function formatRupiah($amount)
{
    // Create a NumberFormatter instance for Indonesian locale
    $formatter = new NumberFormatter('id_ID', NumberFormatter::CURRENCY);

    // Format the amount as Indonesian Rupiah
    return $formatter->formatCurrency($amount, 'IDR');
}
