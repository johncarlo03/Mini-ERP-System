<?php
include "../../backend/inventory.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Mini ERP - Inventory Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="../../script/inventory.js"></script>
    <link rel="stylesheet" href="../../css/admin.css">
</head>

<body class="bg-gray-100">

    <?php include "sidebar.php"; ?>

    <div class="ml-64 p-10">
        <h1 class="text-3xl font-bold mb-8 text-gray-800">Inventory Management</h1>

        <?php if (!empty($message)): ?>
            <div class="p-3 mb-4 rounded bg-green-100 text-green-700 border border-green-300">
                <?= $message ?>
            </div>
        <?php endif; ?>

        <div class="bg-white p-6 rounded-xl shadow border mb-10">
            <h2 class="text-xl font-semibold mb-4">Add New Inventory Item</h2>
            
            <div class="flex justify-end space-x-3 mb-6">
                <button id="resetBtn" onclick="resetForm()" hidden
                    class="px-4 py-2 bg-gray-500 text-white font-semibold rounded-lg hover:bg-gray-600 transition duration-200">
                    Cancel Edit / Create New
                </button>

                <form action="../../backend/delete_item.php" method="POST">
                    <input type="hidden" name="action" value="delete_item">
                    <input type="hidden" id="delete_product_id" name="delete_id">
                    <button type="submit" id="deleteBtn" hidden
                    class="px-4 py-2 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 transition duration-200">
                        Delete Item
                    </button>
                </form>
            </div>
            <form method="POST" action="inventory_management.php" class="space-y-4">
                <input type="hidden" id="product_id" name="id">

                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <input type="text" id="item_name" name="item_name" placeholder="Item Name"
                            class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-500"
                            required>
                    </div>

                    <div>
                        <input type="number" id="qty" name="qty" min="0" placeholder="Initial Quantity"
                            class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-500"
                            required>
                    </div>
                </div>

                <div>
                    <textarea id="description" name="description" rows="2" placeholder="Description (Optional)"
                        class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-500"></textarea>
                </div>

                <button type="submit" id="submitBtn"
                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">Add Item to Stock</button>
            </form>
        </div>

        <h2 class="text-xl font-semibold mb-4">Current Stock Levels</h2>

        <?php if (isset($error_message)): ?>
            <div class="p-3 bg-red-100 text-red-700 border border-red-300 rounded">
                <?= $error_message ?>
            </div>

        <?php elseif (empty($items)): ?>
            <p class="text-gray-600 bg-white p-4 rounded shadow">The inventory is currently empty.</p>

        <?php else: ?>
            <div class="bg-white rounded-lg shadow-xl overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Item Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stock</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php foreach ($items as $item): ?>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?= htmlspecialchars($item['item_name']) ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?= htmlspecialchars($item['description']) ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?= htmlspecialchars($item['qty']) ?></td>
                                <td class="px-6 text-center py-4 whitespace-nowrap text-sm font-medium">
                                    <!-- Edit Button -->
                                    <button onclick="fillForm(
                                        <?= $item['id'] ?>,
                                        '<?= htmlspecialchars($item['item_name']) ?>',
                                        '<?= htmlspecialchars($item['description']) ?>',
                                        <?= $item['qty'] ?>
                                    )"
                                        class="text-indigo-600 hover:text-indigo-900 font-semibold transition duration-150">
                                        Edit
                                    </button>

                                    <form action="../../backend/delete_item.php" method="POST" style="display:inline-block;  margin-left:5px;" class="text-red-600 hover:text-red-900 font-semibold transition duration-150">
                                        <input type="hidden" name="action" value="delete_item">
                                        <input type="hidden" value="<?= $item['id'] ?>" name="delete_id">
                                        <button type="submit">Delete</button>
                                    </form>

                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>


</body>

</html>
