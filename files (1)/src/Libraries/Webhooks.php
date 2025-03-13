<?php

namespace TryotoApi\Libraries;

use Exception;
use CodeIgniter\Config\Services;
use CodeIgniter\HTTP\IncomingRequest;

class Webhooks
{
    /**
     * @var TryotoClient
     */
    protected $client;
    
    /**
     * @var array
     */
    protected $config;

    /**
     * Webhooks constructor
     */
    public function __construct()
    {
        $this->client = new TryotoClient();
        $this->config = config('TryotoApi\Config\Tryoto');
    }

    /**
     * Get all webhooks
     *
     * @return array
     * @throws Exception
     */
    public function getAll(): array
    {
        return $this->client->request('GET', 'webhooks');
    }

    /**
     * Get webhook by ID
     *
     * @param int $id Webhook ID
     * @return array
     * @throws Exception
     */
    public function get(int $id): array
    {
        return $this->client->request('GET', "webhooks/{$id}");
    }

    /**
     * Create webhook
     *
     * @param array $data Webhook data
     * @return array
     * @throws Exception
     */
    public function create(array $data): array
    {
        return $this->client->request('POST', 'webhooks', $data);
    }

    /**
     * Update webhook
     *
     * @param int $id Webhook ID
     * @param array $data Webhook data
     * @return array
     * @throws Exception
     */
    public function update(int $id, array $data): array
    {
        return $this->client->request('PUT', "webhooks/{$id}", $data);
    }

    /**
     * Delete webhook
     *
     * @param int $id Webhook ID
     * @return array
     * @throws Exception
     */
    public function delete(int $id): array
    {
        return $this->client->request('DELETE', "webhooks/{$id}");
    }
    
    /**
     * Process incoming webhook
     *
     * @param string|null $secret Override webhook secret
     * @return array
     */
    public function processIncoming(?string $secret = null): array
    {
        $request = Services::request();
        
        // Verify signature if secret is provided
        $webhookSecret = $secret ?? $this->config->webhookSecret ?? '';
        if (!empty($webhookSecret)) {
            $this->verifySignature($request, $webhookSecret);
        }
        
        // Get JSON body
        $body = $request->getJSON(true);
        
        if (empty($body)) {
            throw new Exception('Invalid webhook payload');
        }
        
        // Log webhook if enabled
        if ($this->config->enableLogging) {
            log_message('info', 'Webhook received: ' . json_encode($body));
        }
        
        return $body;
    }
    
    /**
     * Verify webhook signature
     *
     * @param IncomingRequest $request
     * @param string $secret
     * @return bool
     * @throws Exception
     */
    protected function verifySignature(IncomingRequest $request, string $secret): bool
    {
        $signature = $request->getHeaderLine('X-Tryoto-Signature');
        
        if (empty($signature)) {
            throw new Exception('Missing webhook signature');
        }
        
        $payload = $request->getBody();
        $calculatedSignature = hash_hmac('sha256', $payload, $secret);
        
        if (!hash_equals($calculatedSignature, $signature)) {
            throw new Exception('Invalid webhook signature');
        }
        
        return true;
    }
}