<?php
require '../../db.php';

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = isset($_POST["id"]) ? trim($_POST["id"]) : '';
    $item_name = trim($_POST['item_name']);
    $description = trim($_POST['description']);
    $qty = (int)$_POST['qty'];
    $user_id = $_SESSION['id'];

    
    if (empty($item_name) || $qty < 0) {
        $message = '<div>Error: Item Name is required and Quantity must be 0 or more.</div>';
    } elseif(!empty($id)){

        $item_edit = "SELECT item_name, description, qty FROM inventory WHERE id = ?";
        $item_edit_stmt = $conn->prepare($item_edit);
        $item_edit_stmt->execute([$id]);
        $edited_item = $item_edit_stmt->fetch(PDO::FETCH_ASSOC);

        $edit_sql = "UPDATE inventory SET item_name = ?, qty = ?, description = ? WHERE id = ?";
        $edit_stmt = $conn->prepare($edit_sql);
        $edit_stmt->execute([$item_name, $qty, $description, $id]);

        $action_logs = [];
        if($edited_item['item_name'] !== $item_name){
            $action_logs[] = "Item name changed to {$item_name} ";
        }

        if($edited_item['qty'] != $qty){
            $action_logs[] = "$item_name quantity changed from {$edited_item['qty']} to {$qty} ";
        }

        if (empty($action_logs)) {
        $action = "Item (ID: {$id}) updated, but no logged fields were changed.";
            } else {
        // Combine all changes into one string for the log
        $action = "Inventory Update (ID: {$id}): " . implode("and ", $action_logs);
    }

        $log_sql = "INSERT INTO audit_logs (user_id, action, date_time) VALUES (?, ?, NOW())";
        $log_stmt = $conn->prepare($log_sql);
        $log_stmt->execute([$user_id, $action]);
    } else {
        try {
            $check_sql = "SELECT COUNT(*) FROM inventory WHERE item_name = ?";
            $check_stmt = $conn->prepare($check_sql);
            $check_stmt->execute([$item_name]);
            
            $count = $check_stmt->fetchColumn();
            
            if($count > 0){
                $message = '<div>Error: Item **"' . htmlspecialchars($item_name) . '"** already exists in inventory.</div>';
            } else {
            $sql = "INSERT INTO inventory (item_name, description, qty) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$item_name, $description, $qty]);

            $message = '<div>Item **"' . htmlspecialchars($item_name) . '"** added successfully!</div>';

            $action = "Added item: " . $item_name . " (Qty: " . $qty . ")";
            $log_sql = "INSERT INTO audit_logs (user_id, action, date_time) VALUES (?, ?, NOW())";
            $log_stmt = $conn->prepare($log_sql);
            $log_stmt->execute([$user_id, $action]);

            }
            
        } catch (PDOException $e) {
            $message = '<div>Database Error: ' . $e->getMessage() . '</div>';
        }
    }
}

// ====================================================================
// 3. FETCH ALL INVENTORY ITEMS (VIEW STOCK LEVELS)
// ====================================================================
try {
    $sql = "SELECT id, item_name, description, qty FROM inventory ORDER BY item_name ASC";
    $stmt = $conn->query($sql);
    $items = $stmt->fetchAll();
} catch (PDOException $e) {
    $error_message = "Error fetching inventory: " . $e->getMessage();
    $items = [];
}
?>