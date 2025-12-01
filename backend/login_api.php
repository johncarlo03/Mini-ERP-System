<?php 
include "../db.php";

if(isset($_SESSION['roles'])){
    if ($_SESSION['roles'] === "staff") {
        header("Location: staff/staff.php");
        exit();
    } elseif ($_SESSION['roles'] === "admin"){
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
            // 3. Use a prepared statement to prevent SQL Injection
            $sql = "SELECT id, password_hash, name, roles FROM users WHERE email = :email";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':email', $email);
            $stmt->execute();

            $user = $stmt->fetch();

            // 4. Check if a user was found
            if ($user) {
                // 5. Securely verify the password hash using password_verify()
                if (password_verify($password, $user['password_hash'])) {
                    
                    // --- SUCCESSFUL LOGIN ---
                    // Set session variables
                    $_SESSION['id'] = $user['id'];
                    $_SESSION['name'] = $user['name'];
                    $_SESSION['roles'] = $user['roles']; // Store the user's role

                    // 6. Redirect based on the stored role
                    if ($user['roles'] === "staff") {
                        header("Location: staff/staff.php");
                        exit();
                    } elseif ($user['roles'] === "admin") {
                        header("Location: admin/admin.php");
                        exit();
                    } else {
                        // Default redirection for standard users
                        $success_message = "Login successful! Welcome back, " . htmlspecialchars($user['username']) . ".";
                        // Example: header("Location: user_dashboard.php");
                        // exit();
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