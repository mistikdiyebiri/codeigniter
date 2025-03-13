<?php

/**
 * Tryoto Helper Functions
 */

if (!function_exists('tryoto_client')) {
    /**
     * Get Tryoto client instance
     *
     * @return \TryotoApi\Libraries\TryotoClient
     */
    function tryoto_client()
    {
        return new \TryotoApi\Libraries\TryotoClient();
    }
}

if (!function_exists('tryoto_products')) {
    /**
     * Get Tryoto products instance
     *
     * @return \TryotoApi\Libraries\Products
     */
    function tryoto_products()
    {
        return new \TryotoApi\Libraries\Products();
    }
}

if (!function_exists('tryoto_orders')) {
    /**
     * Get Tryoto orders instance
     *
     * @return \TryotoApi\Libraries\Orders
     */
    function tryoto_orders()
    {
        return new \TryotoApi\Libraries\Orders();
    }
}

if (!function_exists('tryoto_customers')) {
    /**
     * Get Tryoto customers instance
     *
     * @return \TryotoApi\Libraries\Customers
     */
    function tryoto_customers()
    {
        return new \TryotoApi\Libraries\Customers();
    }
}

if (!function_exists('tryoto_format_currency')) {
    /**
     * Format currency
     *
     * @param float $amount
     * @param string $currencyCode
     * @return string
     */
    function tryoto_format_currency(float $amount, string $currencyCode = 'TRY')
    {
        $formatter = new NumberFormatter('tr_TR', NumberFormatter::CURRENCY);
        return $formatter->formatCurrency($amount, $currencyCode);
    }
}

if (!function_exists('tryoto_format_date')) {
    /**
     * Format date
     *
     * @param string $date
     * @param string $format
     * @return string
     */
    function tryoto_format_date(string $date, string $format = 'd.m.Y H:i:s')
    {
        return date($format, strtotime($date));
    }
}