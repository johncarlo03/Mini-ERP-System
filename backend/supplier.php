<?php
require '../../db.php';

$message = '';
$error_message = '';


$suppliers_sql = "SELECT id, supplier_name, phone FROM suppliers WHERE is_deleted = 0 ORDER BY supplier_name ASC";
$suppliers = $conn->query($suppliers_sql)->fetchAll();

$inventory_sql = "SELECT id, item_name FROM inventory ORDER BY item_name ASC";
$inventory = $conn->query($inventory_sql)->fetchAll();

$po_sql = "SELECT p.id AS po_id, s.supplier_name, i.item_name, p.qty, p.status, p.date_created, p.date_received
            FROM purchase_orders p
            JOIN suppliers s ON p.supplier_id = s.id
            JOIN inventory i ON p.item_id = i.id
            ORDER BY p.date_created DESC LIMIT 10";

$purchase_orders = $conn->query($po_sql)->fetchAll();

if ($_SERVER["REQUEST_METHOD"] == "POST" && ($_POST['action'] ?? '') == 'add_supplier') {
    $name = trim($_POST['supplier_name']);
    $phone = trim($_POST['supplier_phone']);
    $user_id = $_SESSION['id'];


    $sql_check = "SELECT id FROM suppliers WHERE supplier_name = :supplier_name";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bindParam(':supplier_name', $name);
    $stmt_check->execute();

    if ($stmt_check->rowCount() > 0) {
        $error_message = 'This Supplier Already Exist!';
    } else {
        $sql = "INSERT INTO suppliers (supplier_name, phone) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$name, $phone]);

        $suppliers = $conn->query($suppliers_sql)->fetchAll();
        $message = '<div style="color: green;">Supplier Added successfully!</div>';


        $log_sql = "INSERT INTO audit_logs (user_id, action, date_time) VALUES (?, ?, NOW())";
        $log_stmt = $conn->prepare($log_sql);
        $log_stmt->execute([$user_id, "Added Supplier: " . $name]);
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && ($_POST['action'] ?? '') == 'create_po') {
    $supplier_id = (int) $_POST['supplier_id'];
    $item_id = (int) $_POST['item_id'];
    $po_qty = (int) $_POST['qty'];
    $user_id = $_SESSION['id'];

    $check_order = "SELECT COUNT(*) FROM purchase_orders WHERE status = 'Pending'";
    $order_stmt = $conn->prepare($check_order);
    $order_stmt->execute();
    $pending_count = $order_stmt->fetchColumn();

    if ($supplier_id <= 0 || $item_id <= 0 || $po_qty <= 0) {
        $err_message = '<div style="color: red;">Error: Please select a supplier, item, and enter a valid quantity.</div>';
    } elseif ($pending_count >= 10) {
        $err_message = '<div style="color: red;">Purchase Order Limit Reached! You currently have 10 pending Purchase Orders.</div>';
    } else {
        $sql = "INSERT INTO purchase_orders (supplier_id, item_id, qty, status, date_created) VALUES (?, ?, ?, 'Pending', NOW())";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$supplier_id, $item_id, $po_qty]);

        $log_sql = "INSERT INTO audit_logs (user_id, action, date_time) VALUES (?, ?, NOW())";
        $log_stmt = $conn->prepare($log_sql);
        $log_stmt->execute([$user_id, "Created PO for item ID: " . $item_id . " (Qty: " . $po_qty . ")"]);
        $purchase_orders = $conn->query($po_sql)->fetchAll();
        $message = '<div style="color: green;">Successfully Created a Purchase Order! Order Currently Pending.</div>';

    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && ($_POST['action'] ?? '') == 'receive_po') {
    $po_id = (int) $_POST['po_id'];
    $user_id = $_SESSION['id'];

    $conn->beginTransaction();

    $fetch_sql = "SELECT item_id, qty, status FROM purchase_orders WHERE id = ?";
    $fetch_stmt = $conn->prepare($fetch_sql);
    $fetch_stmt->execute([$po_id]);
    $po_data = $fetch_stmt->fetch();

    if (!$po_data || $po_data['status'] === 'Received') {
        $conn->rollBack();
        $err_message = '<div style="color: red;">Error: PO not found or already received.</div>';
    } else {
        $item_id = $po_data['item_id'];
        $received_qty = $po_data['qty'];

        $update_inventory = "UPDATE inventory SET qty = qty + ? WHERE id = ?";
        $update_stmt = $conn->prepare($update_inventory);
        $update_stmt->execute([$received_qty, $item_id]);

        $update_po = "UPDATE purchase_orders SET status = 'Received', date_received = NOW() WHERE id = ?";
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


if ($_SERVER["REQUEST_METHOD"] == "POST" && ($_POST['action'] ?? '') == 'edit_supplier') {
    $supplier_id = trim($_POST['supplier_id']);
    $user_id = $_SESSION['id'];

    if (($_POST['supplier_action'] ?? '') == 'edit') {
        $name = trim($_POST['supplier_name']);
        $phone = trim($_POST['supplier_phone']);

        $sql = "UPDATE suppliers SET supplier_name = ?, phone = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$name, $phone, $supplier_id]);

        $log_sql = "INSERT INTO audit_logs (user_id, action, date_time) VALUES (?, ?, NOW())";
        $log_stmt = $conn->prepare($log_sql);
        $log_stmt->execute([$user_id, "Supplier: " . $name . " is updated."]);
        $suppliers = $conn->query($suppliers_sql)->fetchAll();
        $message = '<div style="color: green;">Supplier updated successfully!</div>';
        $purchase_orders = $conn->query($po_sql)->fetchAll();
        header("Location: ../staff/supplier.php?edited=1");
    } elseif (($_POST['supplier_action'] ?? '') == 'delete') {
        $information_sql = "SELECT supplier_name, phone FROM suppliers WHERE id = ?";
        $information_stmt = $conn->prepare($information_sql);
        $information_stmt->execute([$supplier_id]);
        $information = $information_stmt->fetch();

        $name = $information['supplier_name'];
        $phone = $information['phone'];

        $log_sql = "INSERT INTO audit_logs (user_id, action, date_time) VALUES (?, ?, NOW())";
        $log_stmt = $conn->prepare($log_sql);
        $log_stmt->execute([$user_id, "Supplier: " . $name . " was deleted."]);

        $err_message = '<div style="color: red;">Supplier Deleted successfully!</div>';

        $sql = "UPDATE suppliers SET is_deleted = 1 WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$supplier_id]);
        $suppliers = $conn->query($suppliers_sql)->fetchAll();
        $purchase_orders = $conn->query($po_sql)->fetchAll();

        header("Location: ../staff/supplier.php?deleted=1");
    }
}
?>