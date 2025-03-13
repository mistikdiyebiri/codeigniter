<?php

namespace TryotoApi\Config;

use CodeIgniter\Config\BaseConfig;

class Tryoto extends BaseConfig
{
    /**
     * API Base URL
     *
     * @var string
     */
    public $baseURL = 'https://apis.tryoto.com/';

    /**
     * API Version
     *
     * @var string
     */
    public $apiVersion = 'v1';

    /**
     * API Key
     *
     * @var string
     */
    public $apiKey = '';

    /**
     * API Secret
     *
     * @var string
     */
    public $apiSecret = '';

    /**
     * Timeout in seconds
     *
     * @var int
     */
    public $timeout = 30;

    /**
     * Debug mode
     *
     * @var bool
     */
    public $debug = false;

    /**
     * Log API requests and responses
     *
     * @var bool
     */
    public $enableLogging = true;

    /**
     * Rate limiting: max requests per minute
     *
     * @var int
     */
    public $rateLimit = 60;
}