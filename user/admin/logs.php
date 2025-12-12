<?php
include "../../backend/audit.php";
if (!isset($_SESSION['id']) || $_SESSION['roles'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../css/admin.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="../../script/sidebar.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .fade-in-content {
            animation: fadeIn 0.8s ease-out forwards;
        }
    </style>

</head>

<body>
    <input type="hidden" id="sidebar_state_input" name="sidebar_state" value="expanded">
    <?php include "sidebar.php"; ?>
    
    <div id="mainContent" class="ml-64 p-10 min-h-screen bg-gray-100 <?= $initial_margin_class ?> fade-in-content">

        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Logs</h1>
            
            <form method="GET" class="flex items-center gap-2">
                <label class="block text-gray-700 font-semibold">Filter by Action</label>
                <select id="actionFilter" name="action" onchange="this.form.submit()"
                    class="border rounded px-3 py-2 w-64 transition duration-200 hover:border-indigo-500 focus:ring-2 focus:ring-indigo-500">
                    <option value="" <?php if (empty($selected_action))
                        echo 'selected'; ?>>All Actions</option>

                    <optgroup label="User Actions">
                        <option value="logged in" <?php if ($selected_action === 'logged in')
                            echo 'selected'; ?>>Login
                        </option>
                        <option value="logged out" <?php if ($selected_action === 'logged out')
                            echo 'selected'; ?>>Logout
                        </option>
                    </optgroup>

                    <optgroup label="Inventory Actions">
                        <option value="added item" <?php if ($selected_action === 'added item')
                            echo 'selected'; ?>>Add
                            Item</option>
                        <option value="inventory update" <?php if ($selected_action === 'inventory update')
                            echo 'selected'; ?>>Update Item</option>
                        <option value="deleted item" <?php if ($selected_action === 'deleted item')
                            echo 'selected'; ?>>
                            Delete Item</option>
                    </optgroup>

                    <optgroup label="Account Management">
                        <option value="created an account" <?php if ($selected_action === 'created an account')
                            echo 'selected'; ?>>Create User</option>
                        <option value="updated user" <?php if ($selected_action === 'updated user')
                            echo 'selected'; ?>>
                            Update User</option>
                        <option value="deleted user" <?php if ($selected_action === 'deleted user')
                            echo 'selected'; ?>>
                            Delete User</option>
                    </optgroup>

                    <optgroup label="Sales Actions">
                        <option value="sold" <?php if ($selected_action === 'sold')
                            echo 'selected'; ?>>Sold Item</option>
                        <option value="customer" <?php if ($selected_action === 'customer')
                            echo 'selected'; ?>>Customers
                        </option>
                    </optgroup>

                    <optgroup label="Purchase Order">
                        <option value="received po" <?php if ($selected_action === 'received po')
                            echo 'selected'; ?>>
                            Received Order</option>
                        <option value="created po" <?php if ($selected_action === 'created po')
                            echo 'selected'; ?>>
                            Created Order</option>
                    </optgroup>
                </select>
            </form>
        </div>

        <div class="bg-white rounded-lg shadow-xl overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200" style="table-layout: fixed;">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                            style="width: 10%;">Log ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                            style="width: 25%;">Username</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                            style="width: 45%;">Action</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                            style="width: 20%;">Date & Time</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php foreach ($logs as $log): ?>
                        <tr class="transition duration-150 hover:bg-gray-50 hover:shadow-md">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?php echo htmlspecialchars($log['id']); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><span
                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                        <?php echo ($log['roles'] == 'admin') ? 'bg-indigo-100 text-indigo-800' : 'bg-green-100 text-green-800'; ?> transition duration-150 hover:scale-[1.05]">
                                    <?php echo htmlspecialchars($log['name']); ?>
                                </span></td>
                            <td class="px-6 py-4 text-sm text-gray-500 whitespace-normal break-words">
                                <?php echo htmlspecialchars($log['action']); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?php echo htmlspecialchars($log['date_time']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="mt-8 flex justify-center">
            <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">

                <?php 
                $max_links = 3; 
                $start_page = max(1, $current_page - floor($max_links / 2));
                $end_page = min($total_pages, $current_page + floor($max_links / 2));

                if ($end_page - $start_page + 1 < $max_links) {
                    if ($start_page > 1) {
                        $start_page = max(1, $start_page - ($max_links - ($end_page - $start_page + 1)));
                    } elseif ($end_page < $total_pages) {
                        $end_page = min($total_pages, $end_page + ($max_links - ($end_page - $start_page + 1)));
                    }
                }
                
                ?>

                <?php if ($current_page > 1): ?>
                    <a href="?page=<?php echo $current_page - 1 . $filter_param; ?>"
                        class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-l-md text-gray-700 bg-white hover:bg-indigo-500 hover:text-white transition duration-150">
                        Previous
                    </a>
                <?php endif; ?>

                <?php 
                if ($start_page > 1) {
                    ?>
                    <a href="?page=1<?php echo $filter_param; ?>" class="bg-white text-gray-700 hover:bg-gray-100 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium transition duration-150">1</a>
                    <?php
                    if ($start_page > 2) {
                        ?>
                        <span class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-gray-700 text-sm font-medium">...</span>
                        <?php
                    }
                }

                for ($i = $start_page; $i <= $end_page; $i++): ?>
                    <a href="?page=<?php echo $i . $filter_param; ?>" 
                       class="<?php echo ($i == $current_page) ? 'bg-indigo-600 text-white shadow-lg' : 'bg-white text-gray-700 hover:bg-gray-100'; ?> 
                        relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium transition duration-150">
                        <?php echo $i; ?>
                    </a>
                <?php endfor; ?>

                <?php 
                if ($end_page < $total_pages) {
                    if ($end_page < $total_pages - 1) {
                        ?>
                        <span class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-gray-700 text-sm font-medium">...</span>
                        <?php
                    }
                    ?>
                    <a href="?page=<?php echo $total_pages . $filter_param; ?>" class="bg-white text-gray-700 hover:bg-gray-100 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium transition duration-150"><?php echo $total_pages; ?></a>
                    <?php
                }
                ?>

                <?php if ($current_page < $total_pages): ?>
                    <a href="?page=<?php echo $current_page + 1 . $filter_param; ?>"
                        class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-r-md text-gray-700 bg-white hover:bg-indigo-500 hover:text-white transition duration-150">
                        Next
                    </a>
                <?php endif; ?>

            </nav>
        </div>
</body>

</html>