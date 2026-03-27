<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'agency') {
    header('Location: ../public/login.php');
    exit;
}

include '../config.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $car_id = (int)$_GET['id'];
    $agency_id = $_SESSION['user_id'];

    // Ensure the car belongs to the logged-in agency
    $sql = "DELETE FROM cars WHERE car_id = ? AND agency_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $car_id, $agency_id);
    
    if (mysqli_stmt_execute($stmt)) {
        // Success
        header('Location: myCars.php?deleted=1');
        exit;
    } else {
        // Error
        header('Location: myCars.php?error=delete_failed');
        exit;
    }
    mysqli_stmt_close($stmt);
} else {
    header('Location: myCars.php');
    exit;
}
?>