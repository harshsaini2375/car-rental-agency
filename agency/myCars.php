<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'agency') {
    header('Location: ../public/login.php');
    exit;
}

include '../config.php';

$agency_id = $_SESSION['user_id'];
$cars = [];

// Fetch all cars for this agency
$sql = "SELECT car_id, model, vehicle_number, seating_capacity, rent_per_day, 
               fuel_type, transmission, year, color, image_url, status 
        FROM cars 
        WHERE agency_id = ? 
        ORDER BY car_id DESC";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $agency_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
while ($row = mysqli_fetch_assoc($result)) {
    $cars[] = $row;
}
mysqli_stmt_close($stmt);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Cars | Dream Drive</title>
    <link rel="stylesheet" href="/car/style.css">
   
</head>
<body>
    <?php include('../reuse/navbar.php'); ?>
    
    <main class="my-cars-page">
        <div class="container">
            <div class="cars-header">
                <h1>My Cars</h1>
                <a href="addCar.php" class="add-car-btn">+ Add New Car</a>
            </div>


            <?php if (empty($cars)): ?>
                <div class="empty-message">
                    <p>You haven't listed any cars yet.</p>
                    <a href="addCar.php" class="btn btn-primary btn-dark" style="margin-top: 15px; display: inline-block;">Add Your First Car</a>
                </div>
            <?php else: ?>

                <div class="cars-grid">
                    <?php foreach ($cars as $car): ?>
                        <div class="car-card">

                
                            <div class="car-image">
                                <?php if (!empty($car['image_url'])): ?>
                                    <img src="<?php echo htmlspecialchars($car['image_url']); ?>" alt="<?php echo htmlspecialchars($car['model']); ?>" style="width: 100%; height: 100%; object-fit: cover;">
                                <?php else: ?>
                                    🚗
                                <?php endif; ?>
                            </div>

                            <div class="car-info">
                                <h3 class="car-model"><?php echo htmlspecialchars($car['model']); ?></h3>
                                <div class="car-details">
                                    <p><strong>Vehicle No:</strong> <?php echo htmlspecialchars($car['vehicle_number']); ?></p>
                                    <p><strong>Seats:</strong> <?php echo $car['seating_capacity']; ?> persons</p>
                                    <p><strong>Fuel:</strong> <?php echo $car['fuel_type']; ?> | <strong>Trans:</strong> <?php echo $car['transmission']; ?></p>
                                    <p><strong>Year:</strong> <?php echo $car['year']; ?> | <strong>Color:</strong> <?php echo htmlspecialchars($car['color'] ?? 'N/A'); ?></p>
                                </div>
                                <div class="car-price">₹<?php echo number_format($car['rent_per_day']); ?> <span style="font-size: 0.9rem;">/ day</span></div>
                                <div class="car-status status-<?php echo $car['status']; ?>">
                                    <?php echo ucfirst($car['status']); ?>
                                </div>

                                <!-- WE HAVE TO WORK ON IT -->
                                <div class="car-actions">

                                    <a href="editCar.php?id=<?php echo $car['car_id']; ?>" class="btn-sm btn-edit">Edit</a>

                                    <a href="deleteCar.php?id=<?php echo $car['car_id']; ?>" class="btn-sm btn-delete" onclick="return confirm('Are you sure you want to delete this car? This action cannot be undone.');">Delete</a>

                                </div>

                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

            <?php endif; ?>



        </div>
    </main>

    <?php include('../reuse/footer.php'); ?>
</body>
</html>