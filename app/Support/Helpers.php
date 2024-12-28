<?php

declare(strict_types=1);

if (! function_exists('formatRupiah')) {
    /**
     * Format angka menjadi format Rupiah.
     *
     * @param  int|float $number
     * @return string
     */
    function formatRupiah($number)
    {
        return 'Rp ' . number_format($number, 0, ',', '.');
    }
}
