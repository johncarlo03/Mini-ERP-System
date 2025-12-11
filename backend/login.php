<?php
include "../db.php";

if (isset($_SESSION['roles'])) {
    if ($_SESSION['roles'] === "staff") {
        header("Location: staff/sales.php");
        exit();
    } elseif ($_SESSION['roles'] === "admin") {
        header("Location: admin/admin.php");
        exit();
    }
}

if (isset($_POST['login'])) {

    // 2. Retrieve and sanitize user input
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        $error_message = "Please enter both email and password.";
    } else {
        $sql = "SELECT id, password_hash, name, roles FROM users WHERE email = :email";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        $user = $stmt->fetch();


        if ($user) {
            if (password_verify($password, $user['password_hash'])) {

                $_SESSION['id'] = $user['id'];
                $_SESSION['name'] = $user['name'];
                $_SESSION['roles'] = $user['roles'];

                $log_sql = "INSERT INTO audit_logs (user_id, action, date_time) VALUES (?, ?, NOW())";
                $log_stmt = $conn->prepare($log_sql);

                if ($user['roles'] === "staff") {
                    $log_stmt->execute([$_SESSION['id'], "Staff logged in."]);
                    header("Location: staff/sales.php");
                    exit();
                } elseif ($user['roles'] === "admin") {
                    $log_stmt->execute([$_SESSION['id'], "Administrator logged in."]);
                    header("Location: admin/admin.php");
                    exit();
                }

            } else {
                $error_message = "Invalid email or password.";
            }
        } else {
            $error_message = "Invalid email or password.";
        }
    }
}
?>