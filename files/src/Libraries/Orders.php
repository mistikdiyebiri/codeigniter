<?php

namespace TryotoApi\Libraries;

use Exception;

class Orders
{
    /**
     * @var TryotoClient
     */
    protected $client;

    /**
     * Orders constructor
     */
    public function __construct()
    {
        $this->client = new TryotoClient();
    }

    /**
     * Get all orders
     *
     * @param array $params Filter parameters
     * @return array
     * @throws Exception
     */
    public function getAll(array $params = []): array
    {
        return $this->client->request('GET', 'orders', $params);
    }

    /**
     * Get a specific order by ID
     *
     * @param int $id Order ID
     * @return array
     * @throws Exception
     */
    public function get(int $id): array
    {
        return $this->client->request('GET', "orders/{$id}");
    }

    /**
     * Create a new order
     *
     * @param array $data Order data
     * @return array
     * @throws Exception
     */
    public function create(array $data): array
    {
        return $this->client->request('POST', 'orders', $data);
    }

    /**
     * Update an order
     *
     * @param int $id Order ID
     * @param array $data Order data
     * @return array
     * @throws Exception
     */
    public function update(int $id, array $data): array
    {
        return $this->client->request('PUT', "orders/{$id}", $data);
    }

    /**
     * Cancel an order
     *
     * @param int $id Order ID
     * @param array $data Cancellation data
     * @return array
     * @throws Exception
     */
    public function cancel(int $id, array $data = []): array
    {
        return $this->client->request('POST', "orders/{$id}/cancel", $data);
    }
    
    /**
     * Update order status
     *
     * @param int $id Order ID
     * @param string $status New status
     * @param array $data Additional data
     * @return array
     * @throws Exception
     */
    public function updateStatus(int $id, string $status, array $data = []): array
    {
        $params = array_merge(['status' => $status], $data);
        return $this->client->request('PUT', "orders/{$id}/status", $params);
    }
    
    /**
     * Get order items
     *
     * @param int $orderId Order ID
     * @return array
     * @throws Exception
     */
    public function getItems(int $orderId): array
    {
        return $this->client->request('GET', "orders/{$orderId}/items");
    }
    
    /**
     * Add item to order
     *
     * @param int $orderId Order ID
     * @param array $data Item data
     * @return array
     * @throws Exception
     */
    public function addItem(int $orderId, array $data): array
    {
        return $this->client->request('POST', "orders/{$orderId}/items", $data);
    }
    
    /**
     * Remove item from order
     *
     * @param int $orderId Order ID
     * @param int $itemId Item ID
     * @return array
     * @throws Exception
     */
    public function removeItem(int $orderId, int $itemId): array
    {
        return $this->client->request('DELETE', "orders/{$orderId}/items/{$itemId}");
    }
    
    /**
     * Get order history
     *
     * @param int $orderId Order ID
     * @return array
     * @throws Exception
     */
    public function getHistory(int $orderId): array
    {
        return $this->client->request('GET', "orders/{$orderId}/history");
    }
    
    /**
     * Get order tracking information
     *
     * @param int $orderId Order ID
     * @return array
     * @throws Exception
     */
    public function getTracking(int $orderId): array
    {
        return $this->client->request('GET', "orders/{$orderId}/tracking");
    }
}