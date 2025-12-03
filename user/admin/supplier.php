<?php

include "../../backend/supplier.php";

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../css/admin.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <?php include "sidebar.php"; ?>
    <div class="ml-64 p-10">
    <p><?php
    if (!empty($error_message)) {
        echo "<p style='color:red;'>$error_message</p>";
    } 
    ?></p> 
    <p>Add Supplier</p>
    <form method=POST action="supplier.php">
    <input type="hidden" name="action" value="add_supplier">

    <input name="supplier_name" type="text" placeholder="Supplier" required>
    <input name="supplier_phone" type="number" placeholder="Phone" required>
    <button type="submit">Add Supplier</button>
    </form>

    <br>

    <form method=POST action="supplier.php">
    <input type="hidden" name="action" value="create_po" required>
    <select name="supplier_id" id="">
        <option>Select Suppliers</option>
        <?php foreach ($suppliers as $supplier): ?>
            <option value="<?php echo htmlspecialchars($supplier['id']); ?>">
                <?php echo htmlspecialchars($supplier['supplier_name']); ?>
            </option>
        <?php endforeach; ?>
    </select>
    <select name="item_id"id="">
        <option>Select Item</option>
        <?php foreach ($inventory as $item): ?>
            <option value="<?php echo htmlspecialchars($item['id']); ?>">
                <?php echo htmlspecialchars($item['item_name']); ?>
            </option>
        <?php endforeach; ?>
    </select>

    <input type="number" placeholder="Quantity" name="qty">
    <button type="submit">Purchase Order</button>
    </form>

    <br>
    <?php echo $message; // Display status messages ?>
    <?php if (empty($purchase_orders)): ?>
            <p>No purchase orders have been created yet.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>PO ID</th>
                    <th>Supplier</th>
                    <th>Item</th>
                    <th>Qty</th>
                    <th>Status</th>
                    <th>Date Created</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($purchase_orders as $po): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($po['po_id']); ?></td>
                        <td><?php echo htmlspecialchars($po['supplier_name']); ?></td>
                        <td><?php echo htmlspecialchars($po['item_name']); ?></td>
                        <td><?php echo htmlspecialchars($po['qty']); ?></td>
                        <td><?php echo htmlspecialchars($po['status']); ?></td>
                        <td><?php echo htmlspecialchars($po['date_created']); ?></td>
                        <td>
                            <?php if ($po['status'] === 'Pending'): ?>
                                <form method="POST" style="display:inline;">
                                        <input type="hidden" name="action" value="receive_po">
                                        <input type="hidden" name="po_id" value="<?php echo $po['po_id']; ?>">
                                        <button type="submit">Receive Stock</button>
                                </form>
                            <?php else: ?>
                                Received
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    <?php endif; ?>
    </div>
</body>
</html>