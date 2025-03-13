<?php

namespace TryotoApi\Libraries;

use Exception;

class Shipping
{
    /**
     * @var TryotoClient
     */
    protected $client;

    /**
     * Shipping constructor
     */
    public function __construct()
    {
        $this->client = new TryotoClient();
    }

    /**
     * Get shipping methods
     *
     * @param array $params Filter parameters
     * @return array
     * @throws Exception
     */
    public function getMethods(array $params = []): array
    {
        return $this->client->request('GET', 'shipping/methods', $params);
    }

    /**
     * Get shipping rates
     *
     * @param array $params Rate parameters (origin, destination, items, etc.)
     * @return array
     * @throws Exception
     */
    public function getRates(array $params): array
    {
        return $this->client->request('POST', 'shipping/rates', $params);
    }

    /**
     * Create shipment
     *
     * @param array $data Shipment data
     * @return array
     * @throws Exception
     */
    public function createShipment(array $data): array
    {
        return $this->client->request('POST', 'shipping/shipments', $data);
    }

    /**
     * Get shipment by ID
     *
     * @param int $id Shipment ID
     * @return array
     * @throws Exception
     */
    public function getShipment(int $id): array
    {
        return $this->client->request('GET', "shipping/shipments/{$id}");
    }
    
    /**
     * Cancel shipment
     *
     * @param int $id Shipment ID
     * @param array $data Cancellation data
     * @return array
     * @throws Exception
     */
    public function cancelShipment(int $id, array $data = []): array
    {
        return $this->client->request('POST', "shipping/shipments/{$id}/cancel", $data);
    }
    
    /**
     * Generate shipping label
     *
     * @param int $shipmentId Shipment ID
     * @param array $data Label options
     * @return array
     * @throws Exception
     */
    public function generateLabel(int $shipmentId, array $data = []): array
    {
        return $this->client->request('POST', "shipping/shipments/{$shipmentId}/label", $data);
    }
    
    /**
     * Track shipment
     *
     * @param string $trackingNumber Tracking number
     * @param string $carrier Carrier code
     * @return array
     * @throws Exception
     */
    public function track(string $trackingNumber, string $carrier = ''): array
    {
        $params = ['tracking_number' => $trackingNumber];
        
        if (!empty($carrier)) {
            $params['carrier'] = $carrier;
        }
        
        return $this->client->request('GET', 'shipping/track', $params);
    }
    
    /**
     * Validate address
     *
     * @param array $addressData Address data
     * @return array
     * @throws Exception
     */
    public function validateAddress(array $addressData): array
    {
        return $this->client->request('POST', 'shipping/validate-address', $addressData);
    }
}