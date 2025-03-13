<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?= $title ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h1><?= $title ?></h1>
        
        <?php if(isset($error)): ?>
            <div class="alert alert-danger">
                <?= $error ?>
            </div>
        <?php endif; ?>
        
        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5>Latest Products</h5>
                    </div>
                    <div class="card-body">
                        <?php if(empty($products)): ?>
                            <p class="text-muted">No products found</p>
                        <?php else: ?>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Price</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($products as $product): ?>
                                        <tr>
                                            <td><?= $product['id'] ?></td>
                                            <td><?= $product['name'] ?></td>
                                            <td><?= tryoto_format_currency($product['price']) ?></td>
                                            <td><?= $product['status'] ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php endif; ?>
                    </div>
                    <div class="card-footer">
                        <a href="#" class="btn btn-primary">View All Products</a>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5>Latest Orders</h5>
                    </div>
                    <div class="card-body">
                        <?php if(empty($orders)): ?>
                            <p class="text-muted">No orders found</p>
                        <?php else: ?>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Customer</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($orders as $order): ?>
                                        <tr>
                                            <td><?= $order['id'] ?></td>
                                            <td><?= $order['customer_name'] ?></td>
                                            <td><?= tryoto_format_currency($order['total_amount']) ?></td>
                                            <td>
                                                <span class="badge bg-<?= getStatusColor($order['status']) ?>">
                                                    <?= $order['status'] ?>
                                                </span>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php endif; ?>
                    </div>
                    <div class="card-footer">
                        <a href="#" class="btn btn-primary">View All Orders</a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5>API Information</h5>
                    </div>
                    <div class="card-body">
                        <p><strong>Base URL:</strong> <?= config('TryotoApi\Config\Tryoto')->baseURL ?></p>
                        <p><strong>API Version:</strong> <?= config('TryotoApi\Config\Tryoto')->apiVersion ?></p>
                        <p><strong>Last Update:</strong> <?= date('Y-m-d H:i:s') ?></p>
                        <p><strong>Developer:</strong> mistikdiyebiribunu</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function getStatusColor(status) {
            switch(status.toLowerCase()) {
                case 'completed': return 'success';
                case 'processing': return 'primary';
                case 'pending': return 'warning';
                case 'cancelled': return 'danger';
                default: return 'secondary';
            }
        }
    </script>
</body>
</html>