<?php
include "../../backend/create_staff.php"; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Staff Account</title>
    <link rel="stylesheet" href="../../css/admin.css">
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
    
    <h1 class="text-3xl font-bold mb-8 text-gray-800">Create New Staff Member</h1>

    <div class="bg-white p-8 rounded-lg shadow-xl w-full"> 
        <button id="resetBtn" onclick="resetForm()" hidden>Reset</button>
        <form method="POST" action="" class="space-y-6">
            <input type="hidden" id="id" name="id">
            
            <div class="flex space-x-4">
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
                    placeholder="Password"
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
            
            <select name="role" id="role" required>
                    <option value="">Select Role</option>
                    <option value="staff">Staff</option>
                    <option value="admin">Admin</option>
            </select>

            <button 
                type="submit" 
                name="signup"
                class="w-full bg-blue-600 text-white font-semibold py-3 rounded-lg hover:bg-blue-700 transition duration-200 focus:outline-none focus:ring-4 focus:ring-blue-300"
            >
                Create Staff Account
            </button>

            <button id="editBtn" hidden>Edit</button>

        </form>
        <button id="deleteBtn" hidden>Delete</button>
        <input type="hidden" id="delete_user_id" name="id">
    </div>

    <?php if (!empty($error_message)): ?>
        <p class="mt-4 p-3 bg-red-100 border border-red-400 text-red-700 rounded-lg w-full">
            <?php echo htmlspecialchars($error_message); ?>
        </p>
    <?php endif; ?>

    <?php if (!empty($success_message)): ?>
        <p class="mt-4 p-3 bg-green-100 border border-green-400 text-green-700 rounded-lg w-full">
            <?php echo htmlspecialchars($success_message); ?>
        </p>
    <?php endif; ?>

    <table>
            <thead>
                <tr>
                    <th>User ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($staffs as $staff): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($staff['id']); ?></td>
                        <td><?php echo htmlspecialchars($staff['name']); ?></td>
                        <td><?php echo htmlspecialchars($staff['email']); ?></td>
                        <td><?php echo htmlspecialchars($staff['roles']); ?></td>
                        <td>
                        <button onclick="fillForm(<?= $staff['id'] ?>,
                                        '<?= htmlspecialchars($staff['name']) ?>',
                                        '<?= htmlspecialchars($staff['email']) ?>',
                                        '<?= htmlspecialchars($staff['roles']) ?>'
                                    )">Edit
                        </button>
                            <form action="" style="display:inline-block; margin-left:5px;">
                                <input type="hidden" value="delete_user">
                                <button>Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
</div>

<script>
     function fillForm(id, name, email, role) {
    document.getElementById('id').value = id;
    document.getElementById('name').value = name;
    document.getElementById('email').value = email;
    document.getElementById('role').value = role;

    document.getElementById('delete_user_id').value = id;

    document.getElementById('deleteBtn').hidden = false;
    document.getElementById('editBtn').hidden = false;
    document.getElementById('resetBtn').hidden = false;
    document.getElementById('pw').required = false;
    document.getElementById('rpw').required = false;
    }

    function resetForm() {
    document.getElementById('delete_user_id').value = '';
    document.getElementById('id').value = '';
    document.getElementById('name').value = '';
    document.getElementById('email').value = '';
    document.getElementById('role').value = '';
    document.getElementById('deleteBtn').hidden = true;
    document.getElementById('editBtn').hidden = true;
    document.getElementById('resetBtn').hidden = true;
    document.getElementById('pw').required = true;
    document.getElementById('rpw').required = true;
    }
</script>
</body>
</html>