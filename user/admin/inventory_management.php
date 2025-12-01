<?php

include "../../backend/inventory.php";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Mini ERP - Inventory Management</title>
</head>
<body>
    <device>
        <h1>Inventory Management</h1>

        <?php echo $message; ?>
        
        <div>
            <h2>Add New Inventory Item</h2>
            <form method="POST" action="inventory_management.php">
                <!-- <input type="hidden" name="action" value="add_item"> -->
                <div>
                    <input type="hidden" id="product_id" name="id">
                    <div>
                        <label for="item_name">Item Name:</label>
                        <input type="text" id="item_name" name="item_name" required>
                    </div>
                    <div class="form-group" style="flex: 1;">
                        <label for="qty">Initial Quantity:</label>
                        <input type="number" id="qty" name="qty" required value="0" min="0">
                    </div>
                </div>

                <div>
                    <label for="description">Description (Optional):</label>
                    <textarea id="description" name="description" rows="2"></textarea>
                </div>

                <button type="submit">Add Item to Stock</button>
            </form>

            <form action="../../backend/delete_item.php" method="POST">
                <input type="hidden" id="delete_product_id" name="delete_id">
                <button type="submit"  id="deleteBtn" disabled>Delete</button>
                </form>
                <button id="resetBtn" onclick="resetForm()" disabled>Reset</button>

        </div>

        <hr>

        <h2>Current Stock Levels</h2>

        <?php if (isset($error_message)): ?>
            <div>
                <?php echo $error_message; ?>
            </div>
        <?php elseif (empty($items)): ?>
            <div>
                <p>The inventory is currently empty. Please use the form above to add an item.</p>
            </div>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>Item Name</th>
                        <th>Description</th>
                        <th>Stock</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($items as $item): ?>
                            <td><?php echo htmlspecialchars($item['item_name']); ?></td>
                            <td><?php echo htmlspecialchars($item['description']); ?></td>
                            <td><?php echo htmlspecialchars($item['qty']); ?></td>
                            <td>
                                    <button onclick="fillForm(
                                    <?php echo htmlspecialchars($item['id']); ?>, 
                                    '<?php echo htmlspecialchars($item['item_name']); ?>', 
                                    '<?php echo htmlspecialchars($item['description']); ?>', 
                                    <?php echo htmlspecialchars($item['qty']); ?>
                                )">
                                    Edit
                                </button>
                                 <form action="../../backend/delete_item.php" method="POST">
                                    <input type="hidden" value="<?php echo htmlspecialchars($item['id']); ?>"name="delete_id">
                                    <button type="submit">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>

    <script>
    function fillForm(id, name, description, qty) {
    document.getElementById('product_id').value = id;
    document.getElementById('item_name').value = name;
    document.getElementById('description').value = description;
    // document.getElementById('product-price').value = price;
    document.getElementById('qty').value = qty;
    document.getElementById('delete_product_id').value = id;
    document.getElementById('deleteBtn').disabled = false;
    document.getElementById('resetBtn').disabled = false;
    }

    function resetForm() {
document.getElementById('delete_product_id').value = '';
document.getElementById('product_id').value = '';
document.getElementById('item_name').value = '';
document.getElementById('description').value = '';
document.getElementById('qty').value = '';
document.getElementById('deleteBtn').disabled = true;
document.getElementById('resetBtn').disabled = true;
}
    </script>
</body>
</html>