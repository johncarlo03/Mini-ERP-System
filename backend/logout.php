<?php
session_start();      // Start the session
require '../db.php';

    $user_name = $_SESSION['name'];
    $user_id = $_SESSION['id'];
    $user_role = $_SESSION['roles'];

    if ($user['roles'] === "staff") {
                        $log_stmt->execute([$_SESSION['id'], "Staff ". $_SESSION['name'] . " has logged in."]);
                        header("Location: staff/sales.php");
                        exit();
                    }
    $log_sql = "INSERT INTO audit_logs (user_id, action, date_time) VALUES (?, ?, NOW())";
    $log_stmt = $conn->prepare($log_sql);

    if($user_role === "admin") {
        $log_stmt->execute([$user_id, "Administrator ". $user_name . " logged out."]);
    }

    if($user_role === "staff") {
        $log_stmt->execute([$user_id, "Staff ". $user_name . " logged out."]);
    }                
    
    

session_unset();      // Remove all session variables
session_destroy();    // Destroy the session completely

header("Location: ../user/login.php");  // Redirect back to login page
exit();
?>
