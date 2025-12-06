<?php
include "../../backend/create_staff.php";
// Assuming $staffs, $error_message, and $success_message are available here
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Staff Account</title>
    <link rel="stylesheet" href="../../css/admin.css">
    <script src="../../script/staff.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background-color: #f4f7f9;
        }
    </style>
</head>
<body>
    <?php include "sidebar.php"; ?>
    
    <div class="ml-64 p-10">
        <h1 class="text-3xl font-bold mb-8 text-gray-800">Staff Management</h1>
        
        <div class="bg-white p-8 rounded-lg shadow-xl w-full mb-8"> 
            
            <div class="flex justify-end space-x-3 mb-6">
                <button 
                    id="resetBtn" 
                    onclick="resetForm()" 
                    hidden
                    type="button"
                    class="px-4 py-2 bg-gray-500 text-white font-semibold rounded-lg hover:bg-gray-600 transition duration-200"
                >
                    Cancel Edit / Create New
                </button>
                
                <button 
                    id="deleteBtn" 
                    onclick="document.getElementById('deleteForm').submit()" 
                    hidden
                    type="button"
                    class="px-4 py-2 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 transition duration-200"
                >
                    Delete Staff
                </button>
            </div>
            
            <form method="POST" action="" class="space-y-6">
                <input type="hidden" id="id" name="id">
                <input type="hidden"> <div class="flex space-x-4">
                    <input 
                        type="text" 
                        id="name"
                        name="name" 
                        placeholder="Full Name"
                        required
                        class="w-1/2 p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-150"
                    >
                    <input 
                        type="email" 
                        name="email"
                        id="email"
                        placeholder="Email Address"
                        required
                        class="w-1/2 p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-150"
                    >
                </div>

                <div class="flex space-x-4">
                    <input 
                        type="password" 
                        name="password" 
                        placeholder="Password (Leave blank when editing)"
                        id="pw"
                        required
                        class="w-1/2 p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-150"
                    >
                    <input 
                        type="password" 
                        name="password_confirm" 
                        placeholder="Confirm Password"
                        id="rpw"
                        required
                        class="w-1/2 p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-150"
                    >
                </div>
                
                <div class="flex space-x-4">
                    <select 
                        name="role" 
                        id="role" 
                        required
                        class="w-1/2 p-3 border border-gray-300 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-150"
                    >
                        <option value="">Select Role</option>
                        <option value="staff">Staff</option>
                        <option value="admin">Admin</option>
                    </select>
                    <div class="w-1/2"></div>
                </div>

                <button 
                    type="submit" 
                    name="signup"
                    id="submitBtn"
                    class="w-full bg-blue-600 text-white font-semibold py-3 rounded-lg hover:bg-blue-700 transition duration-200 focus:outline-none focus:ring-4 focus:ring-blue-300"
                >Create Staff Account
                </button>


            </form>
        </div>

        <form method="POST" action="../../backend/delete_item.php" id="deleteForm">
            <input type="hidden" name="action" value="delete_user">
            <input type="hidden" id="delete_user_id" name="delete_user_id">
        </form>


        <?php if (!empty($error_message)): ?>
            <p class="mt-4 p-3 bg-red-100 border border-red-400 text-red-700 rounded-lg w-full mb-8">
                <?php echo htmlspecialchars($error_message); ?>
            </p>
        <?php endif; ?>

        <?php if (!empty($success_message)): ?>
            <p class="mt-4 p-3 bg-green-100 border border-green-400 text-green-700 rounded-lg w-full mb-8">
                <?php echo htmlspecialchars($success_message); ?>
            </p>
        <?php endif; ?>

        <h2 class="text-2xl font-semibold mb-4 text-gray-700">Existing Staff</h2>

        <div class="bg-white rounded-lg shadow-xl overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php if (!empty($staffs)): ?>
                        <?php foreach ($staffs as $staff): ?>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"><?php echo htmlspecialchars($staff['id']); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo htmlspecialchars($staff['name']); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo htmlspecialchars($staff['email']); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        <?php echo ($staff['roles'] == 'admin') ? 'bg-indigo-100 text-indigo-800' : 'bg-green-100 text-green-800'; ?>">
                                        <?php echo htmlspecialchars(ucfirst($staff['roles'])); ?>
                                    </span>
                                </td>
                                <td class="px-6 text-center py-4 whitespace-nowrap text-sm font-medium">
                                    <button 
                                        onclick="fillForm(
                                            <?= $staff['id'] ?>,
                                            '<?= htmlspecialchars($staff['name']) ?>',
                                            '<?= htmlspecialchars($staff['email']) ?>',
                                            '<?= htmlspecialchars($staff['roles']) ?>'
                                        )"
                                        class="text-indigo-600 hover:text-indigo-900 font-semibold transition duration-150">
                                        Edit
                                    </button>
                            <form action="../../backend/delete_item.php" method="POST" style="display:inline-block;  margin-left:5px;" class="text-red-600 hover:text-red-900 font-semibold transition duration-150">
                                <input type="hidden" name="action" value="delete_user">
                                <input type="hidden" name="delete_user_id" value="<?= $staff['id'] ?>">
                                <button type="submit" id="deleteBtn">Delete</button>
                            </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">No staff accounts found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>


</body>
</html>