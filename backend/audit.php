<?php

include "../../db.php"; 

$records_per_page = 11;

$current_page = (isset($_GET['page']) && is_numeric($_GET['page'])) ? (int)$_GET['page'] : 1;
$selected_action = isset($_GET['action']) ? $_GET['action'] : '';

$where = '';
$params = [];

if (!empty($selected_action)) {
    $where = " WHERE a.action LIKE :action_filter";
    $params[':action_filter'] = '%' . $selected_action . '%';
}

$total_records_query = "SELECT COUNT(*) FROM audit_logs a JOIN USERS u ON a.user_id = u.id" . $where;
$stmt_count = $conn->prepare($total_records_query);

if (!empty($params)) {
    $stmt_count->bindParam(':action_filter', $params[':action_filter'], PDO::PARAM_STR);
}

$stmt_count->execute();
$total_records = $stmt_count->fetchColumn();

$offset = ($current_page - 1) * $records_per_page;

$total_pages = ceil($total_records / $records_per_page);

if ($current_page > $total_pages) {
    $current_page = $total_pages > 0 ? $total_pages : 1;
}

$offset = ($current_page - 1) * $records_per_page;
if ($offset < 0) $offset = 0;

$audit_logs_query = "
    SELECT a.id, a.action, u.name, a.date_time FROM 
    audit_logs a 
    JOIN USERS u ON a.user_id = u.id
    " . $where . "
    ORDER BY a.date_time DESC
    LIMIT :limit OFFSET :offset";

$stmt = $conn->prepare($audit_logs_query);
if (!empty($params)) {
    $stmt->bindParam(':action_filter', $params[':action_filter'], PDO::PARAM_STR);
}

$stmt->bindParam(':limit', $records_per_page, PDO::PARAM_INT);
$stmt->bindParam(':offset', $offset, PDO::PARAM_INT);

$stmt->execute();
$logs = $stmt->fetchAll();


?>