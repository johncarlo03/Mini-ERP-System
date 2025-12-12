<?php
require '../../db.php';

$message = '';

$customer_sql = "SELECT id, name, phone FROM customers WHERE is_deleted = 0 ORDER BY name ASC";
$customers = $conn->query($customer_sql)->fetchAll();

$inventory_sql = "SELECT id, item_name, qty, price, image_path FROM inventory WHERE is_deleted = 0 ORDER BY item_name ASC";
$items = $conn->query($inventory_sql)->fetchAll();

if ($_SERVER["REQUEST_METHOD"] == "POST" && ($_POST['action'] ?? '') == 'add_customer') {
    $name = trim($_POST['customer_name']);
    $phone = trim($_POST['customer_phone']);
    $user_id = $_SESSION['id'];

    if (!empty($name)) {
        $sql = "INSERT INTO customers (name, phone) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$name, $phone]);

        $log_sql = "INSERT INTO audit_logs (user_id, action, date_time) VALUES (?, ?, NOW())";
        $log_stmt = $conn->prepare($log_sql);
        $log_stmt->execute([$user_id, "Customer: " . $name . " is added."]);
        $customers = $conn->query($customer_sql)->fetchAll();
        $message = '<div style="color: green;">Customer added successfully!</div>';
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && ($_POST['action'] ?? '') == 'create_sale') {
    $customer_id = $_POST['customer_id'];
    $item_id = $_POST['item_id'];
    $sold_qty = $_POST['qty'];
    $user_id = $_SESSION['id'];

    if ($customer_id < 0 || $item_id < 0 || $sold_qty <= 0) {
        $err_message = '<div style="color: red;">Error: Please select a customer, item, and enter a valid quantity.</div>';
    } else {
        $conn->beginTransaction();

        $stock_check_sql = "SELECT qty, item_name, price FROM inventory WHERE id = ?";
        $stock_stmt = $conn->prepare($stock_check_sql);
        $stock_stmt->execute([$item_id]);
        $item_data = $stock_stmt->fetch();

        $total_sold = $item_data['price'] * $sold_qty;

        if (!$item_data || $item_data['qty'] < $sold_qty) {
            $conn->rollback();
            $err_message = '<div style="color: red;">Error: Insufficient stock for ' . htmlspecialchars($item_data['item_name'] ?? 'item') . '. Only ' . ($item_data['qty'] ?? 0) . ' available.</div>';
        } else {
            $sale_sql = "INSERT INTO sales (customer_id, item_id, qty, total_amount, date_created) VALUES (?, ?, ?, ?, NOW())";
            $sale_stmt = $conn->prepare($sale_sql);
            $sale_stmt->execute([$customer_id, $item_id, $sold_qty, $total_sold]);

            $update_sql = "UPDATE inventory SET qty = qty - ? WHERE id = ?";
            $update_stmt = $conn->prepare($update_sql);
            $update_stmt->execute([$sold_qty, $item_id]);

            $conn->commit();
            $items = $conn->query($inventory_sql)->fetchAll();

            $customer_sql = "SELECT name FROM customers WHERE id = ?";
            $stmt_customer = $conn->prepare($customer_sql);
            $stmt_customer->execute([$customer_id]);
            $customer_name = $stmt_customer->fetchColumn();

            $message = '<div style="color: green;">Sale recorded successfully! Inventory updated.</div>';
            $log_sql = "INSERT INTO audit_logs (user_id, action, date_time) VALUES (?, ?, NOW())";
            $log_stmt = $conn->prepare($log_sql);
            $log_stmt->execute([$user_id, "Sold " . $sold_qty . " pcs of " . $item_data['item_name'] . " to " . $customer_name]);
        }


    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && ($_POST['action'] ?? '') == 'edit_customer') {
    $customer_id = trim($_POST['customer_id']);
    
    $user_id = $_SESSION['id'];

    if (($_POST['customer_action'] ?? '') == 'edit') {
        $name = trim($_POST['customer_name']);
        $phone = trim($_POST['customer_phone']);

        $sql = "UPDATE customers SET name = ?, phone = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$name, $phone, $customer_id]);

        $log_sql = "INSERT INTO audit_logs (user_id, action, date_time) VALUES (?, ?, NOW())";
        $log_stmt = $conn->prepare($log_sql);
        $log_stmt->execute([$user_id, "Customer: " . $name . " is updated."]);
        $customers = $conn->query($customer_sql)->fetchAll();
        $message = '<div style="color: green;">Customer updated successfully!</div>';
        header("Location: ../staff/sales.php?edited=1");
    } elseif (($_POST['customer_action'] ?? '') == 'delete') {
        $information_sql = "SELECT name, phone FROM customers WHERE id = ?";
        $information_stmt = $conn->prepare($information_sql);
        $information_stmt->execute([$customer_id]);
        $information = $information_stmt->fetch();

        $name = $information['name'];
        $phone = $information['phone'];

        $log_sql = "INSERT INTO audit_logs (user_id, action, date_time) VALUES (?, ?, NOW())";
        $log_stmt = $conn->prepare($log_sql);
        $log_stmt->execute([$user_id, "Customer: " . $name . " was deleted."]);

        $err_message = '<div style="color: red;">Customer Deleted successfully!</div>';

        $sql = "UPDATE customers SET is_deleted = 1 WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$customer_id]);

        $customers = $conn->query($customer_sql)->fetchAll();
        header("Location: ../staff/sales.php?deleted=1");
    }
}

$recent_sql = "SELECT s.id AS sale_id, c.name AS customer_name, i.item_name, s.qty AS quantity_sold, DATE_FORMAT(s.date_created, '%b %e, %Y %l:%i %p') AS sale_date_formatted, s.total_amount AS total_amount
                   FROM sales s
                   JOIN customers c ON s.customer_id = c.id
                   JOIN inventory i ON s.item_id = i.id
                   ORDER BY s.date_created DESC
                   LIMIT 10";

$sales_history = $conn->query($recent_sql)->fetchAll();

?>