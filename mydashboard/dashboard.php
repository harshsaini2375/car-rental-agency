<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../public/login.php');
    exit;
}

$user_type = $_SESSION['user_type'];
$user_name = $_SESSION['user_name'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Dream Drive</title>
    <link rel="stylesheet" href="/car/style.css">
</head>
<body>
    <?php include('../reuse/navbar.php'); ?>
    
    <div class="container dashboard-container">
        <h1>Welcome, <?php echo htmlspecialchars($user_name); ?>!</h1>
        
        <?php if ($user_type === 'customer'): ?>
            <!-- Customer Dashboard Content -->
            <div class="dashboard-grid">
                <div class="dashboard-card">
                    <h3>My Bookings</h3>
                    <p>View your rental history</p>
                    <a href="../customer/customerBookings.php" class="btn">View Bookings</a>
                </div>
                <div class="dashboard-card">
                    <h3>Browse Cars</h3>
                    <p>Rent a luxury car</p>
                    <a href="../public/availableCars.php" class="btn">Browse Cars</a>
                </div>
            </div>
            
        <?php else: ?>
            <!-- Agency Dashboard Content -->
            <div class="dashboard-grid">
                <div class="dashboard-card">
                    <h3>My Cars</h3>
                    <p>Manage your fleet</p>
                    <a href="../agency/myCars.php" class="btn">View Cars</a>
                </div>
                <div class="dashboard-card">
                    <h3>Add New Car</h3>
                    <p>List a new vehicle</p>
                    <a href="../agency/addCar.php" class="btn">Add Car</a>
                </div>
                <div class="dashboard-card">
                    <h3>View Bookings</h3>
                    <p>See who rented your cars</p>
                    <a href="../agency/agencyBookings.php" class="btn">View Bookings</a>
                </div>
            </div>
        <?php endif; ?>
    </div>
    
    <?php include('../reuse/footer.php'); ?>
</body>
</html>