<?php
session_start();

try {
    $conn = new PDO("mysql:host=localhost;dbname=mini_erp", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
