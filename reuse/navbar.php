<?php
// Make sure session is started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<header class="site-header">
    <div class="container nav-container">
        <div class="logo">Dream Drive</div>
        <nav class="navbar">
            <ul class="nav-menu">
                <li><a href="/car/index.php" class="nav-link">Home</a></li>
                <li><a href="/car/public/availableCars.php" class="nav-link">Cars</a></li>
                <li><a href="/car/index.php#services" class="nav-link">Services</a></li>

                <?php if (isset($_SESSION['user_id'])): ?>
                    <!-- User is logged in -->
                    <li><a href="/car/mydashboard/dashboard.php" class="nav-link">Dashboard</a></li>
                    <li><span style="color: #e6b422;" class="nav-link">Hello, <?php echo htmlspecialchars($_SESSION['user_name']); ?></span></li>
                    <li><a href="/car/public/logout.php" class="navbtn btn-white">Logout</a></li>


                <?php else: ?>
                    <!-- Not logged in -->
                    <li><a href="/car/public/login.php" class="navbtn btn-white">Log in</a></li>


                <?php endif; ?>
            </ul>
        </nav>
    </div>
</header>


