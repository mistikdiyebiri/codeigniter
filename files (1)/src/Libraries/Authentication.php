<?php

namespace TryotoApi\Libraries;

use Exception;

class Authentication
{
    /**
     * @var TryotoClient
     */
    protected $client;

    /**
     * Authentication constructor
     */
    public function __construct()
    {
        $this->client = new TryotoClient();
    }

    /**
     * Authenticate and get access token
     *
     * @param string|null $apiKey Override default API key
     * @param string|null $apiSecret Override default API secret
     * @return array
     * @throws Exception
     */
    public function login(?string $apiKey = null, ?string $apiSecret = null): array
    {
        $data = [];
        
        if ($apiKey !== null) {
            $data['api_key'] = $apiKey;
        }
        
        if ($apiSecret !== null) {
            $data['api_secret'] = $apiSecret;
        }
        
        return $this->client->request('POST', 'auth/login', $data, false);
    }

    /**
     * Logout and invalidate token
     *
     * @return array
     * @throws Exception
     */
    public function logout(): array
    {
        return $this->client->request('POST', 'auth/logout');
    }

    /**
     * Refresh access token
     *
     * @param string $refreshToken
     * @return array
     * @throws Exception
     */
    public function refreshToken(string $refreshToken): array
    {
        return $this->client->request('POST', 'auth/refresh', [
            'refresh_token' => $refreshToken
        ], false);
    }

    /**
     * Verify if token is valid
     *
     * @return array
     * @throws Exception
     */
    public function verifyToken(): array
    {
        return $this->client->request('GET', 'auth/verify');
    }
    
    /**
     * Get account information
     *
     * @return array
     * @throws Exception
     */
    public function getAccount(): array
    {
        return $this->client->request('GET', 'auth/account');
    }
    
    /**
     * Update account information
     *
     * @param array $data
     * @return array
     * @throws Exception
     */
    public function updateAccount(array $data): array
    {
        return $this->client->request('PUT', 'auth/account', $data);
    }
    
    /**
     * Change password
     *
     * @param string $currentPassword
     * @param string $newPassword
     * @return array
     * @throws Exception
     */
    public function changePassword(string $currentPassword, string $newPassword): array
    {
        return $this->client->request('POST', 'auth/change-password', [
            'current_password' => $currentPassword,
            'new_password' => $newPassword
        ]);
    }
}