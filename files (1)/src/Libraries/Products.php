<?php

namespace TryotoApi\Libraries;

use Exception;

class Products
{
    /**
     * @var TryotoClient
     */
    protected $client;

    /**
     * Products constructor
     */
    public function __construct()
    {
        $this->client = new TryotoClient();
    }

    /**
     * Get all products
     *
     * @param array $params Filter parameters
     * @return array
     * @throws Exception
     */
    public function getAll(array $params = []): array
    {
        return $this->client->request('GET', 'products', $params);
    }

    /**
     * Get a specific product by ID
     *
     * @param int $id Product ID
     * @return array
     * @throws Exception
     */
    public function get(int $id): array
    {
        return $this->client->request('GET', "products/{$id}");
    }

    /**
     * Create a new product
     *
     * @param array $data Product data
     * @return array
     * @throws Exception
     */
    public function create(array $data): array
    {
        return $this->client->request('POST', 'products', $data);
    }

    /**
     * Update a product
     *
     * @param int $id Product ID
     * @param array $data Product data
     * @return array
     * @throws Exception
     */
    public function update(int $id, array $data): array
    {
        return $this->client->request('PUT', "products/{$id}", $data);
    }

    /**
     * Delete a product
     *
     * @param int $id Product ID
     * @return array
     * @throws Exception
     */
    public function delete(int $id): array
    {
        return $this->client->request('DELETE', "products/{$id}");
    }

    /**
     * Search products
     *
     * @param string $query Search query
     * @param array $options Search options
     * @return array
     * @throws Exception
     */
    public function search(string $query, array $options = []): array
    {
        $params = array_merge(['query' => $query], $options);
        return $this->client->request('GET', 'products/search', $params);
    }
    
    /**
     * Get product categories
     *
     * @return array
     * @throws Exception
     */
    public function getCategories(): array
    {
        return $this->client->request('GET', 'products/categories');
    }
    
    /**
     * Get product reviews
     *
     * @param int $productId Product ID
     * @param array $params Filter parameters
     * @return array
     * @throws Exception
     */
    public function getReviews(int $productId, array $params = []): array
    {
        return $this->client->request('GET', "products/{$productId}/reviews", $params);
    }
    
    /**
     * Add product review
     *
     * @param int $productId Product ID
     * @param array $data Review data
     * @return array
     * @throws Exception
     */
    public function addReview(int $productId, array $data): array
    {
        return $this->client->request('POST', "products/{$productId}/reviews", $data);
    }
    
    /**
     * Upload product image
     *
     * @param int $productId Product ID
     * @param string $filePath Path to image file
     * @return array
     * @throws Exception
     */
    public function uploadImage(int $productId, string $filePath): array
    {
        // Implementation for file upload would require multipart form handling
        // This is a simplified version
        $data = [
            'file' => base64_encode(file_get_contents($filePath)),
            'filename' => basename($filePath)
        ];
        
        return $this->client->request('POST', "products/{$productId}/images", $data);
    }
}