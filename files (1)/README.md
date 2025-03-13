# Tryoto API Integration for CodeIgniter 4

This is a comprehensive CodeIgniter 4 library/package for integrating with the Tryoto API (https://apis.tryoto.com/).

## Features

- Complete API integration for e-commerce and marketplace functionality
- Support for products, orders, customers, payments, shipping, and inventory management
- Easy to use helper functions
- Flexible configuration
- Rate limiting and request throttling
- Request/Response logging
- Webhook support
- Dashboard for monitoring

## Installation

### Composer Installation

```bash
composer require your-vendor/tryoto-api
```

### Manual Installation

1. Download or clone this repository
2. Place it in your CodeIgniter 4 project under `app/ThirdParty/tryoto-api`
3. Update your `app/Config/Autoload.php` file to include the library:

```php
public $psr4 = [
    APP_NAMESPACE => APPPATH,
    'TryotoApi' => APPPATH . 'ThirdParty/tryoto-api/src'
];
```

## Configuration

After installation, you need to configure the API credentials:

1. Copy the config file:

```bash
php spark config:publish TryotoApi\\Config\\Tryoto
```

2. Edit `app/Config/TryotoApi/Tryoto.php` with your API credentials:

```php
public $apiKey = 'your-api-key';
public $apiSecret = 'your-api-secret';
```

## Usage Examples

### Basic Usage

```php
// Load helper
helper('tryoto');

// Access API through helper functions
$products = tryoto_products()->getAll(['limit' => 10]);
$orders = tryoto_orders()->getAll(['status' => 'pending']);
```

### Working with Products

```php
$products = new \TryotoApi\Libraries\Products();

// Get all products
$allProducts = $products->getAll(['limit' => 20, 'page' => 1]);

// Get a specific product
$product = $products->get(123);

// Create a new product
$newProduct = $products->create([
    'name' => 'Sample Product',
    'sku' => 'SAMPLE-001',
    'price' => 29.99,
    'description' => 'This is a sample product',
    'stock' => 100
]);

//