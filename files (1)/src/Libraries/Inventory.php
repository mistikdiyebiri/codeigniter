<?php

namespace TryotoApi\Libraries;

use Exception;

class Inventory
{
    /**
     * @var TryotoClient
     */
    protected $client;

    /**
     * Inventory constructor
     */
    public function __construct()
    {
        $this->client = new TryotoClient();
    }

    /**
     * Get inventory for products
     *
     * @param array $params Filter parameters
     * @return array
     * @throws Exception
     */
    public function getAll(array $params = []): array
    {
        return $this->client->request('GET', 'inventory', $params);
    }

    /**
     * Get inventory for specific product
     *
     * @param int $productId Product ID
     * @return array
     * @throws Exception
     */
    public function getForProduct(int $productId): array
    {
        return $this->client->request('GET', "inventory/products/{$productId}");
    }

    /**
     * Update inventory for a product
     *
     * @param int $productId Product ID
     * @param array $data Inventory data
     * @return array
     * @throws Exception
     */
    public function updateForProduct(int $productId, array $data): array
    {
        return $this->client->request('PUT', "inventory/products/{$productId}", $data);
    }
    
    /**
     * Adjust inventory
     *
     * @param int $productId Product ID
     * @param int $quantity Adjustment quantity (positive for increase, negative for decrease)
     * @param string $reason Adjustment reason
     * @param array $additionalData Additional data
     * @return array
     * @throws Exception
     */
    public function adjust(int $productId, int $quantity, string $reason, array $additionalData = []): array
    {
        $data = array_merge([
            'product_id' => $productId,
            'quantity' => $quantity,
            'reason' => $reason
        ], $additionalData);
        
        return $this->client->request('POST', 'inventory/adjust', $data);
    }
    
    /**
     * Reserve inventory
     *
     * @param int $productId Product ID
     * @param int $quantity Quantity to reserve
     * @param string $reference Reference (e.g., order ID)
     * @return array
     * @throws Exception
     */
    public function reserve(int $productId, int $quantity, string $reference): array
    {
        return $this->client->request('POST', 'inventory/reserve', [
            'product_id' => $productId,
            'quantity' => $quantity,
            'reference' => $reference
        ]);
    }
    
    /**
     * Release reserved inventory
     *
     * @param int $reservationId Reservation ID
     * @return array
     * @throws Exception
     */
    public function releaseReservation(int $reservationId): array
    {
        return $this->client->request('POST', "inventory/reservations/{$reservationId}/release");
    }
    
    /**
     * Get inventory history
     *
     * @param array $params Filter parameters
     * @return array
     * @throws Exception
     */
    public function getHistory(array $params = []): array
    {
        return $this->client->request('GET', 'inventory/history', $params);
    }
    
    /**
     * Get low stock products
     *
     * @param int $threshold Threshold quantity
     * @return array
     * @throws Exception
     */
    public function getLowStock(int $threshold = 5): array
    {
        return $this->client->request('GET', 'inventory/low-stock', [
            'threshold' => $threshold
        ]);
    }
}