<?php
require '../db.php';

$user_id = trim($_SESSION["id"]);
if ($_SERVER["REQUEST_METHOD"] === "POST" && ($_POST['action'] ?? '') == 'delete_item'){

    if(!isset($_POST['delete_id']) || empty($_POST['delete_id'])){
        $_SESSION['error_message'] = "Error: No item ID was provided for deletion.";
        header("Location: ../user/admin/inventory_management.php");
        exit;
    }

    $id = trim($_POST['delete_id']);

    try{

    $item_name = "SELECT item_name FROM inventory where id =?";
    $item_stmt = $conn->prepare($item_name);
    $item_stmt->execute([$id]);
    $deleted_item = $item_stmt->fetchColumn();

    $sql = "DELETE FROM inventory WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id]);

    $action = "Deleted Item: $deleted_item";
    $log_sql = "INSERT INTO audit_logs (user_id, action, date_time) VALUES (?, ?, NOW())";
    $log_stmt = $conn->prepare($log_sql);
    $log_stmt->execute([$user_id, $action]);
    header("Location: ../user/admin/inventory_management.php?deleted=1");
    exit;
    } catch (PDOException $e) {
        die("Delete failed: " . $e->getMessage());
    }
    
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && ($_POST['action'] ?? '') == 'delete_user'){

    if(!isset($_POST['delete_user_id']) || empty($_POST['delete_user_id'])){
        die("No Id");
    }
    $id = trim($_POST['delete_user_id']);

    try{
    $user_name = "SELECT name FROM users where id = ?";
    $user_stmt = $conn->prepare($user_name);
    $user_stmt->execute([$id]);
    $deleted_user = $user_stmt->fetchColumn();

    $sql = "DELETE FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id]);

    $action = "Deleted User: $deleted_user";
    $log_sql = "INSERT INTO audit_logs (user_id, action, date_time) VALUES (?, ?, NOW())";
    $log_stmt = $conn->prepare($log_sql);
    $log_stmt->execute([$user_id, $action]);
    
    header("Location: ../user/admin/staff_creation.php?deleted=1");
    exit;
    } catch (PDOException $e) {
        die("Delete failed: " . $e->getMessage());
    }
    
}
?>
