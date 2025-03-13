<?php

namespace TryotoApi\Libraries;

use CodeIgniter\Config\Services;
use TryotoApi\Config\Tryoto as TryotoConfig;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Exception;

class TryotoClient
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * @var TryotoConfig
     */
    protected $config;

    /**
     * @var array
     */
    protected $headers = [];

    /**
     * @var array
     */
    protected $lastResponse = [];

    /**
     * @var string
     */
    protected $accessToken = '';

    /**
     * TryotoClient constructor
     */
    public function __construct()
    {
        $this->config = config('TryotoApi\Config\Tryoto');
        
        $this->headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ];

        $this->client = new Client([
            'base_uri' => rtrim($this->config->baseURL, '/') . '/',
            'timeout' => $this->config->timeout,
            'http_errors' => false,
        ]);

        // Load helper
        helper('tryoto');
    }

    /**
     * Execute API request
     *
     * @param string $method HTTP method
     * @param string $endpoint API endpoint
     * @param array $params Request parameters
     * @param bool $requiresAuth Whether the endpoint requires authentication
     * @return array
     * @throws Exception
     */
    public function request(string $method, string $endpoint, array $params = [], bool $requiresAuth = true): array
    {
        // Apply rate limiting
        $this->applyRateLimit();

        // Set authentication if required
        $headers = $this->headers;
        if ($requiresAuth) {
            if (empty($this->accessToken)) {
                $this->authenticate();
            }
            $headers['Authorization'] = 'Bearer ' . $this->accessToken;
        }

        // Prepare request options
        $options = [
            'headers' => $headers,
        ];

        // Add request body or query parameters
        if ($method === 'GET') {
            $options['query'] = $params;
        } else {
            $options['json'] = $params;
        }

        // Log request if enabled
        if ($this->config->enableLogging) {
            $this->logRequest($method, $endpoint, $params);
        }

        try {
            // Execute request
            $response = $this->client->request($method, $endpoint, $options);
            
            // Process response
            $body = $response->getBody()->getContents();
            $data = json_decode($body, true) ?: [];
            $statusCode = $response->getStatusCode();

            $this->lastResponse = [
                'status_code' => $statusCode,
                'data' => $data,
                'headers' => $response->getHeaders(),
            ];

            // Log response if enabled
            if ($this->config->enableLogging) {
                $this->logResponse($statusCode, $data);
            }

            // Check for API errors
            if ($statusCode >= 400) {
                $errorMessage = $data['message'] ?? 'API Error: ' . $statusCode;
                throw new Exception($errorMessage, $statusCode);
            }

            return $data;
        } catch (GuzzleException $e) {
            // Log error
            if ($this->config->enableLogging) {
                log_message('error', 'Tryoto API Error: ' . $e->getMessage());
            }
            
            throw new Exception('API Request Error: ' . $e->getMessage(), $e->getCode());
        }
    }

    /**
     * Authenticate with API
     *
     * @return bool
     * @throws Exception
     */
    public function authenticate(): bool
    {
        try {
            $response = $this->client->request('POST', 'auth/login', [
                'headers' => $this->headers,
                'json' => [
                    'api_key' => $this->config->apiKey,
                    'api_secret' => $this->config->apiSecret,
                ],
            ]);

            $statusCode = $response->getStatusCode();
            $data = json_decode($response->getBody()->getContents(), true) ?: [];

            if ($statusCode === 200 && isset($data['access_token'])) {
                $this->accessToken = $data['access_token'];
                return true;
            }

            $errorMessage = $data['message'] ?? 'Authentication failed';
            throw new Exception($errorMessage, $statusCode);
        } catch (GuzzleException $e) {
            throw new Exception('Authentication Error: ' . $e->getMessage(), $e->getCode());
        }
    }

    /**
     * Apply rate limiting
     */
    protected function applyRateLimit(): void
    {
        $cache = Services::cache();
        $key = 'tryoto_api_rate_limit';
        
        $requests = $cache->get($key) ?? [];
        $now = time();
        
        // Remove requests older than 1 minute
        $requests = array_filter($requests, function($timestamp) use ($now) {
            return $now - $timestamp < 60;
        });
        
        // Check if rate limit is reached
        if (count($requests) >= $this->config->rateLimit) {
            $oldestRequest = min($requests);
            $sleepTime = 60 - ($now - $oldestRequest);
            if ($sleepTime > 0) {
                sleep($sleepTime);
            }
        }
        
        // Add current request timestamp
        $requests[] = $now;
        $cache->save($key, $requests, 120);
    }

    /**
     * Log API request
     *
     * @param string $method
     * @param string $endpoint
     * @param array $params
     */
    protected function logRequest(string $method, string $endpoint, array $params): void
    {
        $message = "Tryoto API Request: $method $endpoint";
        if ($this->config->debug) {
            $message .= " Data: " . json_encode($params);
        }
        log_message('info', $message);
    }

    /**
     * Log API response
     *
     * @param int $statusCode
     * @param array $data
     */
    protected function logResponse(int $statusCode, array $data): void
    {
        $message = "Tryoto API Response: Status $statusCode";
        if ($this->config->debug) {
            $message .= " Data: " . json_encode($data);
        }
        
        $level = $statusCode >= 400 ? 'error' : 'info';
        log_message($level, $message);
    }

    /**
     * Get last response
     *
     * @return array
     */
    public function getLastResponse(): array
    {
        return $this->lastResponse;
    }
}