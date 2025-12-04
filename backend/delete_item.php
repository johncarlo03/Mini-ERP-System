<?php
require '../db.php';
if ($_SERVER["REQUEST_METHOD"] === "POST" && ($_POST['action'] ?? '') == 'delete_item'){

    if(!isset($_POST['delete_id']) || empty($_POST['delete_id'])){
        $_SESSION['error_message'] = "Error: No item ID was provided for deletion.";
        header("Location: ../user/admin/inventory_management.php");
        exit;
    }

    $id = trim($_POST['delete_id']);
    $admin_name = trim($_SESSION["name"]);

    try{
    $sql = "DELETE FROM inventory WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id]);
    header("Location: ../user/admin/inventory_management.php");
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
    $admin_name = trim($_SESSION["name"]);

    try{
    $sql = "DELETE FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id]);
    header("Location: ../user/admin/staff_creation.php");
    exit;
    } catch (PDOException $e) {
        die("Delete failed: " . $e->getMessage());
    }
    
}
?>
