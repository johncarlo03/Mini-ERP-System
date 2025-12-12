<?php if (!isset($_SESSION['id']) || $_SESSION['roles'] !== 'staff') {
    header("Location: ../login.php");
    exit();
}
$logged_in = "SELECT name FROM users where id = ?";
$logged_in_stmt = $conn->prepare($logged_in);
$logged_in_stmt->execute([$_SESSION["id"]]);
$logged_name = $logged_in_stmt->fetchColumn(); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<button id="toggleSidebar"
    class="fixed top-4 left-2.5 z-50 bg-[#3f5391] text-white px-3 py-2 rounded-lg shadow-md hover:bg-[#2C3D74] transition">
    ☰ </button>
<div id="sidebar" class="sidebar transition-all duration-300">
    <div class="flex justify-center items-center p-4 mt-4"></div>
    <div class="flex items-center mb-4 p-2"> <img class="profile rounded-full mr-2 w-14 h-14 flex-shrink-0"
            src="../../images/profile/placeholder.png" alt="Profile"> <span
            style="font-size:15px; font-weight:bold; white-space: nowrap;"><?= htmlspecialchars($logged_name) ?></span>
    </div> <a href="sales.php" class="<?= $activePage == 'sales.php' ? 'active' : '' ?> flex items-center space-x-3"> <i
            class="fas fa-cash-register fa-fw text-lg w-6 flex-shrink-0"></i> <span
            class="whitespace-nowrap">Sales</span> </a> <a href="supplier.php"
        class="<?= $activePage == 'supplier.php' ? 'active' : '' ?> flex items-center space-x-3"> <i
            class="fas fa-truck-loading fa-fw text-lg w-6 flex-shrink-0"></i> <span class="whitespace-nowrap">Purchase
            Orders</span> </a>
    <form action="../../backend/logout.php" method="POST" class="mt-auto p-4"> <button
            class="w-full bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-full transition"> Logout </button>
    </form>
</div>