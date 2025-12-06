<?php $activePage = basename($_SERVER['PHP_SELF']); ?>

<div class="sidebar">
            <div class="flex justify-center items-center p-4">
                <!-- <img src="{{ URL('images/logo.png') }}" alt="OVS Logo" class="mr-2 w-20 h-20 " /> -->
            </div>
            <div class="flex items-center mb-4 p-2">
                <!-- <img
                    src="{{ asset('uploads/admin/' . Auth::guard('admin')->user()->photo) }}"
                    alt="Profile"
                    class="rounded-full mr-2 w-20 h-20"
                /> -->
                <span style="font-size:20px; font-weight:bold;">ADMIN</span>
            </div>
            <span class="indicator">Reports</span>
            <a href="admin.php" class="<?= $activePage == 'admin.php' ? 'active' : '' ?>">Dashboard</a>
            <a href="staff_creation.php" class="<?= $activePage == 'staff_creation.php' ? 'active' : '' ?>">Staffs</a>
            <a href="inventory_management.php" class="<?= $activePage == 'inventory_management.php' ? 'active' : '' ?>">Inventory Management</a>
            <a href="logs.php" class="<?= $activePage == 'logs.php' ? 'active' : '' ?>">Audit Logs</a>
            <a href="supplier.php" class="<?= $activePage == 'supplier.php' ? 'active' : '' ?>">Supplier</a>
    
            <form action="../../backend/logout.php" class="flex flex-col justify-end mt-auto" method="POST">
                <div class="p-4">
                    <button class="w-full text-white px-6 py-2 rounded-full transition bg-[#3f5391] hover:bg-[#2C3D74]"type="submit">
                    Logout</button>
                </div>
            </form>
    </div>