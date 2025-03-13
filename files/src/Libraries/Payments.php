<?php

namespace TryotoApi\Libraries;

use Exception;

class Payments
{
    /**
     * @var TryotoClient
     */
    protected $client;

    /**
     * Payments constructor
     */
    public function __construct()
    {
        $this->client = new TryotoClient();
    }

    /**
     * Get all payments
     *
     * @param array $params Filter parameters
     * @return array
     * @throws Exception
     */
    public function getAll(array $params = []): array
    {
        return $this->client->request('GET', 'payments', $params);
    }

    /**
     * Get payment by ID
     *
     * @param int $id Payment ID
     * @return array
     * @throws Exception
     */
    public function get(int $id): array
    {
        return $this->client->request('GET', "payments/{$id}");
    }

    /**
     * Create payment
     *
     * @param array $data Payment data
     * @return array
     * @throws Exception
     */
    public function create(array $data): array
    {
        return $this->client->request('POST', 'payments', $data);
    }

    /**
     * Process payment
     *
     * @param int $id Payment ID
     * @param array $data Processing data
     * @return array
     * @throws Exception
     */
    public function process(int $id, array $data = []): array
    {
        return $this->client->request('POST', "payments/{$id}/process", $data);
    }

    /**
     * Cancel payment
     *
     * @param int $id Payment ID
     * @param array $data Cancellation reason
     * @return array
     * @throws Exception
     */
    public function cancel(int $id, array $data = []): array
    {
        return $this->client->request('POST', "payments/{$id}/cancel", $data);
    }

    /**
     * Refund payment
     *
     * @param int $id Payment ID
     * @param array $data Refund data
     * @return array
     * @throws Exception
     */
    public function refund(int $id, array $data): array
    {
        return $this->client->request('POST', "payments/{$id}/refund", $data);
    }
    
    /**
     * Get payment methods
     *
     * @return array
     * @throws Exception
     */
    public function getMethods(): array
    {
        return $this->client->request('GET', 'payments/methods');
    }
    
    /**
     * Create payment link
     *
     * @param array $data Payment link data
     * @return array
     * @throws Exception
     */
    public function createPaymentLink(array $data): array
    {
        return $this->client->request('POST', 'payments/links', $data);
    }
}