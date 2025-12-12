<?php
include "../../backend/dashboard_data.php";
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
    <link rel="stylesheet" href="../../css/admin.css">
    <script src="../../script/sidebar.js" defer></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <title>ERP Dashboard</title>
</head>
<body>
    <input type="hidden" id="sidebar_state_input" name="sidebar_state" value="expanded">
    <?php include "sidebar.php"; ?>

    <div id="mainContent" class="ml-64 p-10 min-h-screen bg-gray-100 <?= $initial_margin_class ?> fade-in-content">
        <div class="flex justify-between items-center mb-3">
            <h1 class="text-3xl font-bold mb-8 text-gray-800">📊 Admin Dashboard</h1>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 mb-6">

            <div class="bg-white p-6 rounded-xl shadow-lg border-l-4 border-indigo-500 transition duration-300 hover:shadow-2xl hover:scale-[1.03] metric-card-delay-1">
                <p class="text-sm font-medium text-gray-500">Total Inventory</p>
                <p class="text-3xl font-bold text-gray-900 mt-1"><?php echo $total_inventory; ?></p>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-lg border-l-4 border-red-500 transition duration-300 hover:shadow-2xl hover:scale-[1.03] metric-card-delay-2">
                <p class="text-sm font-medium text-gray-500">Low Stock Items</p>
                <p class="text-3xl font-bold text-red-600 mt-1"><?php echo $low_stock_items; ?></p>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-lg border-l-4 border-blue-500 transition duration-300 hover:shadow-2xl hover:scale-[1.03] metric-card-delay-3">
                <p class="text-sm font-medium text-gray-500">Pending Orders</p>
                <p class="text-3xl font-bold text-gray-900 mt-1"><?php echo $pending_orders; ?></p>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-lg border-l-4 border-green-500 transition duration-300 hover:shadow-2xl hover:scale-[1.03] metric-card-delay-4">
                <p class="text-sm font-medium text-gray-500">Total Staffs</p>
                <p class="text-3xl font-bold text-gray-900 mt-1"><?php echo $total_staffs; ?></p>
            </div>
        </div>

        <h2 class="text-2xl font-bold mb-4 text-gray-800">Sales Overview</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-8 mb-12">

            <div class="bg-white p-6 rounded-xl shadow-lg border-l-4 border-yellow-600 transition duration-300 hover:shadow-2xl hover:scale-[1.03]">
                <p class="text-sm font-medium text-gray-500">Total Sales Orders</p>
                <p class="text-3xl font-bold text-yellow-700 mt-1"><?php echo $total_sales; ?></p>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-lg border-l-4 border-green-600 transition duration-300 hover:shadow-2xl hover:scale-[1.03]">
                <p class="text-sm font-medium text-gray-500">Total Revenue</p>
                <p class="text-3xl font-bold text-green-700 mt-1"><?php echo $total_revenue_formatted; ?></p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <div class="lg:col-span-2 bg-white p-6 rounded-xl shadow-lg transition duration-200 hover:shadow-xl">
                <h2 class="text-xl font-semibold mb-4 text-gray-800">Inventory Movement (Last 6 Months)</h2>
                <div class="h-80">
                    <canvas id="inventoryChart"></canvas>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-lg transition duration-200 hover:shadow-xl">
                <h2 class="text-xl font-semibold mb-4 text-gray-800">🔔 Recent System Activity</h2>
                <ul class="space-y-4">
                    <?php foreach ($recent_logs as $log): ?>
                        <li class="flex justify-between items-start text-sm border-b pb-2 last:border-b-0 transition duration-100 hover:bg-gray-50 -mx-2 px-2 rounded">
                            <div class="flex min-w-0">

                                <span class="font-medium text-gray-800 w-24 mr-2 flex-shrink-0">
                                    <?php echo htmlspecialchars($log['user']); ?>
                                </span>

                                <span class="text-gray-600 flex-grow-1">
                                    <?php echo htmlspecialchars($log['action']); ?>
                                </span>
                            </div>

                            <span class="text-xs text-gray-400 ml-4 flex-shrink-0">
                                <?php echo htmlspecialchars($log['time']); ?>
                            </span>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <a href="logs.php" class="block mt-4 text-indigo-600 hover:text-indigo-800 text-sm font-medium transition duration-150 hover:underline">View All
                    Logs &rarr;</a>
            </div>

        </div>

    </div>

    <script>
        // ... (Chart.js script remains unchanged)
        const ctx = document.getElementById('inventoryChart').getContext('2d');
        const inventoryChart = new Chart(ctx, {
            type: 'line',
            data: {
                // PHP passes the data to JavaScript
                labels: <?php echo json_encode($month_labels); ?>,
                datasets: [{
                    label: 'Items Handled',
                    data: <?php echo json_encode($monthly_data); ?>,
                    backgroundColor: 'rgba(99, 102, 241, 0.1)', // Indigo-500 light
                    borderColor: 'rgba(99, 102, 241, 1)', // Indigo-500
                    borderWidth: 3,
                    tension: 0.4, // Makes the line curved
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false, // Allows setting a custom height (h-80)
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                    }
                }
            }
        });
    </script>
</body>

</html>