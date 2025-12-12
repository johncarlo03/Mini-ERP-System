<?php
include "../../backend/sell.php";
if (!isset($_SESSION['id']) || $_SESSION['roles'] !== 'staff') {
    header("Location: ../login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales & Customer Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="../../css/admin.css">
    <script src="../../script/sidebar.js" defer></script>
    <script src="../../script/sales_modal.js" defer></script>
</head>

<body class="bg-gray-100">

    <input type="hidden" id="sidebar_state_input" name="sidebar_state" value="expanded">
    <?php include "sidebar.php"; ?>
    <div id="mainContent" class="ml-64 p-10 <?= $initial_margin_class ?>">

        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800 flex items-center gap-2">
                <span class="text-indigo-600">🛒</span> Sales & Customer Management
            </h1>
        </div>

        <?php if (!empty($message)): ?>
            <div class="p-3 mb-6 rounded-lg bg-green-100 text-green-700 border border-green-300 shadow-sm">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($err_message)): ?>
            <div class="p-3 mb-6 rounded-lg bg-red-100 text-red-700 border border-red-300 shadow-sm">
                <?php echo $err_message; ?>
            </div>
        <?php endif; ?>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-12">

            <div class="bg-white p-6 rounded-xl shadow-lg border-t-4 border-indigo-500">
                <h2 class="text-xl font-semibold mb-4 text-gray-800">🛍️ Record New Sale</h2>
                <form method="POST" action="sales.php" class="space-y-4">
                    <input type="hidden" name="action" value="create_sale">

                    <div>
                        <label for="customer_id" class="block text-sm font-medium text-gray-700 mb-1">Select
                            Customer</label>
                        <select id="customer_id" name="customer_id" required
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 bg-white">
                            <option value="">Select Customer</option>
                            <?php foreach ($customers as $customer): ?>
                                <option value="<?php echo htmlspecialchars($customer['id']); ?>">
                                    <?php echo htmlspecialchars($customer['name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div>
                        <label for="selected_item_display" class="block text-sm font-medium text-gray-700 mb-1">Item to
                            Sell</label>
                        <div class="flex space-x-2">
                            <input type="text" id="selected_item_display" placeholder="Click Select Item to Choose"
                                readonly
                                class="flex-grow border border-gray-300 rounded-lg px-3 py-2 bg-gray-50 focus:outline-none cursor-pointer">

                            <input type="hidden" id="item_id_hidden" name="item_id" required>

                            <input type="hidden" id="item_price_hidden" name="item_price">

                            <button type="button" onclick="openItemModal()"
                                class="bg-indigo-500 text-white px-4 py-2 rounded-lg hover:bg-indigo-600 transition shadow-sm flex-shrink-0">
                                Select Item
                            </button>
                        </div>
                    </div>

                    <div>
                        <label for="qty" class="block text-sm font-medium text-gray-700 mb-1">Quantity Sold</label>
                        <input type="number" id="qty" name="qty" required min="1" value="1"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500">
                    </div>

                    <button type="submit"
                        class="w-full bg-indigo-600 text-white font-semibold py-2 rounded-lg hover:bg-indigo-700 transition duration-200 shadow-md">
                        Record Sale
                    </button>
                </form>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-lg border-t-4 border-green-500">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-semibold text-gray-800">👥 Add New Customer</h2>

                    <button type="button" onclick="openEditCustomerModal()"
                        class="bg-green-500 text-white font-semibold py-1 px-3 rounded-lg hover:bg-green-600 transition shadow-sm text-sm">
                        Edit Existing Customer
                    </button>
                </div>
                <form method="POST" action="sales.php" class="space-y-4">
                    <input type="hidden" name="action" value="add_customer">

                    <div>
                        <label for="customer_name" class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                        <input type="text" id="customer_name" name="customer_name" required
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500">
                    </div>

                    <div>
                        <label for="customer_phone" class="block text-sm font-medium text-gray-700 mb-1">Phone
                            (Optional)</label>
                        <input type="text" id="customer_phone" name="customer_phone"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500">
                    </div>

                    <button type="submit"
                        class="w-full bg-green-600 text-white font-semibold py-2 rounded-lg hover:bg-green-700 transition duration-200 shadow-md">
                        Add Customer
                    </button>
                </form>
            </div>
        </div>

        <h2 class="text-2xl font-semibold mb-4 text-gray-700">Recent Sales History (10)</h2>
        <div class="bg-white rounded-lg shadow-xl overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Customer Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Item
                            Sold</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Quantity</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sale
                            Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total
                            Price</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php if (!empty($sales_history)): ?>
                        <?php foreach ($sales_history as $sale): ?>
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    <?php echo htmlspecialchars($sale['customer_name']); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <?php echo htmlspecialchars($sale['item_name']); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <?php echo htmlspecialchars($sale['quantity_sold']); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <?php echo htmlspecialchars($sale['sale_date_formatted']); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-green-600 font-semibold">
                                    <?php
                                    // Assuming 'total_price' is available and needs formatting
                                    if (isset($sale['total_amount'])) {
                                        echo '₱ ' . number_format($sale['total_amount'], 2);
                                    } else {
                                        // Fallback if total_price is missing, use a placeholder column from original code
                                        echo 'N/A';
                                    }
                                    ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">No sales records found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

    </div>

    <div id="itemModal" class="fixed inset-0 bg-gray-900 bg-opacity-75 hidden items-center justify-center z-50 p-4">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-3xl max-h-[90vh] overflow-y-auto">
            <div class="p-6 border-b flex justify-between items-center sticky top-0 bg-white z-10">
                <h3 class="text-2xl font-bold text-gray-800">Choose Inventory Item</h3>
                <button onclick="closeItemModal()"
                    class="text-gray-500 hover:text-gray-900 text-xl font-bold">&times;</button>
            </div>
            <div class="p-6">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Image</th>

                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Item Name</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Price</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Stock</th>
                            <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase">Action</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php foreach ($items as $item):
                            $stock_status = ($item['qty'] <= 0) ? 'text-red-600' : 'text-green-600';
                            // Determine image source, use a placeholder if none is set
                            $image_src = !empty($item['image_path']) ? htmlspecialchars($item['image_path']) : '../../images/placeholder.jpg';
                            ?>
                            <tr class="hover:bg-indigo-50/50">
                                <td class="px-4 py-2 text-sm">
                                    <img src="<?= $image_src ?>" alt="<?= htmlspecialchars($item['item_name']) ?>"
                                        class="w-12 h-12 object-cover rounded-md border border-gray-200">
                                </td>

                                <td class="px-4 py-2 text-sm font-medium text-gray-900">
                                    <?php echo htmlspecialchars($item['item_name']); ?></td>
                                <td class="px-4 py-2 text-sm text-gray-700 font-semibold">₱
                                    <?php echo number_format($item['price'], 2); ?></td>
                                <td class="px-4 py-2 text-sm font-medium <?= $stock_status ?>">
                                    <?php echo htmlspecialchars($item['qty']); ?>
                                </td>
                                <td class="px-4 py-2 text-center">
                                    <?php if ($item['qty'] > 0): ?>
                                        <button type="button" onclick="selectItem(
                                                <?= $item['id'] ?>, 
                                                '<?= htmlspecialchars($item['item_name']) ?>', 
                                                <?= $item['price'] ?>
                                            )"
                                            class="bg-green-500 text-white px-3 py-1 rounded text-xs hover:bg-green-600 transition">
                                            Select
                                        </button>
                                    <?php else: ?>
                                        <span class="text-xs text-red-500">Out of Stock</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div id="customerEditModal"
        class="fixed inset-0 bg-gray-900 bg-opacity-75 hidden items-center justify-center z-50 p-4">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto">
            <div class="p-6 border-b flex justify-between items-center sticky top-0 bg-white z-10">
                <h3 class="text-2xl font-bold text-gray-800">✍️ Edit Customer Details</h3>
                <button onclick="closeEditCustomerModal()"
                    class="text-gray-500 hover:text-gray-900 text-xl font-bold">&times;</button>
            </div>

            <div class="p-6 space-y-4">

                <div>
                    <label for="edit_customer_select" class="block text-sm font-medium text-gray-700 mb-1">Select
                        Customer to Edit</label>
                    <select id="edit_customer_select" onchange="loadCustomerDetails(this.value)"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 bg-white">
                        <option value="">Select Customer</option>
                        <?php foreach ($customers as $customer): ?>
                            <option value="<?php echo htmlspecialchars($customer['id']); ?>"
                                data-name="<?php echo htmlspecialchars($customer['name']); ?>"
                                data-phone="<?php echo htmlspecialchars($customer['phone']); ?>">
                                <?php echo htmlspecialchars($customer['name']) . " (" . htmlspecialchars($customer['phone']) . ")"; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <form id="customer_edit_form" method="POST" action="sales.php"
                    class="space-y-4 border-t pt-4 mt-4 hidden">
                    <input type="hidden" name="action" value="edit_customer">
                    <input type="name" id="edit_customer_id" name="customer_id">

                    <div>
                        <label for="edit_customer_name"
                            class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                        <input type="text" id="edit_customer_name" name="customer_name" required
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label for="edit_customer_phone"
                            class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                        <input type="text" id="edit_customer_phone" name="customer_phone"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500">
                    </div>

                    <button type="submit" value="edit" name="customer_action"
                        class="w-full bg-blue-600 text-white font-semibold py-2 rounded-lg hover:bg-blue-700 transition duration-200 shadow-md">
                        Save Changes
                    </button>
                    <button type="button" value="delete" name="customer_action"
                        onclick="confirmDelete(document.getElementById('edit_customer_id').value)"
                        class="w-full bg-red-600 text-white font-semibold py-2 rounded-lg hover:bg-red-700 transition duration-200 shadow-md">
                        Delete Customer
                    </button>
                </form>

                <form method="POST" action="sales.php" id="deleteCustomerForm">
                    <input type="hidden" name="action" value="edit_customer">
                    <input type="hidden" value="delete" name="customer_action">
                    <input type="hidden" id="delete_customer_id" name="customer_id">
                </form>

            </div>
        </div>
    </div>

</body>

</html>