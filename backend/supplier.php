<?php
require '../../db.php';

$message = '';
$error_message = '';


$suppliers_sql = "SELECT id, supplier_name, phone FROM suppliers ORDER BY supplier_name ASC";
$suppliers = $conn->query($suppliers_sql)->fetchAll();

$inventory_sql = "SELECT id, item_name FROM inventory ORDER BY item_name ASC";
$inventory = $conn->query($inventory_sql)->fetchAll();

$po_sql = "SELECT p.id AS po_id, s.supplier_name, i.item_name, p.qty, p.status, p.date_created
            FROM purchase_orders p
            JOIN suppliers s ON p.supplier_id = s.id
            JOIN inventory i ON p.item_id = i.id
            ORDER BY p.date_created DESC LIMIT 10";

$purchase_orders = $conn->query($po_sql)->fetchAll();

if($_SERVER["REQUEST_METHOD"] == "POST" && ($_POST['action'] ?? '') == 'add_supplier'){
    $name = trim($_POST['supplier_name']);
    $phone = trim($_POST['supplier_phone']);
    $user_id = $_SESSION['id'];


    $sql_check = "SELECT id FROM suppliers WHERE supplier_name = :supplier_name";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bindParam(':supplier_name', $name);
    $stmt_check->execute();

    if($stmt_check->rowCount() > 0){
        $error_message = 'This Supplier Already Exist!';
    } else {
    $sql = "INSERT INTO suppliers (supplier_name, phone) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$name, $phone]);

    $log_sql = "INSERT INTO audit_logs (user_id, action, date_time) VALUES (?, ?, NOW())";
    $log_stmt = $conn->prepare($log_sql);
    $log_stmt->execute([$user_id, "Added Supplier: ". $name]);
    }
}

if($_SERVER["REQUEST_METHOD"] == "POST" && ($_POST['action'] ?? '') == 'create_po'){
    $supplier_id = (int)$_POST['supplier_id'];
    $item_id = (int)$_POST['item_id'];
    $po_qty = (int)$_POST['qty'];
    $user_id = $_SESSION['id'];

    if ($supplier_id <= 0 || $item_id <= 0 || $po_qty <= 0) {
        $message = '<div style="color: red;">Error: Please select a supplier, item, and enter a valid quantity.</div>';
    } else {
    $sql = "INSERT INTO purchase_orders (supplier_id, item_id, qty, status, date_created) VALUES (?, ?, ?, 'Pending', NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$supplier_id, $item_id, $po_qty]);

    $log_sql = "INSERT INTO audit_logs (user_id, action, date_time) VALUES (?, ?, NOW())";
    $log_stmt = $conn->prepare($log_sql);
    $log_stmt->execute([$user_id, "Created PO for item ID: " . $item_id . " (Qty: " . $po_qty . ")"]);
    $purchase_orders = $conn->query($po_sql)->fetchAll();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && ($_POST['action'] ?? '') == 'receive_po'){
    $po_id = (int)$_POST['po_id'];
    $user_id = $_SESSION['id'];
    
    $conn->beginTransaction();

    $fetch_sql = "SELECT item_id, qty, status FROM purchase_orders WHERE id = ?";
    $fetch_stmt = $conn->prepare($fetch_sql);
    $fetch_stmt->execute([$po_id]);
    $po_data = $fetch_stmt->fetch();

    if (!$po_data || $po_data['status'] === 'Received') {
            $conn->rollBack();
            $message = '<div style="color: red;">Error: PO not found or already received.</div>';
        } else {
            $item_id = $po_data['item_id'];
            $received_qty = $po_data['qty'];

            $update_inventory = "UPDATE inventory SET qty = qty + ? WHERE id = ?";
            $update_stmt = $conn->prepare($update_inventory);
            $update_stmt->execute([$received_qty, $item_id]);

            $update_po = "UPDATE purchase_orders SET status = 'Received' WHERE id = ?";
            $update_po_stmt = $conn->prepare($update_po);
            $update_po_stmt->execute([$po_id]);

            $conn->commit();
            $purchase_orders = $conn->query($po_sql)->fetchAll();
            $message = '<div style="color: green;">Purchase Order received successfully! Inventory increased by ' . $received_qty . '.</div>';

            $log_sql = "INSERT INTO audit_logs (user_id, action, date_time) VALUES (?, ?, NOW())";
            $log_stmt = $conn->prepare($log_sql);
            $log_stmt->execute([$user_id, "Received PO ID " . $po_id . ", increasing stock."]);
        }
}
?>