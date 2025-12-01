<?php 
include "../../backend/sell.php";
// NOTE: I am assuming the variables $message, $customers, $items, and $sales are defined and populated in '../../backend/sell.php'
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mini ERP - Sales & CRM</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div class="container my-5">
        <h1 class="mb-4"><i class="bi bi-cart"></i> 🛒 Sales & Customer Management</h1>
        
        <?php if (!empty($message)): ?>
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <?php echo $message; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        
        <div class="row g-4 mb-5">
            <div class="col-md-6">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <h2 class="card-title mb-4">🛍️ Create New Sale</h2>
                        
                        <form method="POST" action="sales.php">
                            <input type="hidden" name="action" value="create_sale">

                            <div class="mb-3">
                                <label for="customer_id" class="form-label">Select Customer:</label>
                                <select id="customer_id" name="customer_id" class="form-select" required>
                                    <option value="">-- Select Customer --</option>
                                    <?php foreach ($customers as $customer): ?>
                                        <option value="<?php echo htmlspecialchars($customer['id']); ?>">
                                            <?php echo htmlspecialchars($customer['name']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="item_id" class="form-label">Select Item:</label>
                                <select id="item_id" name="item_id" class="form-select" required>
                                    <option value="">-- Select Item --</option>
                                    <?php foreach ($items as $item): 
                                        $stock_info = isset($item['qty']) ? " (Stock: " . htmlspecialchars($item['qty']) . ")" : "";
                                    ?>
                                        <option value="<?php echo htmlspecialchars($item['id']); ?>">
                                            <?php echo htmlspecialchars($item['item_name']) . $stock_info; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="qty" class="form-label">Quantity Sold:</label>
                                <input type="number" id="qty" name="qty" class="form-control" required min="1" value="1">
                            </div>

                            <button type="submit" class="btn btn-primary w-100">Record Sale</button>
                        </form>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <h2 class="card-title mb-4">👥 Add New Customer</h2>
                        
                        <form method="POST" action="sales.php">
                            <input type="hidden" name="action" value="add_customer">

                            <div class="mb-3">
                                <label for="customer_name" class="form-label">Name:</label>
                                <input type="text" id="customer_name" name="customer_name" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="customer_phone" class="form-label">Phone (Optional):</label>
                                <input type="text" id="customer_phone" name="customer_phone" class="form-control">
                                <div class="form-text">e.g., +1 555 123 4567</div>
                            </div>
                            
                            <button type="submit" class="btn btn-success w-100">Add Customer</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        <hr>
        
        <div class="mt-5">
            <h2 class="mb-3">🧾 Recent Sales History</h2>
            
            <div class="card shadow-sm">
                <div class="card-body">
                    <p class="text-muted">
                        *Add the PHP code here to fetch and display the sales data in a table.*
                        <br>
                        Example:
                    </p>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>Sale ID</th>
                                    <th>Customer Name</th>
                                    <th>Item Sold</th>
                                    <th>Quantity</th>
                                    <th>Sale Date</th>
                                    <th>Total Price (e.g.)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1001</td>
                                    <td>John Doe</td>
                                    <td>Widget A</td>
                                    <td>2</td>
                                    <td>2025-11-30</td>
                                    <td>$49.98</td>
                                </tr>
                                <tr>
                                    <td>1002</td>
                                    <td>Jane Smith</td>
                                    <td>Gadget B</td>
                                    <td>1</td>
                                    <td>2025-11-30</td>
                                    <td>$129.99</td>
                                </tr>
                                </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>