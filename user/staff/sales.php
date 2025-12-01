<?php 
include "../../backend/sell.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Mini ERP - Sales & CRM</title>
</head>
<body>
    <h1>🛒 Sales & Customer Management</h1>
    
    <?php echo $message; // Display status messages ?>
    
    <div style="display: flex; gap: 40px;">

        <div>
            <h2>🛍️ Create New Sale</h2>
            <form method="POST" action="sales.php">
                <input type="hidden" name="action" value="create_sale">

                <div>
                    <label for="customer_id">Select Customer:</label>
                    <select id="customer_id" name="customer_id" required>
                        <option value="">-- Select Customer --</option>
                        <?php foreach ($customers as $customer): ?>
                            <option value="<?php echo htmlspecialchars($customer['id']); ?>">
                                <?php echo htmlspecialchars($customer['name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div>
                    <label for="item_id">Select Item:</label>
                    <select id="item_id" name="item_id" required>
                        <option value="">-- Select Item --</option>
                        <?php foreach ($items as $item): ?>
                            <option value="<?php echo htmlspecialchars($item['id']); ?>">
                                <?php echo htmlspecialchars($item['item_name']) . " (Stock: " . htmlspecialchars($item['qty']) . ")"; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div>
                    <label for="qty">Quantity Sold:</label>
                    <input type="number" id="qty" name="qty" required min="1" value="1">
                </div>

                <button type="submit">Record Sale</button>
            </form>
        </div>
        
        <div>
            <h2>👥 Add New Customer</h2>
            <form method="POST" action="sales.php">
                <input type="hidden" name="action" value="add_customer">

                <div>
                    <label for="customer_name">Name:</label>
                    <input type="text" id="customer_name" name="customer_name" required>
                </div>

                <div>
                    <label for="customer_phone">Phone (Optional):</label>
                    <input type="text" id="customer_phone" name="customer_phone">
                </div>
                
                <button type="submit">Add Customer</button>
            </form>
        </div>
    </div>
    
    <hr>
    
    <div>
                        <table>
                            <thead>
                                <tr>
                                    <th>Customer Name</th>
                                    <th>Item Sold</th>
                                    <th>Quantity</th>
                                    <th>Sale Date</th>
                                    <th>Total Price (e.g.)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($sales_history as $sale): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($sale['customer_name']); ?></td>
                                    <td><?php echo htmlspecialchars($sale['item_name']); ?></td>
                                    <td><?php echo htmlspecialchars($sale['quantity_sold']); ?></td>
                                    <td><?php echo htmlspecialchars($sale['date_created']); ?></td>
                                    <td><?php echo htmlspecialchars($sale['customer_name']); ?></td>
                                </tr>
                                <?php endforeach; ?>
                                </tbody>
                        </table>
                    </div>
    
</body>
</html>