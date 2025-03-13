<?php

namespace TryotoApi\Config;

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->group('tryoto', ['namespace' => 'TryotoApi\Controllers'], function($routes) {
    $routes->get('dashboard', 'TryotoController::dashboard');
    $routes->get('products', 'TryotoController::getProducts');
    $routes->post('products', 'TryotoController::createProduct');
    $routes->get('orders', 'TryotoController::getOrders');
});