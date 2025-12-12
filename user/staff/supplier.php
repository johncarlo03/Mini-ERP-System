<?php
include "../../backend/supplier.php";

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
    <title>Mini ERP - Supplier & PO Management</title>
    <link rel="stylesheet" href="../../css/admin.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="../../script/sidebar.js" defer></script>
    <script src="../../script/supplier.js" defer></script>
    <style>

    </style>
</head>

<body class="bg-gray-100">
    <input type="hidden" id="sidebar_state_input" name="sidebar_state" value="expanded">
    <?php include "sidebar.php"; ?>

    <div id="mainContent" class="ml-64 p-10 <?= $initial_margin_class ?> fade-in-content">

        <h1 class="text-3xl font-bold text-gray-800 mb-8">Supplier & Purchase Order Management</h1>

        <?php if (!empty($err_message)): ?>
            <div class="p-3 mb-4 rounded bg-red-100 text-red-700 border border-red-300">
                <?= $err_message ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($message)): ?>
            <div class="p-3 mb-4 rounded bg-green-100 text-green-700 border border-green-300">
                <?= $message ?>
            </div>
        <?php endif; ?>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-10">

            <div
                class="bg-white p-6 rounded-xl shadow-lg border transition duration-300 hover:shadow-2xl hover:scale-[1.01]">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-semibold mb-4 text-gray-700">Add New Supplier</h2>

                    <button type="button" onclick="openEditSupplierModal()"
                        class="bg-green-500 text-white font-semibold py-1 px-3 rounded-lg hover:bg-green-600 transition duration-150 shadow-sm text-sm transform hover:scale-[1.05]">
                        Edit Existing supplier
                    </button>
                </div>

                <form method="POST" action="supplier.php" class="space-y-4">
                    <input type="hidden" name="action" value="add_supplier">

                    <input name="supplier_name" type="text" placeholder="Supplier Name"
                        class="w-full border rounded px-4 py-2 focus:ring-2 focus:ring-blue-500 transition duration-150"
                        required>

                    <input name="supplier_phone" type="number" placeholder="Phone Number"
                        class="w-full border rounded px-4 py-2 focus:ring-2 focus:ring-blue-500 transition duration-150"
                        required>

                    <button type="submit"
                        class="w-full bg-blue-600 text-white font-semibold px-4 py-2 rounded-lg hover:bg-blue-700 transition duration-150 transform hover:scale-[1.01]">
                        Register Supplier
                    </button>
                </form>
            </div>

            <div
                class="bg-white p-6 rounded-xl shadow-lg border transition duration-300 hover:shadow-2xl hover:scale-[1.01]">
                <h2 class="text-xl font-semibold mb-4 text-gray-700">Create Purchase Order</h2>
                <form method="POST" action="supplier.php" class="space-y-4">
                    <input type="hidden" name="action" value="create_po">

                    <select name="supplier_id"
                        class="w-full border rounded px-4 py-2 focus:ring-2 focus:ring-indigo-500 transition duration-150"
                        required>
                        <option value="">Select Supplier</option>
                        <?php foreach ($suppliers as $supplier): ?>
                            <option value="<?php echo htmlspecialchars($supplier['id']); ?>">
                                <?php echo htmlspecialchars($supplier['supplier_name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>

                    <select name="item_id"
                        class="w-full border rounded px-4 py-2 focus:ring-2 focus:ring-indigo-500 transition duration-150"
                        required>
                        <option value="">Select Inventory Item</option>
                        <?php foreach ($inventory as $item): ?>
                            <option value="<?php echo htmlspecialchars($item['id']); ?>">
                                <?php echo htmlspecialchars($item['item_name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>

                    <input type="number" placeholder="Quantity" name="qty" min="1"
                        class="w-full border rounded px-4 py-2 focus:ring-2 focus:ring-indigo-500 transition duration-150"
                        required>

                    <button type="submit"
                        class="w-full bg-indigo-600 text-white font-semibold px-4 py-2 rounded-lg hover:bg-indigo-700 transition duration-150 transform hover:scale-[1.01]">
                        Submit Purchase Order
                    </button>
                </form>
            </div>
        </div>

        <h2 class="text-2xl font-bold text-gray-800 mb-4">📝 Pending & Completed Purchase Orders</h2>

        <?php if (empty($purchase_orders)): ?>
            <p class="text-gray-600 bg-white p-4 rounded-lg shadow-md">No purchase orders have been created yet.</p>
        <?php else: ?>
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    PO ID</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Supplier</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Item</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Qty</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Date Created</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Date Received</th>
                                <th
                                    class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Action</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php foreach ($purchase_orders as $po): ?>
                                <tr class="hover:bg-blue-50/50 transition duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        <?php echo htmlspecialchars($po['po_id']); ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        <?php echo htmlspecialchars($po['supplier_name']); ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        <?php echo htmlspecialchars($po['item_name']); ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        <?php echo htmlspecialchars($po['qty']); ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <?php
                                        $status_class = $po['status'] === 'Pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800';
                                        ?>
                                        <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?= $status_class ?>">
                                            <?php echo htmlspecialchars($po['status']); ?>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        <?php echo htmlspecialchars($po['date_created']); ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        <?php if ($po['date_received'] === NULL): ?>
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?= $status_class ?>">
                                                <?php echo htmlspecialchars($po['status']); ?>

                                            <?php else: ?>
                                                <?php echo htmlspecialchars($po['date_created']); ?>
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-center">
                                        <?php if ($po['status'] === 'Pending'): ?>
                                            <form method="POST" style="display:inline;">
                                                <input type="hidden" name="action" value="receive_po">
                                                <input type="hidden" name="po_id" value="<?php echo $po['po_id']; ?>">
                                                <button type="submit"
                                                    class="text-white bg-green-500 hover:bg-green-600 font-semibold py-1 px-3 rounded text-xs transition duration-150 transform hover:scale-[1.05]">
                                                    Receive Stock
                                                </button>
                                            </form>
                                        <?php else: ?>
                                            <span class="text-green-500 font-semibold">Received</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <div id="supplierEditModal"
        class="fixed inset-0 bg-gray-900 bg-opacity-75 hidden items-center justify-center z-50 p-4 transition-opacity duration-300">
        <div
            class="bg-white rounded-xl shadow-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto modal-content-animation">
            <div class="p-6 border-b flex justify-between items-center sticky top-0 bg-white z-10">
                <h3 class="text-2xl font-bold text-gray-800">Edit Supplier Details</h3>
                <button onclick="closeEditSupplierModal()"
                    class="text-gray-500 hover:text-gray-900 text-xl font-bold transition duration-150 transform hover:scale-[1.1]">&times;</button>
            </div>

            <div class="p-6 space-y-4">

                <div>
                    <label for="edit_supplier_select" class="block text-sm font-medium text-gray-700 mb-1">Select
                        Supplier to Edit</label>
                    <select id="edit_supplier_select" onchange="loadSupplierDetails(this.value)"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 bg-white">
                        <option value="">Select Supplier</option>
                        <?php foreach ($suppliers as $supplier): ?>
                            <option value="<?php echo htmlspecialchars($supplier['id']); ?>"
                                data-name="<?php echo htmlspecialchars($supplier['supplier_name']); ?>"
                                data-phone="<?php echo htmlspecialchars($supplier['phone']); ?>">
                                <?php echo htmlspecialchars($supplier['supplier_name']) . " (" . htmlspecialchars($supplier['phone']) . ")"; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <form id="supplier_edit_form" method="POST" action="supplier.php"
                    class="space-y-4 border-t pt-4 mt-4 hidden">
                    <input type="hidden" name="action" value="edit_supplier">
                    <input type="hidden" id="edit_supplier_id" name="supplier_id">

                    <div>
                        <label for="edit_supplier_name"
                            class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                        <input type="text" id="edit_supplier_name" name="supplier_name" required
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label for="edit_supplier_phone"
                            class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                        <input type="text" id="edit_supplier_phone" name="supplier_phone"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500">
                    </div>

                    <button type="submit" value="edit" name="supplier_action"
                        class="w-full bg-blue-600 text-white font-semibold py-2 rounded-lg hover:bg-blue-700 transition duration-200 shadow-md transform hover:scale-[1.01]">
                        Save Changes
                    </button>
                    <button type="button" value="delete" name="supplier_action"
                        onclick="confirmDelete(document.getElementById('edit_supplier_id').value)"
                        class="w-full bg-red-600 text-white font-semibold py-2 rounded-lg hover:bg-red-700 transition duration-200 shadow-md transform hover:scale-[1.01]">
                        Delete supplier
                    </button>
                </form>
                <form method="POST" action="supplier.php" id="deleteSupplierForm">
                    <input type="hidden" name="action" value="edit_supplier">
                    <input type="hidden" value="delete" name="supplier_action">
                    <input type="hidden" id="delete_supplier_id" name="supplier_id">
                </form>
            </div>
        </div>
    </div>

    <script>

    </script>
</body>

</html>