<?php
require '../db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST"){

    if(!isset($_POST['delete_id']) || empty($_POST['delete_id'])){
        die("No Id");
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
?>
