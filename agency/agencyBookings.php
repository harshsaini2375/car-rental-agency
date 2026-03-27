<?php
session_start();

// Only logged-in agencies can view this page
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'agency') {
    header('Location: ../public/login.php');
    exit;
}

include '../config.php';

$agency_id = $_SESSION['user_id'];

// Fetch all bookings for cars belonging to this agency
$sql = "SELECT b.booking_id, b.start_date, b.end_date, b.total_amount, b.status as booking_status, 
               b.payment_status,
               c.model, c.vehicle_number, c.rent_per_day,
               cu.full_name as customer_name, cu.email as customer_email, cu.phone as customer_phone
        FROM bookings b
        JOIN cars c ON b.car_id = c.car_id
        JOIN customers cu ON b.customer_id = cu.customer_id
        WHERE c.agency_id = ?
        ORDER BY b.booking_date DESC";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $agency_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$bookings = [];
while ($row = mysqli_fetch_assoc($result)) {
    $bookings[] = $row;
}
mysqli_stmt_close($stmt);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agency Bookings | Dream Drive</title>
    <link rel="stylesheet" href="/car/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
   
</head>
<body>
    <?php include('../reuse/navbar.php'); ?>
    <main class="agency-bookings-page">
        <div class="container">
            <div class="bookings-header">
                <h1>Booking Requests</h1>
                <p>View all reservations for your fleet</p>
            </div>

            <?php if (empty($bookings)): ?>
                <div class="empty-message">
                    <i class="fas fa-calendar-alt" style="font-size: 3rem; color: #ddd; margin-bottom: 15px; display: block;"></i>
                    <p>No bookings for your cars yet.</p>
                </div>
                
            <?php else: ?>
                <div class="bookings-table-container">
                    <table class="bookings-table">
                        <thead>
                            <tr>
                                <th>Booking ID</th>
                                <th>Customer</th>
                                <th>Car Model</th>
                                <th>Vehicle No.</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Total Amount</th>
                                <th>Status</th>
                                <th>Payment</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($bookings as $booking): ?>
                                <tr>
                                    <td>#<?php echo $booking['booking_id']; ?></td>
                                    <td>
                                        <?php echo htmlspecialchars($booking['customer_name']); ?><br>
                                        <small style="color: #888;"><?php echo htmlspecialchars($booking['customer_email']); ?></small>
                                    </td>
                                    <td><?php echo htmlspecialchars($booking['model']); ?></td>
                                    <td><?php echo htmlspecialchars($booking['vehicle_number']); ?></td>
                                    <td><?php echo date('d M Y', strtotime($booking['start_date'])); ?></td>
                                    <td><?php echo date('d M Y', strtotime($booking['end_date'])); ?></td>
                                    <td>₹<?php echo number_format($booking['total_amount']); ?></td>
                                    <td>
                                        <span class="status-badge status-<?php echo $booking['booking_status']; ?>">
                                            <?php echo ucfirst($booking['booking_status']); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="status-badge payment-<?php echo $booking['payment_status']; ?>">
                                            <?php echo ucfirst($booking['payment_status']); ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </main>
    <?php include('../reuse/footer.php'); ?>
</body>
</html>