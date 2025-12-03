<?php
// ====================================================================
// 1. DATABASE CONNECTION AND INITIAL SETUP
// ====================================================================
require '../../db.php'; // Ensure your db_connect.php is in the same directory

$message = ''; // To display success or error messages

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = isset($_POST["id"]) ? trim($_POST["id"]) : '';
    $item_name = trim($_POST['item_name']);
    $description = trim($_POST['description']);
    $qty = (int)$_POST['qty'];
    $user_id = $_SESSION['id'];

    // Basic Validation
    if (empty($item_name) || $qty < 0) {
        $message = '<div>Error: Item Name is required and Quantity must be 0 or more.</div>';
    } elseif(!empty($id)){
        $edit_sql = "UPDATE inventory SET item_name = ?, qty = ?, description = ? WHERE id = ?";
        $edit_stmt = $conn->prepare($edit_sql);
        $edit_stmt->execute([$item_name, $qty, $description, $id]);
    } else {
        try {
            // Prepare the INSERT statement for inventory
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