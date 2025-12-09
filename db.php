<?php
session_start();
$current_url = $_SERVER['SCRIPT_NAME'];
$initial_margin_class = (isset($_SESSION['sidebar_initial_state']) && $_SESSION['sidebar_initial_state'] == 'collapsed') ? 'ml-16' : 'ml-64';

$activePage = basename($current_url);
try {
    $conn = new PDO("mysql:host=localhost;dbname=mini_erp", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
