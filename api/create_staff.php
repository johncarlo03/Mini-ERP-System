<?php 
include "../db.php";

if (isset($_POST['signup'])) {

    // 2. Retrieve and sanitize user input
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password']; 
    $password_confirm = $_POST['password_confirm']; 
    if (empty($name) || empty($email) || empty($password) || empty($password_confirm)) {
        $error_message = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = "Please enter a valid email address.";
    } elseif ($password !== $password_confirm) {
        $error_message = "Passwords do not match.";
    } elseif (strlen($password) < 8) {
        $error_message = "Password must be at least 8 characters long.";
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
                $sql_insert = "INSERT INTO users (name, email, password_hash, roles) VALUES (:name, :email, :password_hash, 'staff')";
                $stmt_insert = $conn->prepare($sql_insert);
                
                $stmt_insert->bindParam(':name', $name);
                $stmt_insert->bindParam(':email', $email);
                $stmt_insert->bindParam(':password_hash', $hashed_password);
                
                $stmt_insert->execute();

                $success_message = "Registration successful! You can now log in.";
                }
            }
        }   
?>