<?php
session_start();

// Only logged-in customers can book
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'customer') {
    header('Location: ../public/login.php');
    exit;
}

include '../config.php';

$customer_id = $_SESSION['user_id'];
$car_id = isset($_POST['car_id']) ? (int)$_POST['car_id'] : 0;
$days = isset($_POST['days']) ? (int)$_POST['days'] : 0;
$start_date = isset($_POST['start_date']) ? $_POST['start_date'] : '';

$errors = [];

// Validation
if ($car_id <= 0) $errors[] = "Invalid car selection.";
if ($days < 1 || $days > 30) $errors[] = "Number of days must be between 1 and 30.";
if (empty($start_date)) $errors[] = "Start date is required.";

// If validation passes, check car availability and calculate total
if (empty($errors)) {
    // Fetch car details
    $sql = "SELECT rent_per_day FROM cars WHERE car_id = ? AND status = 'available'";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $car_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $car = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);

    if (!$car) {
        $errors[] = "Car is not available for rent.";
    } else {
        $rent_per_day = $car['rent_per_day'];
        $total_amount = $rent_per_day * $days;
        $end_date = date('Y-m-d', strtotime($start_date . " + $days days"));

        // Insert booking
        $sql = "INSERT INTO bookings (customer_id, car_id, start_date, end_date, total_amount, status, payment_status) 
                VALUES (?, ?, ?, ?, ?, 'confirmed', 'pending')";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "iissd", $customer_id, $car_id, $start_date, $end_date, $total_amount);

        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_close($stmt);
            // here we can update status of car to rented
            header("Location: customerBookings.php?success=1");
            exit;
        } else {
            $errors[] = "Booking failed: " . mysqli_error($conn);
            mysqli_stmt_close($stmt);
        }
    }
}

// If we reach here, there were errors
if (!empty($errors)) {
    $_SESSION['booking_errors'] = $errors;
    header("Location: ../public/availableCars.php?error=1");
    exit;
}
?>