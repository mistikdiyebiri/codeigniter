<?php

namespace TryotoApi\Libraries;

use Exception;

class Customers
{
    /**
     * @var TryotoClient
     */
    protected $client;

    /**
     * Customers constructor
     */
    public function __construct()
    {
        $this->client = new TryotoClient();
    }

    /**
     * Get all customers
     *
     * @param array $params Filter parameters
     * @return array
     * @throws Exception
     */
    public function getAll(array $params = []): array
    {
        return $this->client->request('GET', 'customers', $params);
    }

    /**
     * Get a specific customer by ID
     *
     * @param int $id Customer ID
     * @return array
     * @throws Exception
     */
    public function get(int $id): array
    {
        return $this->client->request('GET', "customers/{$id}");
    }

    /**
     * Create a new customer
     *
     * @param array $data Customer data
     * @return array
     * @throws Exception
     */
    public function create(array $data): array
    {
        return $this->client->request('POST', 'customers', $data);
    }

    /**
     * Update a customer
     *
     * @param int $id Customer ID
     * @param array $data Customer data
     * @return array
     * @throws Exception
     */
    public function update(int $id, array $data): array
    {
        return $this->client->request('PUT', "customers/{$id}", $data);
    }

    /**
     * Delete a customer
     *
     * @param int $id Customer ID
     * @return array
     * @throws Exception
     */
    public function delete(int $id): array
    {
        return $this->client->request('DELETE', "customers/{$id}");
    }
    
    /**
     * Search customers
     *
     * @param string $query Search query
     * @param array $options Search options
     * @return array
     * @throws Exception
     */
    public function search(string $query, array $options = []): array
    {
        $params = array_merge(['query' => $query], $options);
        return $this->client->request('GET', 'customers/search', $params);
    }
    
    /**
     * Get customer orders
     *
     * @param int $customerId Customer ID
     * @param array $params Filter parameters
     * @return array
     * @throws Exception
     */
    public function getOrders(int $customerId, array $params = []): array
    {
        return $this->client->request('GET', "customers/{$customerId}/orders", $params);
    }
    
    /**
     * Get customer addresses
     *
     * @param int $customerId Customer ID
     * @return array
     * @throws Exception
     */
    public function getAddresses(int $customerId): array
    {
        return $this->client->request('GET', "customers/{$customerId}/addresses");
    }
    
    /**
     * Add customer address
     *
     * @param int $customerId Customer ID
     * @param array $data Address data
     * @return array
     * @throws Exception
     */
    public function addAddress(int $customerId, array $data): array
    {
        return $this->client->request('POST', "customers/{$customerId}/addresses", $data);
    }
    
    /**
     * Update customer address
     *
     * @param int $customerId Customer ID
     * @param int $addressId Address ID
     * @param array $data Address data
     * @return array
     * @throws Exception
     */
    public function updateAddress(int $customerId, int $addressId, array $data): array
    {
        return $this->client->request('PUT', "customers/{$customerId}/addresses/{$addressId}", $data);
    }
    
    /**
     * Delete customer address
     *
     * @param int $customerId Customer ID
     * @param int $addressId Address ID
     * @return array
     * @throws Exception
     */
    public function deleteAddress(int $customerId, int $addressId): array
    {
        return $this->client->request('DELETE', "customers/{$customerId}/addresses/{$addressId}");
    }
}