<?php 
include "../../backend/audit.php";
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

    <div class="flex justify-between items-center mb-6">
    <h1 class="text-3xl font-bold text-gray-800">Logs</h1>
    <form method="GET" class="flex items-center gap-2">
    <label class="block text-gray-700 font-semibold">Filter by Action</label>
    <select id="actionFilter" name="action" onchange="this.form.submit()" class="border rounded px-3 py-2 w-64">
        <option value="" <?php if (empty($selected_action)) echo 'selected'; ?>>All Actions</option>

        <optgroup label="User Actions">
            <option value="logged in" <?php if ($selected_action === 'logged in') echo 'selected'; ?>>Login</option>
            <option value="logged out" <?php if ($selected_action === 'logged out') echo 'selected'; ?>>Logout</option>
        </optgroup>

        <optgroup label="Inventory Actions">
            <option value="added item" <?php if ($selected_action === 'added item') echo 'selected'; ?>>Add Item</option>
            <option value="inventory update" <?php if ($selected_action === 'inventory update') echo 'selected'; ?>>Update Item</option>
            <option value="deleted item" <?php if ($selected_action === 'deleted item') echo 'selected'; ?>>Delete Item</option>
        </optgroup>

        <optgroup label="Staff Management">
            <option value="created an account" <?php if ($selected_action === 'created an account') echo 'selected'; ?>>Create User</option>
            <option value="updated an account" <?php if ($selected_action === 'updated an account') echo 'selected'; ?>>Update User</option>
            <option value="deleted user" <?php if ($selected_action === 'deleted user') echo 'selected'; ?>>Delete User</option>
        </optgroup>

        <optgroup label="Purchase Order">
            <option value="received po" <?php if ($selected_action === 'received po') echo 'selected'; ?>>Received Order</option>
            <option value="created po" <?php if ($selected_action === 'created po') echo 'selected'; ?>>Created Order</option>
        </optgroup>
    </select>
    </form>
</div>

<div class="bg-white rounded-lg shadow-xl overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-200" style="table-layout: fixed;">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" style="width: 10%;">Log ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" style="width: 25%;">Username</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" style="width: 45%;">Action</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" style="width: 20%;">Date & Time</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php foreach ($logs as $log): ?>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo htmlspecialchars($log['id']); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo htmlspecialchars($log['name']); ?></td>
                        <td class="px-6 py-4 text-sm text-gray-500 whitespace-normal break-words"><?php echo htmlspecialchars($log['action']); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo htmlspecialchars($log['date_time']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        </div>
        <div class="mt-8 flex justify-center">
        <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
            
            <?php if ($current_page > 1): ?>
                <a href="?page=<?php echo $current_page - 1; ?>" 
                   class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-l-md text-gray-700 bg-white hover:bg-gray-50">
                    Previous
                </a>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <a href="?page=<?php echo $i; ?>" 
                   class="<?php echo ($i == $current_page) ? 'bg-indigo-500 text-white' : 'bg-white text-gray-700 hover:bg-gray-50'; ?> 
                          relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium">
                    <?php echo $i; ?>
                </a>
            <?php endfor; ?>

            <?php if ($current_page < $total_pages): ?>
                <a href="?page=<?php echo $current_page + 1; ?>" 
                   class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-r-md text-gray-700 bg-white hover:bg-gray-50">
                    Next
                </a>
            <?php endif; ?>

        </nav>
    </div>
    </div>

    <!-- <script>
document.addEventListener("DOMContentLoaded", function () {
    const filterDropdown = document.getElementById("actionFilter");
    const rows = document.querySelectorAll("tbody tr");

    filterDropdown.addEventListener("change", function () {
        const selected = this.value.toLowerCase();

        rows.forEach(row => {
            const actionText = row.children[2].textContent.toLowerCase();

            if (!selected || actionText.includes(selected)) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        });
    });
});
</script> -->

</body>
</html>