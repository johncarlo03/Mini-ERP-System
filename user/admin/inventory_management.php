<?php
include "../../backend/inventory.php";
if (!isset($_SESSION['id']) || $_SESSION['roles'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Mini ERP - Inventory Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../../script/inventory.js"></script>
    <script src="../../script/sidebar.js" defer></script>
    <link rel="stylesheet" href="../../css/admin.css">
</head>
<body class="bg-gray-100">
    <input type="hidden" id="sidebar_state_input" name="sidebar_state" value="expanded">
    <?php include "sidebar.php"; ?>

    <div class="ml-64 p-10 <?= $initial_margin_class ?> fade-in-content">
        <h1 class="text-3xl font-bold mb-8 text-gray-800">Inventory Management</h1>

        <?php if (!empty($message)): ?>
            <div class="p-3 mb-4 rounded bg-green-100 text-green-700 border border-green-300 transition duration-300 transform translate-y-0 opacity-100">
                <?= $message ?>
            </div>
        <?php endif; ?>

        <div class="bg-white p-6 rounded-xl shadow border mb-10 transition duration-300 hover:shadow-2xl">
            <h2 class="text-xl font-semibold mb-4">Add New Inventory Item</h2>

            <div class="flex justify-end space-x-3 mb-6">
                <button id="resetBtn" onclick="resetForm()" hidden
                    class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition duration-200 transform hover:scale-[1.03]">
                    Cancel Edit / Create New
                </button>
                <button type="button" id="deleteBtn" hidden
                    onclick="confirmDelete(document.getElementById('delete_product_id').value)"
                    class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition duration-200 transform hover:scale-[1.03]">
                    Delete Item
                </button>

                <form action="../../backend/delete_item.php" method="POST" id="deleteForm">
                    <input type="hidden" name="action" value="delete_item">
                    <input type="hidden" id="delete_product_id" name="delete_id">
                </form>
            </div>
            
            <form method="POST" action="inventory_management.php" class="space-y-4" enctype="multipart/form-data">
                <input type="hidden" id="product_id" name="id">

                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <input type="text" id="item_name" name="item_name" placeholder="Item Name"
                            class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-500 transition duration-150" required>
                    </div>
                    <div>
                        <input type="number" id="item_price" name="item_price" placeholder="Price" step="0.01"
                            class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-500 transition duration-150" required>
                    </div>
                    <div>
                        <input type="number" id="qty" name="qty" min="0" placeholder="Initial Quantity"
                            class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-500 transition duration-150" required>
                    </div>

                    <div>
                        <input type="file" id="product_image_upload" name="product_image" accept="image/*"
                            class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-500 transition duration-150">
                    </div>

                    <input type="hidden" id="existing_image_path" name="existing_image_path">

                    <div id="image_preview_container" class="mt-2" style="display: none;">
                        <p class="text-sm font-medium text-gray-700">Current Image:</p>
                        <img id="current_image_preview" src="" alt="Current Product Image"
                            class="w-20 h-20 object-cover rounded border transition duration-300">
                    </div>
                </div>

                <div>
                    <textarea id="description" name="description" rows="2" placeholder="Description (Optional)"
                        class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-500 transition duration-150"></textarea>
                </div>

                <button type="submit" id="submitBtn"
                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition duration-200 transform hover:scale-[1.01]">
                    Add Item to Stock
                </button>
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
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Image
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Item
                                Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Description</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stock
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price
                            </th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php foreach ($items as $item): ?>
                            <tr class="transition duration-150 hover:bg-blue-50/50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <img src="<?= htmlspecialchars($item['image_path']) ?>"
                                        alt="<?= htmlspecialchars($item['item_name']) ?>"
                                        class="w-12 h-12 object-cover rounded-md border border-gray-200 transition duration-150 hover:shadow-lg hover:border-blue-300">
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <?= htmlspecialchars($item['item_name']) ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <?= htmlspecialchars($item['description']) ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <?= htmlspecialchars($item['qty']) ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <?= htmlspecialchars($item['price']) ?></td>
                                <td class="px-6 text-center py-4 whitespace-nowrap text-sm font-medium">
                                    <button onclick="fillForm(
                                        <?= $item['id'] ?>,
                                        '<?= htmlspecialchars($item['item_name']) ?>',
                                        '<?= htmlspecialchars($item['description']) ?>',
                                        '<?= htmlspecialchars($item['price']) ?>',
                                        '<?= htmlspecialchars($item['image_path']) ?>',
                                        <?= $item['qty'] ?>
                                    )"
                                        class="text-white bg-blue-500 hover:bg-blue-600 font-semibold py-1 px-3 shadow-md hover:shadow-lg rounded text-xs transition duration-150 transform hover:scale-[1.05]">
                                        Edit
                                    </button>

                                    <button onclick="confirmDelete(<?= $item['id'] ?>)" type="button"
                                        class="text-white bg-red-500 hover:bg-red-700 font-semibold py-1 px-3 rounded text-xs transition duration-150 transform hover:scale-[1.05] ml-2">
                                        Delete
                                    </button>

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