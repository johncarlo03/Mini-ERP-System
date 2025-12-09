<?php
include "../../db.php"; 

$stock_sql = "SELECT COUNT(*) FROM inventory";
$stmt_stock = $conn->query($stock_sql);
$total_inventory = $stmt_stock->fetchColumn();

$low_stock_sql = "SELECT COUNT(*) FROM inventory where qty <= 5";
$stmt_low_stock = $conn->query($low_stock_sql);
$low_stock_items = $stmt_low_stock->fetchColumn();

$total_pending_orders = "SELECT COUNT(*) FROM purchase_orders WHERE status = 'Pending';";
$stmt_orders = $conn->query($total_pending_orders);
$pending_orders = $stmt_orders->fetchColumn();


$total_staffs_sql = "SELECT COUNT(*) FROM users WHERE roles = 'staff'";
$stmt_staffs = $conn->query($total_staffs_sql);
$total_staffs = $stmt_staffs->fetchColumn();


$recent_logs_sql = "
    SELECT 
        a.action, 
        u.name AS user_name, 
        a.date_time
    FROM 
        audit_logs a 
    JOIN 
        users u ON a.user_id = u.id
    ORDER BY 
        a.date_time DESC
    LIMIT 5"; // Fetches the 5 most recent activities

$stmt_logs = $conn->query($recent_logs_sql);
$raw_logs = $stmt_logs->fetchAll(PDO::FETCH_ASSOC);

// Reformat the logs to match the structure expected by the HTML loop
$recent_logs = [];
foreach ($raw_logs as $log) {
    // Note: You may want to add date formatting logic here (e.g., "10 minutes ago")
    // For simplicity, we just extract the time part of date_time for the 'time' field.
    $recent_logs[] = [
        'time' => (new DateTime($log['date_time']))->format('D, g:i A'), // Example formatting
        'action' => $log['action'],
        'user' => $log['user_name'],
    ];
}

$chart_data_sql = "
    SELECT 
        DATE_FORMAT(date_time, '%Y-%m') AS month_year,
        DATE_FORMAT(date_time, '%b') AS month_label,
        COUNT(id) AS actions_count
    FROM audit_logs
    WHERE action LIKE '%Item%' OR action LIKE '%PO%'
    GROUP BY month_year, month_label
    ORDER BY month_year ASC
    LIMIT 6";

$stmt_chart = $conn->query($chart_data_sql);
$chart_results = $stmt_chart->fetchAll(PDO::FETCH_ASSOC);

$monthly_data = [];
$month_labels = [];

foreach ($chart_results as $row) {
    $month_labels[] = $row['month_label'];
    $monthly_data[] = (int)$row['actions_count'];
}

$sales_count_sql = "SELECT COUNT(*) FROM sales";
$stmt_sales_count = $conn->query($sales_count_sql);
$total_sales = $stmt_sales_count->fetchColumn();


$revenue_sql = "SELECT SUM(total_amount) FROM sales";
$stmt_revenue = $conn->query($revenue_sql);
$total_revenue = $stmt_revenue->fetchColumn();

$total_revenue_formatted = '₱ ' .number_Format($total_revenue, 2);
?>