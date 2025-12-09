<!-- Toggle Button (top left) -->
<button id="toggleSidebar"
    class="fixed top-4 left-2.5 z-50 bg-[#3f5391] text-white px-3 py-2 rounded-lg shadow-md hover:bg-[#2C3D74] transition">
    ☰
</button>

<!-- SIDEBAR -->
<div id="sidebar" class="sidebar transition-all duration-300">
    <div class="flex justify-center items-center p-4"></div>

    <div class="flex items-center mb-4 p-2">
        <span class="text-xl font-bold whitespace-nowrap">ADMIN</span>
    </div>

    <span class="indicator">Reports</span>

    <a href="admin.php" class="<?= $activePage == 'admin.php' ? 'active' : '' ?>">Dashboard</a>
    <a href="staff_creation.php" class="<?= $activePage == 'staff_creation.php' ? 'active' : '' ?>">Accounts</a>
    <a href="inventory_management.php" class="<?= $activePage == 'inventory_management.php' ? 'active' : '' ?>">Inventory Management</a>
    <a href="logs.php" class="<?= $activePage == 'logs.php' ? 'active' : '' ?>">Audit Logs</a>
    <a href="supplier.php" class="<?= $activePage == 'supplier.php' ? 'active' : '' ?>">Supplier</a>

    <form action="../../backend/logout.php" method="POST" class="mt-auto p-4">
        <button class="w-full bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-full transition">
            Logout
        </button>
    </form>
</div>
