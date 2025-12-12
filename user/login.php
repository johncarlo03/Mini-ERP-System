<?php
include "../backend/login.php";
// Assume $error_message is defined in login.php
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ERP Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../css/style.css">
    
    <style>
        /* Define a fade-in animation */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        /* Define a subtle hover pulse for the card */
        @keyframes subtlePulse {
            0% { box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05); }
            100% { box-shadow: 0 15px 25px -5px rgba(0, 0, 0, 0.2), 0 10px 10px -5px rgba(0, 0, 0, 0.04); }
        }
        
        .login-container {
            /* Full screen layout */
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            /* Background color matches the Tailwind gray-100 */
            background-color: #f3f4f6; 
        }

        .login-card-animated {
            /* Apply the entrance animation */
            animation: fadeIn 0.8s ease-out forwards;
            opacity: 0; /* Start invisible */
            /* Add pulse effect on hover */
            transition: all 0.3s ease;
        }

        .login-button-pulse:hover {
            animation: subtlePulse 0.5s forwards;
        }
    </style>
</head>

<body>
    <div class="login-container">

        <div class="login-card-animated w-full max-w-md bg-white p-8 rounded-2xl shadow-xl border border-gray-200">
            
            <h2 class="text-3xl font-extrabold text-gray-900 text-center mb-6">
                ERP System Login
            </h2>

            <?php if (!empty($error_message)): ?>
                <div class="p-3 mb-4 rounded-lg bg-red-100 text-red-700 border border-red-300 transition duration-300 alert-animation">
                    <?= $error_message; ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="login.php" class="space-y-6">

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                    <input type="email" id="email" name="email"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition duration-150"
                        placeholder="your.email@email.com" required>
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <input type="password" id="password" name="password"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition duration-150"
                        placeholder="••••••••" required>
                </div>

                <button type="submit" name="login"
                    class="login-button-pulse w-full bg-indigo-600 text-white font-semibold text-lg py-3 rounded-lg shadow-md hover:bg-indigo-700 transition duration-200 transform hover:scale-[1.01] focus:ring-4 focus:ring-indigo-300">
                    Sign In
                </button>

            </form>
        </div>

    </div>
</body>

</html>