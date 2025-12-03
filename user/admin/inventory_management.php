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

        <h1 class="text-3xl font-bold text-gray-800 mb-6">Inventory Management</h1>

        <?php if (!empty($message)): ?>
            <div class="p-3 mb-4 rounded bg-green-100 text-green-700 border border-green-300">
                <?= $message ?>
            </div>
        <?php endif; ?>

        <div class="bg-white p-6 rounded-xl shadow border mb-10">
            <h2 class="text-xl font-semibold mb-4">Add New Inventory Item</h2>

            <form method="POST" action="inventory_management.php" class="space-y-4">
                <input type="hidden" id="product_id" name="id">

                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <label class="block font-medium mb-1">Item Name:</label>
                        <input type="text" id="item_name" name="item_name"
                            class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-500"
                            required>
                    </div>

                    <div>
                        <label class="block font-medium mb-1">Initial Quantity:</label>
                        <input type="number" id="qty" name="qty" value="0" min="0"
                            class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-500"
                            required>
                    </div>
                </div>

                <div>
                    <label class="block font-medium mb-1">Description (Optional):</label>
                    <textarea id="description" name="description" rows="2"
                        class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-500"></textarea>
                </div>

                <button type="submit"
                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                    Add Item to Stock
                </button>
            </form>

            <div class="flex gap-3 mt-4">
                <form action="../../backend/delete_item.php" method="POST">
                    <input type="hidden" id="delete_product_id" name="delete_id">
                    <button type="submit" id="deleteBtn" disabled
                        class="bg-red-500 text-white px-4 py-2 rounded disabled:opacity-40 disabled:cursor-not-allowed hover:bg-red-600 transition">
                        Delete
                    </button>
                </form>

                <button id="resetBtn" onclick="resetForm()" disabled
                    class="bg-gray-500 text-white px-4 py-2 rounded disabled:opacity-40 disabled:cursor-not-allowed hover:bg-gray-600 transition">
                    Reset
                </button>
            </div>
        </div>

        <h2 class="text-xl font-semibold mb-4">Current Stock Levels</h2>

        <?php if (isset($error_message)): ?>
            <div class="p-3 bg-red-100 text-red-700 border border-red-300 rounded">
                <?= $error_message ?>
            </div>

        <?php elseif (empty($items)): ?>
            <p class="text-gray-600 bg-white p-4 rounded shadow">The inventory is currently empty.</p>

        <?php else: ?>
            <div class="overflow-x-auto">
                <table class="w-full bg-white border rounded shadow">
                    <thead>
                        <tr class="bg-gray-200 text-left text-gray-700">
                            <th class="p-3">Item Name</th>
                            <th class="p-3">Description</th>
                            <th class="p-3">Stock</th>
                            <th class="p-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($items as $item): ?>
                            <tr class="border-b hover:bg-gray-50">
                                <td class="p-3"><?= htmlspecialchars($item['item_name']) ?></td>
                                <td class="p-3"><?= htmlspecialchars($item['description']) ?></td>
                                <td class="p-3 font-semibold"><?= htmlspecialchars($item['qty']) ?></td>
                                <td class="p-3 flex gap-3">

                                    <!-- Edit Button -->
                                    <button onclick="fillForm(
                                        <?= $item['id'] ?>,
                                        '<?= htmlspecialchars($item['item_name']) ?>',
                                        '<?= htmlspecialchars($item['description']) ?>',
                                        <?= $item['qty'] ?>
                                    )"
                                        class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600 transition">
                                        Edit
                                    </button>

                                    <!-- Delete Button -->
                                    <form action="../../backend/delete_item.php" method="POST">
                                        <input type="hidden" value="<?= $item['id'] ?>" name="delete_id">
                                        <button type="submit"
                                            class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 transition">
                                            Delete
                                        </button>
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
