<?php

if (!function_exists('format_currency')) {
    /**
     * Format amount in Pakistani Rupees (PKR)
     *
     * @param float $amount
     * @param bool $showSymbol
     * @return string
     */
    function format_currency($amount, $showSymbol = true)
    {
        $formatted = number_format($amount, 2);
        return $showSymbol ? 'PKR ' . $formatted : $formatted;
    }
}

if (!function_exists('currency_symbol')) {
    /**
     * Get currency symbol
     *
     * @return string
     */
    function currency_symbol()
    {
        return 'PKR';
    }
}
