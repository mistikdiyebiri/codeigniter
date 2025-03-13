<?php

namespace TryotoApi\Models;

use CodeIgniter\Model;

class TryotoLogModel extends Model
{
    protected $table      = 'tryoto_logs';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'request_method',
        'request_url',
        'request_data',
        'response_code',
        'response_data',
        'created_at',
    ];

    protected $useTimestamps = false;
    protected $createdField  = 'created_at';

    /**
     * Save log entry
     *
     * @param string $method
     * @param string $url
     * @param array $requestData
     * @param int $responseCode
     * @param array $responseData
     * @return int|string
     */
    public function saveLog(string $method, string $url, array $requestData, int $responseCode, array $responseData)
    {
        return $this->insert([
            'request_method' => $method,
            'request_url' => $url,
            'request_data' => json_encode($requestData),
            'response_code' => $responseCode,
            'response_data' => json_encode($responseData),
            'created_at' => date('Y-m-d H:i:s'),
        ]);
    }

    /**
     * Get logs for a specific period
     *
     * @param string $startDate
     * @param string $endDate
     * @return array
     */
    public function getLogsByDateRange(string $startDate, string $endDate): array
    {
        return $this->where('created_at >=', $startDate)
                   ->where('created_at <=', $endDate)
                   ->orderBy('created_at', 'DESC')
                   ->findAll();
    }
}