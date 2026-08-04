<?php

use CodeIgniter\HTTP\Exceptions\HTTPException;

if (!function_exists('format_price')) {
    /**
     * Format price dengan format Rupiah
     *
     * @param float|int|string $amount
     * @return string
     */
    function format_price($amount): string
    {
        // Konversi ke float jika string
        $amount = (float) $amount;
        
        // Format dengan thousand separator
        return 'Rp ' . number_format($amount, 0, ',', '.');
    }
}

if (!function_exists('format_number')) {
    /**
     * Format number dengan thousand separator
     *
     * @param float|int|string $number
     * @param int $decimals
     * @return string
     */
    function format_number($number, int $decimals = 0): string
    {
        return number_format((float) $number, $decimals, ',', '.');
    }
}

if (!function_exists('format_date')) {
    /**
     * Format date
     *
     * @param string $date
     * @param string $format
     * @return string
     */
    function format_date(string $date, string $format = 'd M Y H:i'): string
    {
        $timestamp = strtotime($date);
        if ($timestamp === false) {
            return $date;
        }
        
        return date($format, $timestamp);
    }
}

if (!function_exists('calculate_tax')) {
    /**
     * Calculate tax from amount
     *
     * @param float|int|string $amount
     * @param float $taxRate
     * @return float
     */
    function calculate_tax($amount, float $taxRate = 0.10): float
    {
        return (float) $amount * $taxRate;
    }
}
