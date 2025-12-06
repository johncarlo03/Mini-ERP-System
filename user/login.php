<?php
include "../backend/login.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ERP Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>

    <div class="login-card">
        <h2 class="login-title text-center mb-4">ERP System Login</h2>

        <?php if (!empty($error_message)) : ?>
            <div class="alert alert-danger text-center">
                <?= $error_message; ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="login.php">

            <div class="mb-3">
                <label class="form-label">Email Address</label>
                <input type="email" name="email" class="form-control p-3" placeholder="Enter your email" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control p-3" placeholder="Enter your password" required>
            </div>

            <button type="submit" name="login" class="btn btn-custom w-100 p-3 mt-2">
                Login
            </button>

        </form>

        <p class="text-center mt-3" style="font-size: 0.9rem;">
            © <?= date("Y"); ?> Mini ERP System
        </p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
