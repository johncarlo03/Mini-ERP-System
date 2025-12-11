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
        <h1 class="text-3xl font-bold mb-8 text-gray-800">Logs</h1>
        <div class="bg-white rounded-lg shadow-xl overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200" style="table-layout: fixed;">
                <thead class="bg-gray-50">
                    <tr>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/12">
                            Log ID</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-2/12">
                            Username</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-2/12">
                            Category</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-5/12">
                            Action</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-2/12">
                            Date & Time</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php foreach ($logs as $log): ?>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 truncate">
                                <?php echo htmlspecialchars($log['id']); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 truncate">
                                <?php echo htmlspecialchars($log['name']); ?></td>

                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-indigo-600 truncate">
                                <?php echo htmlspecialchars($log['category']); ?>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 truncate">
                                <?php echo htmlspecialchars($log['action']); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 truncate">
                                <?php echo htmlspecialchars($log['date_time']); ?></td>
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
                    <a href="?page=<?php echo $i; ?>" class="<?php echo ($i == $current_page) ? 'bg-indigo-500 text-white' : 'bg-white text-gray-700 hover:bg-gray-50'; ?> 
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
</body>

</html>