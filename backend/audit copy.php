<?php

include "../../db.php"; // Assuming this file connects to your database

$records_per_page = 11;

// 2. Determine the current page number
// The 'page' number will be passed via the URL, e.g., logs.php?page=2
if (isset($_GET['page'])) {
    $current_page = (int)$_GET['page'];
} else {
    $current_page = 1; // Default to page 1
}

// 3. Calculate the OFFSET for the SQL query
// OFFSET = (current_page - 1) * records_per_page
$offset = ($current_page - 1) * $records_per_page;

// 4. Get the total number of records
$total_records_query = "SELECT COUNT(*) FROM audit_logs";
$total_records = $conn->query($total_records_query)->fetchColumn();

$total_pages = ceil($total_records / $records_per_page);
$audit_logs_query = "
    SELECT a.id, a.action, u.name, a.date_time FROM 
    audit_logs a 
    JOIN USERS u ON a.user_id = u.id
    ORDER BY a.date_time DESC
    LIMIT :limit OFFSET :offset";

$stmt = $conn->prepare($audit_logs_query);
$stmt->bindParam(':limit', $records_per_page, PDO::PARAM_INT);
$stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$logs = $stmt->fetchAll();

function categorize_action($action_string) {
    // Convert to lowercase for case-insensitive checking
    $action = strtolower($action_string);

    // Use string searching to map specific actions to categories
    if (strpos($action, 'logged in') !== false || strpos($action, 'logged out') !== false || strpos($action, 'password reset') !== false) {
        return 'Authentication';
    } elseif (strpos($action, 'created') !== false || strpos($action, 'added') !== false) {
        return 'Creation';
    } elseif (strpos($action, 'updated') !== false || strpos($action, 'edited') !== false) {
        return 'Update';
    } elseif (strpos($action, 'deleted') !== false || strpos($action, 'removed') !== false) {
        return 'Deletion';
    } elseif (strpos($action, 'system') !== false || strpos($action, 'settings') !== false) {
        return 'System/Admin';
    } else {
        return 'Other'; // Fallback category
    }
}

// 3. Process Logs to Add the Category

foreach ($logs as &$log) { // Use & to modify the array elements directly
    $log['category'] = categorize_action($log['action']);
}
unset($log); // Always unset the reference after the loop

?>