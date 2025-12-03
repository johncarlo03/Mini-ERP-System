<?php 
include "../../db.php";

$staff_sql = "SELECT id, name, email, roles FROM users ORDER BY id ASC";
$staffs = $conn->query($staff_sql)->fetchAll();

if (isset($_POST['signup'])) {

    // 2. Retrieve and sanitize user input
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $id = $_POST['id'] ?? '';
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $role = filter_input(INPUT_POST, 'role', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $password = $_POST['password'];
    $password_confirm = $_POST['password_confirm']; 
    if (!empty($id)) {

            if (!empty($password)) {
            if ($password !== $password_confirm) {
                $error_message = "Passwords do not match.";
            } elseif (strlen($password) < 8) {
                $error_message = "Password must be at least 8 characters.";
            } else {
                $password_hash = password_hash($password, PASSWORD_DEFAULT);

                $sql_update = "UPDATE users SET 
                    name = :name,
                    email = :email,
                    roles = :role,
                    password_hash = :password
                    WHERE id = :id";
                }
            } else {
                $sql_update = "UPDATE users SET 
                name = :name,
                email = :email,
                roles = :role
                WHERE id = :id";
            }

                $stmt_update = $conn->prepare($sql_update);
                $stmt_update->bindParam(':name', $name);
                $stmt_update->bindParam(':email', $email);
                $stmt_update->bindParam(':role', $role);
                $stmt_update->bindParam(':id', $id);

                if (!empty($password)) {
                    $stmt_update->bindParam(':password', $password_hash);
                }

                $stmt_update->execute();
                $success_message = "User updated successfully!";
                $staffs = $conn->query($staff_sql)->fetchAll();
    } elseif (empty($id)) {
        if (empty($name) || empty($email) || empty($password) || empty($password_confirm)) {
            $error_message = "All fields are required.";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error_message = "Please enter a valid email address.";
            } elseif ($password !== $password_confirm) {
                $error_message = "Passwords do not match.";
            } elseif (strlen($password) < 8) {
                $error_message = "Password must be at least 8 characters long.";
            } elseif ($role !== "staff" && $role !== "admin") {
            $error_message = "Please select a valid role.";
            } else {
            $sql_check = "SELECT id FROM users WHERE email = :email";
            $stmt_check = $conn->prepare($sql_check);
            $stmt_check->bindParam(':email', $email);
            $stmt_check->execute();

            if ($stmt_check->rowCount() > 0) {
                            $error_message = "An account with this email already exists.";
                        } else {
                            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                // 5. Insert new user using a prepared statement
                $sql_insert = "INSERT INTO users (name, email, password_hash, roles) VALUES (:name, :email, :password_hash, :roles)";
                $stmt_insert = $conn->prepare($sql_insert);
                
                $stmt_insert->bindParam(':name', $name);
                $stmt_insert->bindParam(':email', $email);
                $stmt_insert->bindParam(':password_hash', $hashed_password);
                $stmt_insert->bindParam(':roles', $role);
                
                $stmt_insert->execute();
                $staffs = $conn->query($staff_sql)->fetchAll();

                $user_id = $_SESSION['id'];
                $success_message = "Registration successful!";
                $action = "Administrator Created an Account.";
                $log_sql = "INSERT INTO audit_logs (user_id, action, date_time) VALUES (?, ?, NOW())";
                $log_stmt = $conn->prepare($log_sql);
                $log_stmt->execute([$user_id, $action]);
                }
            }
        }
    }
?>