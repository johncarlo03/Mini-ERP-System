<?php 
include "../api/create_staff.php"
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form method="POST" action="">
        <input type="text" name="name" placeholder="Full Name">
        <input type="text" name="email" placeholder="Email">
        <input type="text" name="password" placeholder="Password">
        <input type="text" name="password_confirm" placeholder="Password Confirm">
        <button type="submit" name="signup">Sign Up</button>
    </form>

    <p><?php
    if (!empty($error_message)) {
        echo "<p style='color:red;'>$error_message</p>";
    } 
    ?></p> 
</body>
</html>