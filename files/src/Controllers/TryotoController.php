<?php

namespace TryotoApi\Controllers;

use CodeIgniter\Controller;
use TryotoApi\Libraries\TryotoClient;
use TryotoApi\Libraries\Products;
use TryotoApi\Libraries\Orders;

class TryotoController extends Controller
{
    /**
     * @var TryotoClient
     */
    protected $client;
    
    /**
     * @var Products
     */
    protected $products;
    
    /**
     * @var Orders
     */
    protected $orders;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->client = new TryotoClient();
        $this->products = new Products();
        $this->orders = new Orders();
    }
    
    /**
     * Dashboard view
     *
     * @return string
     */
    public function dashboard()
    {
        $data = [
            'title' => 'Tryoto API Dashboard',
            'products' => [],
            'orders' => []
        ];
        
        try {
            // Get latest products
            $data['products'] = $this->products->getAll(['limit' => 5, 'sort' => 'created_at:desc']);
            
            // Get latest orders
            $data['orders'] = $this->orders->getAll(['limit' => 5, 'sort' => 'created_at:desc']);
        } catch (\Exception $e) {
            $data['error'] = $e->getMessage();
        }
        
        return view('TryotoApi\Views\dashboard', $data);
    }
    
    /**
     * Get all products
     *
     * @return \CodeIgniter\HTTP\Response
     */
    public function getProducts()
    {
        try {
            $params = $this->request->getGet();
            $result = $this->products->getAll($params);
            
            return $this->response->setJSON([
                'status' => 'success',
                'data' => $result
            ]);
        } catch (\Exception $e) {
            return $this->response->setStatusCode(500)->setJSON([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }
    
    /**
     * Create a new product
     *
     * @return \CodeIgniter\HTTP\Response
     */
    public function createProduct()
    {
        try {
            $data = $this->request->getJSON(true);
            $result = $this->products->create($data);
            
            return $this->response->setJSON([
                'status' => 'success',
                'data' => $result
            ]);
        } catch (\Exception $e) {
            return $this->response->setStatusCode(500)->setJSON([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }
    
    /**
     * Get all orders
     *
     * @return \CodeIgniter\HTTP\Response
     */
    public function getOrders()
    {
        try {
            $params = $this->request->getGet();
            $result = $this->orders->getAll($params);
            
            return $this->response->setJSON([
                'status' => 'success',
                'data' => $result
            ]);
        } catch (\Exception $e) {
            return $this->response->setStatusCode(500)->setJSON([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }
}